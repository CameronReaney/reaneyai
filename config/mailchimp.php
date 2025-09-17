<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Mailchimp API Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for Mailchimp Marketing API integration
    |
    */

    'api_key' => env('MAILCHIMP_API_KEY'),
    'server_prefix' => env('MAILCHIMP_SERVER_PREFIX'),
    'list_id' => env('MAILCHIMP_LIST_ID'),
    
    /*
    |--------------------------------------------------------------------------
    | Default Settings
    |--------------------------------------------------------------------------
    */
    
    'default_status' => 'subscribed', // subscribed, unsubscribed, cleaned, pending
    'double_opt_in' => false, // Set to true if you want double opt-in
];
