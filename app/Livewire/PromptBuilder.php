<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\OpenRouterService;
use Livewire\Attributes\Validate;

class PromptBuilder extends Component
{
    // Manual Prompt Builder Properties
    public $systemPrompt = '';
    public $userPrompt = '';
    public $temperature = 0.7;
    public $maxTokens = 1000;
    public $model = 'gpt-4';
    
    // AI-Only Properties
    public $taskDescription = '';
    public $targetAudience = '';
    public $outputType = '';
    public $additionalRequirements = '';
    
    // AI Generation properties
    public $generatedPrompt = '';
    public $isGenerating = false;
    public $promptVariations = [];
    
    // Quick selection options
    public $audienceOptions = [
        'General public',
        'Beginners/Students',
        'Professionals/Experts',
        'Executives/Decision makers',
        'Developers/Technical',
        'Creatives/Artists',
        'Researchers/Academics',
        'Customers/End users',
    ];
    
    public $outputTypeOptions = [
        'Text/Articles',
        'Code/Programming',
        'Creative writing',
        'Business documents',
        'Educational content',
        'Marketing copy',
        'Technical documentation',
        'Social media content',
        'Emails/Communication',
        'Data analysis',
    ];

    // Initialize default values
    public function mount()
    {
        $this->targetAudience = $this->audienceOptions[0];
        $this->outputType = $this->outputTypeOptions[0];
    }

    // Main AI generation method
    public function generatePrompt()
    {
        \Log::info('Generate prompt called', ['taskDescription' => $this->taskDescription]);
        
        if (empty($this->taskDescription)) {
            $this->dispatch('ai-error', ['message' => 'Please describe what you want the AI to do.']);
            return;
        }

        $this->isGenerating = true;
        
        try {
            $openRouter = new OpenRouterService();
            
            $requirements = [
                'task' => $this->taskDescription,
                'audience' => $this->targetAudience,
                'outputType' => $this->outputType,
                'additional' => $this->additionalRequirements,
            ];
            
            $generated = $openRouter->generateSmartPrompt($requirements);
            
            if ($generated) {
                $this->generatedPrompt = $generated;
                $this->dispatch('prompt-generated', ['message' => 'Ultra-powerful prompt generated successfully!']);
            } else {
                $this->dispatch('ai-error', ['message' => 'Failed to generate prompt. Please try again.']);
            }
            
        } catch (\Exception $e) {
            $this->dispatch('ai-error', ['message' => 'Error generating prompt: ' . $e->getMessage()]);
        } finally {
            $this->isGenerating = false;
        }
    }

    // Generate variations of the current prompt
    public function generateVariations()
    {
        if (empty($this->generatedPrompt)) {
            $this->dispatch('ai-error', ['message' => 'Generate a prompt first to create variations.']);
            return;
        }

        $this->isGenerating = true;
        
        try {
            $openRouter = new OpenRouterService();
            $variations = $openRouter->generateVariations($this->generatedPrompt, 3);
            
            if (!empty($variations)) {
                $this->promptVariations = $variations;
                $this->dispatch('prompt-generated', ['message' => 'Variations generated successfully!']);
            } else {
                $this->dispatch('ai-error', ['message' => 'Failed to generate variations.']);
            }
            
        } catch (\Exception $e) {
            $this->dispatch('ai-error', ['message' => 'Error generating variations: ' . $e->getMessage()]);
        } finally {
            $this->isGenerating = false;
        }
    }

    // Use a variation as the main prompt
    public function useVariation($index)
    {
        if (isset($this->promptVariations[$index])) {
            $this->generatedPrompt = $this->promptVariations[$index];
            $this->promptVariations = []; // Clear variations
            $this->dispatch('prompt-generated', ['message' => 'Variation applied successfully!']);
        }
    }

    // Reset everything
    public function resetAll()
    {
        $this->taskDescription = '';
        $this->targetAudience = $this->audienceOptions[0];
        $this->outputType = $this->outputTypeOptions[0];
        $this->additionalRequirements = '';
        $this->generatedPrompt = '';
        $this->promptVariations = [];
        
        $this->dispatch('prompt-generated', ['message' => 'All fields reset successfully!']);
    }

    // Method to copy prompt (handled by JavaScript in the view)
    public function copyPrompt()
    {
        $this->dispatch('prompt-copied');
    }

    // Simple test method to verify button clicks work
    public function testButton()
    {
        \Log::info('Test button clicked!');
        $this->dispatch('prompt-generated', ['message' => 'Button click test successful!']);
    }

    public function render()
    {
        return view('livewire.prompt-builder');
    }
}
