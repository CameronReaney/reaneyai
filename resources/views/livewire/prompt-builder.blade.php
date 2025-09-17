<div class="max-w-6xl mx-auto p-6">
    <!-- Header -->
    <div class="text-center mb-12" 
         :class="loaded ? 'animate-fade-in-up' : 'opacity-0'">
        <div class="glass-effect rounded-3xl p-12 backdrop-blur-sm minimal-shadow shimmer-effect">
            <h1 class="text-4xl md:text-6xl font-bold text-white mb-6 tracking-tight glow-text">
                <span class="text-gradient">AI</span> System Prompt Generator
            </h1>
            
            <div class="h-px bg-gradient-to-r from-transparent via-white to-transparent mb-6 opacity-30"></div>
            
            <p class="text-xl md:text-2xl mb-6 text-white/90 font-light tracking-wide max-w-4xl mx-auto">
                Describe what you want your AI to do, and our advanced AI will automatically create the perfect system prompt with optimal tone, expertise, and formatting.
            </p>
            
            <div class="inline-flex items-center px-6 py-3 glass-effect rounded-full border border-white/20">
                <svg class="w-5 h-5 mr-2 text-white" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                </svg>
                <span class="text-white/80 font-medium">Powered by Claude 3.5 Sonnet</span>
            </div>
        </div>
    </div>

    <!-- Loading Overlay for Generate Prompt -->
    <div wire:loading wire:target="generatePrompt" 
         class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center">
        <div class="glass-effect p-8 rounded-2xl border border-white/20 text-center max-w-md mx-auto">
            <div class="mb-6">
                <svg class="animate-spin h-12 w-12 mx-auto text-white" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 818-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-white mb-2">🤖 AI is Working</h3>
            <p class="text-white/80 mb-4">Crafting your ultra-powerful prompt...</p>
            <div class="flex justify-center space-x-1">
                <div class="w-2 h-2 bg-white rounded-full animate-bounce" style="animation-delay: 0s;"></div>
                <div class="w-2 h-2 bg-white rounded-full animate-bounce" style="animation-delay: 0.1s;"></div>
                <div class="w-2 h-2 bg-white rounded-full animate-bounce" style="animation-delay: 0.2s;"></div>
            </div>
        </div>
    </div>

    <!-- Loading Overlay for Generate Variations -->
    <div wire:loading wire:target="generateVariations" 
         class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center">
        <div class="glass-effect p-8 rounded-2xl border border-white/20 text-center max-w-md mx-auto">
            <div class="mb-6">
                <svg class="animate-spin h-12 w-12 mx-auto text-white" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 818-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-white mb-2">🎨 Creating Variations</h3>
            <p class="text-white/80 mb-4">Generating creative alternatives...</p>
            <div class="flex justify-center space-x-1">
                <div class="w-2 h-2 bg-white rounded-full animate-bounce" style="animation-delay: 0s;"></div>
                <div class="w-2 h-2 bg-white rounded-full animate-bounce" style="animation-delay: 0.1s;"></div>
                <div class="w-2 h-2 bg-white rounded-full animate-bounce" style="animation-delay: 0.2s;"></div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Input Section -->
        <div class="space-y-6"
             :class="loaded ? 'animate-fade-in-up' : 'opacity-0'"
             style="animation-delay: 0.3s;">
            <!-- Main Task Description -->
            <div class="glass-effect rounded-2xl p-8 border border-white/20 minimal-shadow hover-lift">
                <div class="flex items-center mb-4">
                    <div class="p-3 glass-effect rounded-xl mr-4 border border-white/20">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-white glow-text">What should your AI do?</h2>
                </div>
                <p class="text-white/70 mb-4">Describe the main task or role you want the AI to perform:</p>
                <textarea wire:model="taskDescription" 
                          placeholder="e.g., 'Write engaging marketing copy for a SaaS product' or 'Help debug complex JavaScript code' or 'Create fantasy story characters with detailed backgrounds'"
                          rows="4"
                          class="w-full px-4 py-3 glass-effect border border-white/20 rounded-xl text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-white/30 focus:border-white/40 text-lg resize-none bg-transparent"></textarea>
            </div>

            <!-- Quick Settings Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Target Audience -->
                <div class="glass-effect p-6 rounded-xl border border-white/20 hover-lift">
                    <label class="block text-lg font-semibold text-white mb-3">
                        <span class="inline-flex items-center">
                            <svg class="w-5 h-5 mr-2 text-white/70" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            Target Audience
                        </span>
                    </label>
                    <select wire:model="targetAudience" class="w-full px-3 py-2 glass-effect border border-white/20 rounded-lg text-white bg-transparent focus:outline-none focus:ring-2 focus:ring-white/30 focus:border-white/40">
                        @foreach($audienceOptions as $option)
                            <option value="{{ $option }}" class="bg-black text-white">{{ $option }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Output Type -->
                <div class="glass-effect p-6 rounded-xl border border-white/20 hover-lift">
                    <label class="block text-lg font-semibold text-white mb-3">
                        <span class="inline-flex items-center">
                            <svg class="w-5 h-5 mr-2 text-white/70" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Output Type
                        </span>
                    </label>
                    <select wire:model="outputType" class="w-full px-3 py-2 glass-effect border border-white/20 rounded-lg text-white bg-transparent focus:outline-none focus:ring-2 focus:ring-white/30 focus:border-white/40">
                        @foreach($outputTypeOptions as $option)
                            <option value="{{ $option }}" class="bg-black text-white">{{ $option }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Additional Requirements -->
            <div class="glass-effect p-6 rounded-xl border border-white/20 hover-lift">
                <label class="block text-lg font-semibold text-white mb-3">
                    <span class="inline-flex items-center">
                        <svg class="w-5 h-5 mr-2 text-white/70" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                        Additional Requirements (Optional)
                    </span>
                </label>
                <textarea wire:model="additionalRequirements" 
                          placeholder="Any specific constraints, style preferences, examples to include, or special instructions..."
                          rows="3"
                          class="w-full px-3 py-2 glass-effect border border-white/20 rounded-lg text-white placeholder-white/50 bg-transparent focus:outline-none focus:ring-2 focus:ring-white/30 focus:border-white/40 resize-none"></textarea>
            </div>

            <!-- Generate Button -->
            <div class="text-center space-y-4">
                <!-- Test Button (temporary) -->
                <button wire:click="testButton" 
                        class="px-6 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors">
                    🧪 Test Button Click
                </button>
                
                <button wire:click="generatePrompt" 
                        wire:loading.attr="disabled"
                        wire:loading.class="animate-pulse bg-gray-300 cursor-not-allowed"
                        class="group relative animate-pulse-glow bg-white text-black px-12 py-4 rounded-full font-semibold text-xl hover:bg-gray-100 transition-all duration-500 animate-fade-in-up overflow-hidden disabled:opacity-75 disabled:cursor-not-allowed disabled:transform-none"
                        style="animation-delay: 1s;">
                    <span class="relative z-10 flex items-center justify-center">
                        <span wire:loading.remove wire:target="generatePrompt">
                            <svg class="w-6 h-6 mr-3 inline" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                            🚀 Generate Ultra-Powerful Prompt
                        </span>
                        <span wire:loading wire:target="generatePrompt" class="flex items-center">
                            <svg class="animate-spin h-6 w-6 mr-3 text-black" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 818-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 714 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span class="animate-pulse">🤖 AI is crafting your prompt...</span>
                        </span>
                    </span>
                    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-gray-200 to-transparent transform -skew-x-12 group-hover:animate-shimmer" wire:loading.class.remove="group-hover:animate-shimmer"></div>
                </button>
            </div>

                @if($generatedPrompt)
                    <div class="mt-6 flex justify-center space-x-4">
                        <button wire:click="generateVariations" 
                                wire:loading.attr="disabled"
                                wire:loading.class="animate-pulse opacity-75"
                                class="inline-flex items-center px-6 py-2 glass-effect border border-white/20 text-white rounded-lg hover-lift transition-all duration-300 disabled:opacity-75 disabled:cursor-not-allowed">
                            <span wire:loading.remove wire:target="generateVariations" class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M4 4h16v2H4zm0 5h16v2H4zm0 5h16v2H4z"/>
                                </svg>
                                Create Variations
                            </span>
                            <span wire:loading wire:target="generateVariations" class="flex items-center">
                                <svg class="animate-spin w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 818-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Creating variations...
                            </span>
                        </button>

                        <button wire:click="resetAll" 
                                class="inline-flex items-center px-6 py-2 glass-effect border border-white/20 text-white rounded-lg hover-lift transition-all duration-300">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                            Reset
                        </button>
                    </div>
                @endif
        </div>

        <!-- Output Section -->
        <div class="space-y-6"
             :class="loaded ? 'animate-fade-in-up' : 'opacity-0'"
             style="animation-delay: 0.6s;">
            <!-- Generated Prompt Display -->
            <div class="sticky top-6">
                <div class="glass-effect rounded-2xl p-6 border border-white/20 minimal-shadow">
                    <div class="flex justify-between items-center mb-4">
                        <div>
                            <h2 class="text-2xl font-bold text-white glow-text">
                                @if($generatedPrompt)
                                    🚀 AI-Generated System Prompt
                                @else
                                    📝 Your Prompt Will Appear Here
                                @endif
                            </h2>
                            @if($generatedPrompt)
                                <p class="text-sm text-white/70 mt-1">✨ Automatically optimized by AI</p>
                            @endif
                        </div>
                        @if($generatedPrompt)
                            <button onclick="copyToClipboard()" 
                                    class="px-4 py-2 glass-effect border border-white/20 text-white rounded-lg hover-lift transition-all duration-300">
                                📋 Copy
                            </button>
                        @endif
                    </div>
                    
                    @if($generatedPrompt)
                        <textarea id="system-prompt-output" readonly 
                                  class="w-full h-96 px-4 py-3 glass-effect border border-white/20 rounded-xl text-sm font-mono resize-none text-white bg-transparent focus:outline-none focus:ring-2 focus:ring-white/30">{{ $generatedPrompt }}</textarea>
                        
                        <!-- Character count -->
                        <div class="mt-3 flex justify-between items-center text-sm">
                            <div class="text-white/50">
                                {{ strlen($generatedPrompt) }} characters
                            </div>
                            <div class="text-white/70 font-medium">
                                🤖 AI-crafted for maximum effectiveness
                            </div>
                        </div>
                    @else
                        <div class="w-full h-96 glass-effect border border-dashed border-white/20 rounded-xl flex items-center justify-center">
                            <div class="text-center text-white/50">
                                <svg class="w-16 h-16 mx-auto mb-4 text-white/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                                </svg>
                                <p class="text-lg font-medium text-white/70">Describe your task and click Generate</p>
                                <p class="text-sm text-white/50">The AI will create the perfect system prompt</p>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Variations Display -->
                @if(!empty($promptVariations))
                    <div class="mt-6 glass-effect p-6 rounded-2xl border border-white/20 minimal-shadow">
                        <h3 class="text-lg font-semibold text-white mb-4 glow-text">🎨 Alternative Variations:</h3>
                        <div class="space-y-4">
                            @foreach($promptVariations as $index => $variation)
                                <div class="relative glass-effect p-4 rounded-xl border border-white/20 hover:border-white/40 transition-all duration-300 hover-lift">
                                    <div class="flex justify-between items-start">
                                        <p class="text-sm text-white/80 pr-4 leading-relaxed">{{ $variation }}</p>
                                        <button wire:click="useVariation({{ $index }})" 
                                                class="flex-shrink-0 px-3 py-1 glass-effect border border-white/20 text-white text-xs rounded-lg hover-lift transition-all duration-300">
                                            Use This
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Toast notifications -->
    <div id="copy-toast" class="fixed bottom-4 right-4 glass-effect border border-green-400/50 text-white px-6 py-3 rounded-lg minimal-shadow transform translate-y-full opacity-0 transition-all duration-300 z-50">
        ✅ Prompt copied to clipboard!
    </div>
    
    <div id="success-toast" class="fixed bottom-4 right-4 glass-effect border border-white/20 text-white px-6 py-3 rounded-lg minimal-shadow transform translate-y-full opacity-0 transition-all duration-300 z-50">
        <span id="success-message">🚀 Operation completed!</span>
    </div>
    
    <div id="error-toast" class="fixed bottom-4 right-4 glass-effect border border-red-400/50 text-white px-6 py-3 rounded-lg minimal-shadow transform translate-y-full opacity-0 transition-all duration-300 z-50">
        <span id="error-message">❌ Operation failed!</span>
    </div>
    
    <!-- JavaScript for notifications -->
    <script>
    function copyToClipboard() {
        const textarea = document.getElementById('system-prompt-output');
        textarea.select();
        document.execCommand('copy');
        
        showToast('copy-toast');
    }

    function showToast(toastId, message = null) {
        // Hide any currently visible toasts
        const allToasts = ['copy-toast', 'success-toast', 'error-toast'];
        allToasts.forEach(id => {
            const toast = document.getElementById(id);
            if (toast) {
                toast.classList.remove('translate-y-0', 'opacity-100');
                toast.classList.add('translate-y-full', 'opacity-0');
            }
        });

        // Show the requested toast
        setTimeout(() => {
            const toast = document.getElementById(toastId);
            if (toast) {
                if (message) {
                    const messageSpan = toast.querySelector('span');
                    if (messageSpan) {
                        messageSpan.textContent = message;
                    }
                }
                
                toast.classList.remove('translate-y-full', 'opacity-0');
                toast.classList.add('translate-y-0', 'opacity-100');
                
                // Hide toast after 3 seconds
                setTimeout(() => {
                    toast.classList.remove('translate-y-0', 'opacity-100');
                    toast.classList.add('translate-y-full', 'opacity-0');
                }, 3000);
            }
        }, 100);
    }

    // Listen for Livewire events
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('prompt-copied', () => {
            copyToClipboard();
        });

        Livewire.on('prompt-generated', (event) => {
            showToast('success-toast', event.message || '🚀 AI operation completed successfully!');
        });

        Livewire.on('ai-error', (event) => {
            showToast('error-toast', event.message || '❌ AI operation failed. Please try again.');
        });
    });
    </script>
</div>