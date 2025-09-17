<?php

return [
    /*
    |--------------------------------------------------------------------------
    | OpenRouter API Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for OpenRouter API integration to power AI prompt generation
    |
    */

    'api_key' => env('OPENROUTER_API_KEY', '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'),
    'api_url' => env('OPENROUTER_API_URL', 'https://openrouter.ai/api/v1/chat/completions'),
    'default_model' => env('OPENROUTER_DEFAULT_MODEL', 'anthropic/claude-3.5-sonnet'),
    'timeout' => env('OPENROUTER_TIMEOUT', 30),
    'max_tokens' => env('OPENROUTER_MAX_TOKENS', 2000),
];
