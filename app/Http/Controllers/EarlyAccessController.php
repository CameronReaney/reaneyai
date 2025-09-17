<?php

namespace App\Http\Controllers;

use App\Models\EarlyAccessSignup;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\UniqueConstraintViolationException;
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
            
            $response = $mailchimp->lists->addListMember($listId, [
                'email_address' => $email,
                'status' => config('mailchimp.default_status', 'subscribed'),
                'tags' => ['early-access', 'reaneyai-launch'],
                'merge_fields' => [
                    'SOURCE' => 'ReaneyAI Website',
                    'SIGNUP' => now()->format('Y-m-d')
                ]
            ]);
            
            Log::info('Successfully added email to Mailchimp', [
                'email' => $email,
                'mailchimp_id' => $response->id ?? null
            ]);
            
            return true;
            
        } catch (\Exception $e) {
            // Don't fail the signup if Mailchimp fails
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
            // Save to database
            $signup = EarlyAccessSignup::create([
                'email' => $request->email,
                'ip_address' => $request->ip(),
                'user_agent' => $request->header('User-Agent'),
            ]);

            // Add to Mailchimp (non-blocking - won't fail if Mailchimp is down)
            $mailchimpSuccess = $this->addToMailchimp($request->email);
            
            $message = $mailchimpSuccess 
                ? 'Thanks! We\'ll notify you when ReaneyAI Membership launches.'
                : 'Thanks! We\'ll notify you when ReaneyAI Membership launches. (Note: Email saved locally)';

            return response()->json([
                'success' => true,
                'message' => $message,
                'data' => [
                    'email' => $signup->email,
                    'signup_date' => $signup->created_at->format('Y-m-d H:i:s'),
                    'mailchimp_synced' => $mailchimpSuccess
                ]
            ], 201);

        } catch (UniqueConstraintViolationException $e) {
            // Email already exists
            return response()->json([
                'success' => false,
                'message' => 'This email is already signed up for early access.',
            ], 409);
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('Early access signup error', [
                'email' => $request->email,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Something went wrong. Please try again.',
            ], 500);
        }
    }

    /**
     * Get signup statistics (optional admin feature)
     */
    public function stats(): JsonResponse
    {
        $total = EarlyAccessSignup::count();
        $recent = EarlyAccessSignup::where('created_at', '>=', now()->subDays(7))->count();
        
        return response()->json([
            'total_signups' => $total,
            'recent_signups' => $recent,
            'last_signup' => EarlyAccessSignup::latest()->first()?->created_at
        ]);
    }
}
