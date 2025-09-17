<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use MailchimpMarketing\ApiClient;

class EarlyAccessController extends Controller
{
    /**
     * Get Mailchimp client instance
     */
    private function getMailchimpClient(): ?ApiClient
    {
        $apiKey = config('mailchimp.api_key');
        $serverPrefix = config('mailchimp.server_prefix');
        
        if (!$apiKey || !$serverPrefix) {
            return null;
        }
        
        $mailchimp = new ApiClient();
        $mailchimp->setConfig([
            'apiKey' => $apiKey,
            'server' => $serverPrefix,
        ]);
        
        return $mailchimp;
    }
    
    /**
     * Add subscriber to Mailchimp list
     */
    private function addToMailchimp(string $email): bool
    {
        try {
            $mailchimp = $this->getMailchimpClient();
            $listId = config('mailchimp.list_id');
            
            if (!$mailchimp || !$listId) {
                Log::warning('Mailchimp not configured properly');
                return false;
            }
            
            // Try to add/update the subscriber
            $response = $mailchimp->lists->setListMember($listId, md5(strtolower($email)), [
                'email_address' => $email,
                'status_if_new' => config('mailchimp.default_status', 'subscribed'),
                'tags' => ['early-access', 'reaneyai-launch'],
                'merge_fields' => [
                    'SOURCE' => 'ReaneyAI Website',
                    'SIGNUP' => now()->format('Y-m-d')
                ]
            ]);
            
            Log::info('Successfully added/updated email in Mailchimp', [
                'email' => $email,
                'mailchimp_id' => $response->id ?? null,
                'status' => $response->status ?? null
            ]);
            
            return true;
            
        } catch (\Exception $e) {
            Log::error('Failed to add email to Mailchimp', [
                'email' => $email,
                'error' => $e->getMessage()
            ]);
            
            return false;
        }
    }

    /**
     * Store a new early access signup
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Please enter a valid email address.',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Add to Mailchimp
            $mailchimpSuccess = $this->addToMailchimp($request->email);
            
            if ($mailchimpSuccess) {
                return response()->json([
                    'success' => true,
                    'message' => 'Thanks! We\'ll notify you when ReaneyAI Membership launches.',
                    'data' => [
                        'email' => $request->email,
                        'signup_date' => now()->format('Y-m-d H:i:s')
                    ]
                ], 201);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Unable to sign you up right now. Please try again later.',
                ], 500);
            }

        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('Early access signup error', [
                'email' => $request->email,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Something went wrong. Please try again.',
            ], 500);
        }
    }

    /**
     * Get signup statistics from Mailchimp (optional admin feature)
     */
    public function stats(): JsonResponse
    {
        try {
            $mailchimp = $this->getMailchimpClient();
            $listId = config('mailchimp.list_id');
            
            if (!$mailchimp || !$listId) {
                return response()->json([
                    'error' => 'Mailchimp not configured'
                ], 500);
            }
            
            $list = $mailchimp->lists->getList($listId);
            
            return response()->json([
                'total_signups' => $list->stats->member_count ?? 0,
                'list_name' => $list->name ?? 'Unknown',
                'last_updated' => now()->format('Y-m-d H:i:s')
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Unable to fetch stats',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
