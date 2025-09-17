<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OpenRouterService
{
    protected $apiKey;
    protected $apiUrl;
    protected $defaultModel;
    protected $timeout;
    protected $maxTokens;

    public function __construct()
    {
        $this->apiKey = config('openrouter.api_key');
        $this->apiUrl = config('openrouter.api_url');
        $this->defaultModel = config('openrouter.default_model');
        $this->timeout = config('openrouter.timeout');
        $this->maxTokens = config('openrouter.max_tokens');
        
        \Log::info('OpenRouter Service initialized', [
            'has_api_key' => !empty($this->apiKey),
            'api_url' => $this->apiUrl,
            'model' => $this->defaultModel
        ]);
    }

    /**
     * Generate a smart system prompt that automatically decides everything
     */
    public function generateSmartPrompt(array $requirements): ?string
    {
        $systemMessage = $this->buildSmartGenerationSystemMessage();
        $userMessage = $this->buildSmartUserRequest($requirements);

        try {
            $response = Http::timeout($this->timeout)
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $this->apiKey,
                    'HTTP-Referer' => 'https://reaneyai.com',
                    'X-Title' => 'ReaneyAI Prompt Builder',
                    'Content-Type' => 'application/json',
                ])
                ->post($this->apiUrl, [
                    'model' => $this->defaultModel,
                    'messages' => [
                        [
                            'role' => 'system',
                            'content' => $systemMessage
                        ],
                        [
                            'role' => 'user',
                            'content' => $userMessage
                        ]
                    ],
                    'max_tokens' => $this->maxTokens,
                    'temperature' => 0.7,
                    'top_p' => 0.9,
                ]);

            if ($response->successful()) {
                $data = $response->json();
                return $data['choices'][0]['message']['content'] ?? null;
            }

            Log::error('OpenRouter API Error', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            return null;

        } catch (\Exception $e) {
            Log::error('OpenRouter API Exception', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return null;
        }
    }

    /**
     * Generate an enhanced system prompt using AI
     */
    public function enhancePrompt(array $parameters): ?string
    {
        $systemMessage = $this->buildEnhancementSystemMessage();
        $userMessage = $this->buildUserPromptRequest($parameters);

        try {
            $response = Http::timeout($this->timeout)
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $this->apiKey,
                    'HTTP-Referer' => 'https://reaneyai.com',
                    'X-Title' => 'ReaneyAI Prompt Builder',
                    'Content-Type' => 'application/json',
                ])
                ->post($this->apiUrl, [
                    'model' => $this->defaultModel,
                    'messages' => [
                        [
                            'role' => 'system',
                            'content' => $systemMessage
                        ],
                        [
                            'role' => 'user',
                            'content' => $userMessage
                        ]
                    ],
                    'max_tokens' => $this->maxTokens,
                    'temperature' => 0.7,
                    'top_p' => 0.9,
                ]);

            if ($response->successful()) {
                $data = $response->json();
                return $data['choices'][0]['message']['content'] ?? null;
            }

            Log::error('OpenRouter API Error', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            return null;

        } catch (\Exception $e) {
            Log::error('OpenRouter API Exception', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return null;
        }
    }

    /**
     * Generate creative prompt variations
     */
    public function generateVariations(string $basePrompt, int $count = 3): array
    {
        $systemMessage = $this->buildVariationSystemMessage();
        $userMessage = "Create {$count} creative variations of this system prompt: {$basePrompt}";

        try {
            $response = Http::timeout($this->timeout)
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $this->apiKey,
                    'HTTP-Referer' => 'https://reaneyai.com',
                    'X-Title' => 'ReaneyAI Prompt Builder',
                    'Content-Type' => 'application/json',
                ])
                ->post($this->apiUrl, [
                    'model' => $this->defaultModel,
                    'messages' => [
                        [
                            'role' => 'system',
                            'content' => $systemMessage
                        ],
                        [
                            'role' => 'user',
                            'content' => $userMessage
                        ]
                    ],
                    'max_tokens' => $this->maxTokens,
                    'temperature' => 0.8,
                    'top_p' => 0.9,
                ]);

            if ($response->successful()) {
                $data = $response->json();
                $content = $data['choices'][0]['message']['content'] ?? '';
                
                // Parse the variations from the response
                return $this->parseVariations($content);
            }

            return [];

        } catch (\Exception $e) {
            Log::error('OpenRouter Variations API Exception', [
                'message' => $e->getMessage()
            ]);

            return [];
        }
    }

    /**
     * Generate a completely new prompt based on a simple description
     */
    public function generateFromDescription(string $description): ?string
    {
        $systemMessage = $this->buildGenerationSystemMessage();
        $userMessage = "Create a powerful system prompt for: {$description}";

        try {
            $response = Http::timeout($this->timeout)
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $this->apiKey,
                    'HTTP-Referer' => 'https://reaneyai.com',
                    'X-Title' => 'ReaneyAI Prompt Builder',
                    'Content-Type' => 'application/json',
                ])
                ->post($this->apiUrl, [
                    'model' => $this->defaultModel,
                    'messages' => [
                        [
                            'role' => 'system',
                            'content' => $systemMessage
                        ],
                        [
                            'role' => 'user',
                            'content' => $userMessage
                        ]
                    ],
                    'max_tokens' => $this->maxTokens,
                    'temperature' => 0.7,
                    'top_p' => 0.9,
                ]);

            if ($response->successful()) {
                $data = $response->json();
                return $data['choices'][0]['message']['content'] ?? null;
            }

            return null;

        } catch (\Exception $e) {
            Log::error('OpenRouter Generation API Exception', [
                'message' => $e->getMessage()
            ]);

            return null;
        }
    }

    private function buildEnhancementSystemMessage(): string
    {
        return "You are an expert AI prompt engineer who creates ultra-powerful, sophisticated system prompts. Your job is to take basic prompt parameters and transform them into highly effective, detailed system prompts that will produce exceptional AI responses.

Key principles for creating powerful prompts:
1. Be specific and detailed in role definitions
2. Include behavioral expectations and personality traits
3. Add context about expertise level and knowledge domains
4. Specify output quality standards and formatting requirements
5. Include examples or templates when helpful
6. Add constraints that improve focus and quality
7. Use advanced prompting techniques like chain-of-thought, few-shot examples, etc.

Transform the user's basic parameters into a sophisticated, production-ready system prompt that will make any AI perform at its absolute best.";
    }

    private function buildVariationSystemMessage(): string
    {
        return "You are a creative prompt engineer who generates diverse, powerful variations of system prompts. Each variation should:
1. Maintain the core intent and functionality
2. Use different approaches, styles, or techniques
3. Be equally effective but distinctly different
4. Explore different angles or methodologies
5. Vary in tone, structure, and emphasis

Return each variation clearly separated and numbered.";
    }

    private function buildSmartGenerationSystemMessage(): string
    {
        return "You are an elite AI prompt engineer with deep expertise in creating ultra-powerful system prompts. Your job is to analyze the user's requirements and automatically make ALL the decisions about:

1. ROLE & EXPERTISE: What type of expert the AI should be (technical, creative, analytical, etc.)
2. TONE & PERSONALITY: The perfect communication style for the task and audience
3. OUTPUT FORMAT: The most effective structure and formatting for the content
4. BEHAVIORAL GUIDELINES: How the AI should think, reason, and respond
5. QUALITY STANDARDS: Specific criteria for excellent performance
6. CONSTRAINTS & RULES: Important limitations and requirements

Your generated prompts should be:
- Sophisticated and detailed (but not overly verbose)
- Tailored specifically to the task and audience
- Include advanced prompting techniques (chain-of-thought, examples, etc.)
- Production-ready and immediately usable
- Designed to make any AI perform at maximum effectiveness

Automatically decide the optimal tone, style, expertise level, and approach based on the requirements. Do NOT ask for clarification - make intelligent decisions and create the perfect prompt.";
    }

    private function buildGenerationSystemMessage(): string
    {
        return "You are an expert AI prompt engineer who creates ultra-powerful system prompts from simple descriptions. Create comprehensive, sophisticated prompts that include:
1. Clear role and expertise definition
2. Behavioral guidelines and personality
3. Specific output requirements and formatting
4. Quality standards and expectations
5. Relevant constraints and guidelines
6. Advanced prompting techniques when applicable

Make the prompt detailed, specific, and designed to produce exceptional AI performance.";
    }

    private function buildUserPromptRequest(array $parameters): string
    {
        $request = "Create an enhanced system prompt with these parameters:\n\n";
        
        if (!empty($parameters['role'])) {
            $request .= "Role: {$parameters['role']}\n";
        }
        
        if (!empty($parameters['tone'])) {
            $request .= "Tone: {$parameters['tone']}\n";
        }
        
        if (!empty($parameters['outputFormat'])) {
            $request .= "Output Format: {$parameters['outputFormat']}\n";
        }
        
        if (!empty($parameters['audience'])) {
            $request .= "Audience: {$parameters['audience']}\n";
        }
        
        if (!empty($parameters['constraints'])) {
            $request .= "Constraints: {$parameters['constraints']}\n";
        }
        
        if (!empty($parameters['specialInstructions'])) {
            $request .= "Special Instructions: {$parameters['specialInstructions']}\n";
        }

        $request .= "\nTransform these into a powerful, detailed system prompt that will make the AI perform exceptionally well.";

        return $request;
    }

    private function buildSmartUserRequest(array $requirements): string
    {
        $request = "Create an ultra-powerful system prompt for this AI task:\n\n";
        
        $request .= "TASK DESCRIPTION: {$requirements['task']}\n";
        $request .= "TARGET AUDIENCE: {$requirements['audience']}\n";
        $request .= "OUTPUT TYPE: {$requirements['outputType']}\n";
        
        if (!empty($requirements['additional'])) {
            $request .= "ADDITIONAL REQUIREMENTS: {$requirements['additional']}\n";
        }

        $request .= "\nAutomatically decide and include:
- The perfect expert role/persona for this task
- Optimal tone and communication style for the audience
- Best output format and structure
- Behavioral guidelines and thinking process
- Quality standards and success criteria
- Any relevant constraints or best practices

Generate a sophisticated, production-ready system prompt that will make the AI excel at this specific task.";

        return $request;
    }

    private function parseVariations(string $content): array
    {
        // Split by numbers (1., 2., 3., etc.) or by double newlines
        $variations = preg_split('/\n\s*\d+\.\s*|\n\n+/', $content);
        
        // Clean up and filter variations
        $cleanVariations = [];
        foreach ($variations as $variation) {
            $clean = trim($variation);
            if (!empty($clean) && strlen($clean) > 50) {
                $cleanVariations[] = $clean;
            }
        }
        
        return array_slice($cleanVariations, 0, 5); // Return max 5 variations
    }
}
