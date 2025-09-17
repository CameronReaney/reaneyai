{{-- resources/views/livewire/prompt-builder.blade.php --}}
<div class="container mx-auto px-6 py-16" 
     x-data="{ 
         activeTab: 'builder',
         showPreview: false 
     }" 
     :class="loaded ? 'animate-fade-in-up' : 'opacity-0'">
     
    <!-- Hero Section -->
    <div class="text-center mb-16">
        <h1 class="text-6xl font-bold mb-6 text-gradient glow-text animate-scale-in">
            AI System Prompt Builder
        </h1>
        <p class="text-xl text-white/70 max-w-3xl mx-auto leading-relaxed animate-fade-in-up" style="animation-delay: 0.2s">
            Create sophisticated system prompts for AI models with our intuitive builder. 
            Craft precise instructions, set behavioral guidelines, and optimize AI responses.
        </p>
    </div>

    <!-- Tab Navigation -->
    <div class="flex justify-center mb-12">
        <div class="glass-effect rounded-xl p-1 inline-flex">
            <button @click="activeTab = 'builder'" 
                    :class="activeTab === 'builder' ? 'bg-white/20 text-white' : 'text-white/60 hover:text-white'"
                    class="px-6 py-3 rounded-lg font-medium transition-all duration-300">
                Prompt Builder
            </button>
            <button @click="activeTab = 'templates'" 
                    :class="activeTab === 'templates' ? 'bg-white/20 text-white' : 'text-white/60 hover:text-white'"
                    class="px-6 py-3 rounded-lg font-medium transition-all duration-300">
                Templates
            </button>
            <button @click="activeTab = 'settings'" 
                    :class="activeTab === 'settings' ? 'bg-white/20 text-white' : 'text-white/60 hover:text-white'"
                    class="px-6 py-3 rounded-lg font-medium transition-all duration-300">
                Settings
            </button>
        </div>
    </div>

    <!-- Builder Tab Content -->
    <div x-show="activeTab === 'builder'" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform translate-y-4"
         x-transition:enter-end="opacity-100 transform translate-y-0"
         class="grid lg:grid-cols-2 gap-8">
        
        <!-- Left Column - Input Forms -->
        <div class="space-y-6">
            <!-- System Prompt Section -->
            <div class="glass-effect minimal-shadow rounded-2xl p-8 hover-lift">
                <h2 class="text-2xl font-bold mb-4 text-white">System Prompt</h2>
                <p class="text-white/60 mb-6">Define the AI's role, behavior, and capabilities</p>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-white/80 mb-2">
                            Primary Instructions
                        </label>
                        <textarea wire:model.live="systemPrompt"
                                  placeholder="You are a helpful AI assistant. Your role is to..."
                                  class="w-full h-32 bg-black/50 border border-white/20 rounded-lg px-4 py-3 text-white placeholder-white/40 focus:outline-none focus:ring-2 focus:ring-white/30 focus:border-transparent transition-all">
                        </textarea>
                    </div>
                </div>
            </div>

            <!-- User Prompt Section -->
            <div class="glass-effect minimal-shadow rounded-2xl p-8 hover-lift">
                <h2 class="text-2xl font-bold mb-4 text-white">User Prompt</h2>
                <p class="text-white/60 mb-6">The user's input or question</p>
                
                <div>
                    <textarea wire:model.live="userPrompt"
                              placeholder="Enter your question or request here..."
                              class="w-full h-24 bg-black/50 border border-white/20 rounded-lg px-4 py-3 text-white placeholder-white/40 focus:outline-none focus:ring-2 focus:ring-white/30 focus:border-transparent transition-all">
                    </textarea>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="flex gap-4">
                <button wire:click="generatePrompt"
                        class="flex-1 bg-gradient-to-r from-white/20 to-white/10 hover:from-white/30 hover:to-white/20 text-white font-semibold py-4 px-6 rounded-xl transition-all duration-300 hover:scale-105 hover:shadow-lg shimmer-effect">
                    Generate Prompt
                </button>
                <button @click="showPreview = !showPreview"
                        class="px-6 py-4 glass-effect rounded-xl text-white hover:bg-white/10 transition-all duration-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Right Column - Preview -->
        <div class="space-y-6">
            <div class="glass-effect minimal-shadow rounded-2xl p-8 hover-lift">
                <h2 class="text-2xl font-bold mb-4 text-white">Live Preview</h2>
                <p class="text-white/60 mb-6">See how your prompt will look</p>
                
                <div class="space-y-4">
                    @if($systemPrompt)
                        <div class="bg-black/30 rounded-lg p-4 border-l-4 border-blue-400">
                            <h4 class="text-blue-300 font-medium mb-2">System:</h4>
                            <p class="text-white/80 text-sm whitespace-pre-wrap">{{ $systemPrompt }}</p>
                        </div>
                    @endif
                    
                    @if($userPrompt)
                        <div class="bg-black/30 rounded-lg p-4 border-l-4 border-green-400">
                            <h4 class="text-green-300 font-medium mb-2">User:</h4>
                            <p class="text-white/80 text-sm whitespace-pre-wrap">{{ $userPrompt }}</p>
                        </div>
                    @endif
                    
                    @if(!$systemPrompt && !$userPrompt)
                        <div class="text-center py-12 text-white/40">
                            <svg class="w-16 h-16 mx-auto mb-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <p>Start typing to see your prompt preview</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Templates Tab Content -->
    <div x-show="activeTab === 'templates'" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform translate-y-4"
         x-transition:enter-end="opacity-100 transform translate-y-0"
         class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
        
        <!-- Template Cards -->
        <div class="glass-effect minimal-shadow rounded-2xl p-6 hover-lift cursor-pointer">
            <h3 class="text-xl font-semibold mb-3 text-white">Creative Writer</h3>
            <p class="text-white/60 mb-4">For creative writing, storytelling, and content creation</p>
            <div class="flex justify-between items-center">
                <span class="text-sm text-white/40">Popular</span>
                <button class="text-blue-400 hover:text-blue-300 transition-colors">Use Template</button>
            </div>
        </div>

        <div class="glass-effect minimal-shadow rounded-2xl p-6 hover-lift cursor-pointer">
            <h3 class="text-xl font-semibold mb-3 text-white">Code Assistant</h3>
            <p class="text-white/60 mb-4">For programming help, code review, and technical guidance</p>
            <div class="flex justify-between items-center">
                <span class="text-sm text-white/40">Developer</span>
                <button class="text-blue-400 hover:text-blue-300 transition-colors">Use Template</button>
            </div>
        </div>

        <div class="glass-effect minimal-shadow rounded-2xl p-6 hover-lift cursor-pointer">
            <h3 class="text-xl font-semibold mb-3 text-white">Research Assistant</h3>
            <p class="text-white/60 mb-4">For research, analysis, and fact-checking tasks</p>
            <div class="flex justify-between items-center">
                <span class="text-sm text-white/40">Academic</span>
                <button class="text-blue-400 hover:text-blue-300 transition-colors">Use Template</button>
            </div>
        </div>
    </div>

    <!-- Settings Tab Content -->
    <div x-show="activeTab === 'settings'" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform translate-y-4"
         x-transition:enter-end="opacity-100 transform translate-y-0"
         class="max-w-2xl mx-auto">
        
        <div class="glass-effect minimal-shadow rounded-2xl p-8 hover-lift">
            <h2 class="text-2xl font-bold mb-6 text-white">Model Settings</h2>
            
            <div class="space-y-6">
                <!-- Model Selection -->
                <div>
                    <label class="block text-sm font-medium text-white/80 mb-2">AI Model</label>
                    <select wire:model="model" 
                            class="w-full bg-black/50 border border-white/20 rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-white/30">
                        <option value="gpt-4">GPT-4</option>
                        <option value="gpt-3.5-turbo">GPT-3.5 Turbo</option>
                        <option value="claude-3">Claude 3</option>
                    </select>
                </div>

                <!-- Temperature -->
                <div>
                    <label class="block text-sm font-medium text-white/80 mb-2">
                        Temperature: <span class="text-blue-400">{{ $temperature }}</span>
                    </label>
                    <input type="range" 
                           wire:model.live="temperature" 
                           min="0" 
                           max="1" 
                           step="0.1"
                           class="w-full h-2 bg-black/50 rounded-lg appearance-none cursor-pointer slider">
                    <div class="flex justify-between text-xs text-white/40 mt-1">
                        <span>Conservative</span>
                        <span>Creative</span>
                    </div>
                </div>

                <!-- Max Tokens -->
                <div>
                    <label class="block text-sm font-medium text-white/80 mb-2">
                        Max Tokens: <span class="text-blue-400">{{ $maxTokens }}</span>
                    </label>
                    <input type="range" 
                           wire:model.live="maxTokens" 
                           min="100" 
                           max="4000" 
                           step="100"
                           class="w-full h-2 bg-black/50 rounded-lg appearance-none cursor-pointer slider">
                    <div class="flex justify-between text-xs text-white/40 mt-1">
                        <span>Short</span>
                        <span>Long</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>