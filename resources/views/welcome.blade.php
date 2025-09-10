<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ReaneyAI - Clean Intelligence. Clear Insights.</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @livewireStyles
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'display': ['Inter', 'system-ui', 'sans-serif'],
                    },
                    animation: {
                        'gradient-shift': 'gradientShift 12s ease-in-out infinite',
                        'float': 'float 8s ease-in-out infinite',
                        'pulse-glow': 'pulseGlow 3s ease-in-out infinite',
                        'fade-in-up': 'fadeInUp 1s ease-out forwards',
                        'scale-in': 'scaleIn 0.8s ease-out forwards',
                        'shimmer': 'shimmer 2s linear infinite',
                    },
                    keyframes: {
                        gradientShift: {
                            '0%, 100%': { backgroundPosition: '0% 50%' },
                            '50%': { backgroundPosition: '100% 50%' }
                        },
                        float: {
                            '0%, 100%': { transform: 'translateY(0px) rotate(0deg)' },
                            '33%': { transform: 'translateY(-15px) rotate(1deg)' },
                            '66%': { transform: 'translateY(-8px) rotate(-0.5deg)' }
                        },
                        pulseGlow: {
                            '0%, 100%': { boxShadow: '0 0 20px rgba(255, 255, 255, 0.1)' },
                            '50%': { boxShadow: '0 0 40px rgba(255, 255, 255, 0.3)' }
                        },
                        fadeInUp: {
                            '0%': { opacity: '0', transform: 'translateY(30px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' }
                        },
                        scaleIn: {
                            '0%': { opacity: '0', transform: 'scale(0.9)' },
                            '100%': { opacity: '1', transform: 'scale(1)' }
                        },
                        shimmer: {
                            '0%': { transform: 'translateX(-100%)' },
                            '100%': { transform: 'translateX(100%)' }
                        }
                    }
                }
            }
        }
    </script>
    <style>
        .gradient-bg {
            background: linear-gradient(-45deg, #000000, #1a1a1a, #2d2d2d, #000000, #0d0d0d, #262626);
            background-size: 400% 400%;
            animation: gradientShift 12s ease-in-out infinite;
        }
        
        .glass-effect {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .text-gradient {
            background: linear-gradient(135deg, #ffffff 0%, #a0a0a0 50%, #ffffff 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .card-gradient {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.02) 0%, rgba(255, 255, 255, 0.08) 100%);
        }
        
        .floating-shape {
            position: absolute;
            border-radius: 50%;
            background: linear-gradient(45deg, rgba(255, 255, 255, 0.05), rgba(255, 255, 255, 0.02));
            filter: blur(2px);
        }
        
        .shimmer-effect {
            position: relative;
            overflow: hidden;
        }
        
        .shimmer-effect::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(
                90deg,
                transparent,
                rgba(255, 255, 255, 0.1),
                transparent
            );
            transform: translateX(-100%);
            animation: shimmer 2s infinite;
        }
        
        .grid-pattern {
            background-image: 
                linear-gradient(rgba(255, 255, 255, 0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.03) 1px, transparent 1px);
            background-size: 50px 50px;
        }
        
        .noise-texture {
            background-image: 
                radial-gradient(circle at 1px 1px, rgba(255,255,255,0.15) 1px, transparent 0);
            background-size: 20px 20px;
        }
        
        .glow-text {
            text-shadow: 0 0 20px rgba(255, 255, 255, 0.3);
        }
        
        .minimal-shadow {
            box-shadow: 
                0 1px 3px rgba(0, 0, 0, 0.3),
                0 8px 30px rgba(0, 0, 0, 0.2),
                inset 0 1px 0 rgba(255, 255, 255, 0.05);
        }
        
        .hover-lift {
            transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }
        
        .hover-lift:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 
                0 10px 40px rgba(0, 0, 0, 0.4),
                0 0 0 1px rgba(255, 255, 255, 0.05),
                inset 0 1px 0 rgba(255, 255, 255, 0.1);
        }
    </style>
</head>
<body class="font-display overflow-x-hidden bg-black text-white" 
      x-data="{ 
          mouseX: 0, 
          mouseY: 0,
          loaded: false,
          cards: [
              { title: 'System prompts for beginners', desc: 'Essential prompt engineering templates and examples for AI newcomers', free: true },
              { title: 'AI in Business – Guide 2025', desc: 'Complete strategies for implementing AI in modern enterprises', free: false },
              { title: 'Introduction to Machine Learning', desc: 'Fundamental concepts and practical applications explained', free: false },
              { title: 'AI Ethics & Society', desc: 'Navigating the moral landscape of artificial intelligence', free: false },
              { title: 'Deep Learning Cheat Sheet', desc: 'Quick reference for neural networks and algorithms', free: false },
              { title: 'Computer Vision Essentials', desc: 'Image processing and recognition techniques', free: false },
              { title: 'Natural Language Processing', desc: 'Understanding and generating human language with AI', free: false }
          ]
      }" 
      x-init="setTimeout(() => loaded = true, 200)"
      @mousemove="mouseX = $event.clientX; mouseY = $event.clientY">

    <!-- Grid Pattern Overlay -->
    <div class="fixed inset-0 grid-pattern opacity-30 pointer-events-none z-0"></div>
    
    <!-- Noise Texture -->
    <div class="fixed inset-0 noise-texture opacity-20 pointer-events-none z-0"></div>

    <!-- Floating Background Shapes -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none z-10">
        <div class="floating-shape w-96 h-96 opacity-20 animate-float" 
             style="top: 5%; left: 5%;"
             :style="`transform: translate(${mouseX * 0.015}px, ${mouseY * 0.015}px)`"></div>
        <div class="floating-shape w-64 h-64 opacity-15 animate-float" 
             style="top: 50%; right: 10%; animation-delay: -3s;"
             :style="`transform: translate(${mouseX * -0.01}px, ${mouseY * 0.02}px)`"></div>
        <div class="floating-shape w-80 h-80 opacity-10 animate-float" 
             style="bottom: 10%; left: 50%; animation-delay: -6s;"
             :style="`transform: translate(${mouseX * 0.02}px, ${mouseY * -0.015}px)`"></div>
    </div>

    <!-- Hero Section -->
    <section class="relative min-h-screen gradient-bg flex items-center justify-center text-white overflow-hidden">
        <!-- Hero Content -->
        <div class="text-center z-20 max-w-5xl mx-auto px-6">
            <div class="glass-effect rounded-3xl p-12 backdrop-blur-sm minimal-shadow shimmer-effect"
                 :class="loaded ? 'animate-fade-in-up' : 'opacity-0'">
                
                <h1 class="text-5xl md:text-7xl font-bold mb-6 tracking-tight glow-text">
                    <span class="inline-block animate-scale-in" style="animation-delay: 0.2s;">R</span><span class="inline-block animate-scale-in" style="animation-delay: 0.25s;">e</span><span class="inline-block animate-scale-in" style="animation-delay: 0.3s;">a</span><span class="inline-block animate-scale-in" style="animation-delay: 0.35s;">n</span><span class="inline-block animate-scale-in" style="animation-delay: 0.4s;">e</span><span class="inline-block animate-scale-in" style="animation-delay: 0.45s;">y</span><span class="inline-block animate-scale-in text-gradient" style="animation-delay: 0.5s;">A</span><span class="inline-block animate-scale-in text-gradient" style="animation-delay: 0.55s;">I</span>
                </h1>
                
                <div class="h-px bg-gradient-to-r from-transparent via-white to-transparent mb-6 opacity-30"></div>
                
                <p class="text-xl md:text-2xl mb-6 opacity-90 animate-fade-in-up font-light tracking-wide" style="animation-delay: 0.6s;">
                    Clean intelligence. Clear insights.
                </p>
                
                <p class="text-base mb-10 opacity-60 animate-fade-in-up max-w-2xl mx-auto leading-relaxed" style="animation-delay: 0.8s;">
                    Download knowledge. Unlock creativity. Experience the future of artificial intelligence through carefully curated resources.
                </p>
                
                <button onclick="document.getElementById('resources').scrollIntoView({behavior: 'smooth'})"
                        class="group relative animate-pulse-glow bg-white text-black px-8 py-4 rounded-full font-semibold text-base hover:bg-gray-100 transition-all duration-500 animate-fade-in-up overflow-hidden"
                        style="animation-delay: 1s;">
                    <span class="relative z-10">Discover Resources Below</span>
                    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-gray-200 to-transparent transform -skew-x-12 group-hover:animate-shimmer"></div>
                </button>
            </div>
        </div>
        
        <!-- Scroll Indicator -->
        <div class="absolute bottom-12 left-1/2 transform -translate-x-1/2 animate-bounce z-20">
            <div class="w-6 h-12 border-2 border-white border-opacity-30 rounded-full flex justify-center">
                <div class="w-1 h-3 bg-white rounded-full mt-2 animate-pulse opacity-60"></div>
            </div>
        </div>
    </section>

    <!-- Resources Grid Section -->
    <section id="resources" class="py-32 relative z-20 bg-gradient-to-b from-black to-gray-900">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-20">
                <h2 class="text-5xl md:text-6xl font-bold mb-6 text-gradient glow-text">AI Resources Library</h2>
                <div class="h-px bg-gradient-to-r from-transparent via-white to-transparent mb-6 opacity-20 max-w-md mx-auto"></div>
                <p class="text-xl opacity-50 max-w-2xl mx-auto leading-relaxed">
                    Curated knowledge for the future of intelligence. Each resource crafted to accelerate your understanding.
                </p>
            </div>
            
            <!-- Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <template x-for="(card, index) in cards" :key="index">
                    <div class="relative group animate-fade-in-up" :style="`animation-delay: ${index * 0.1}s`">
                        <div class="relative bg-gray-900 rounded-2xl p-8 border border-gray-800 hover-lift overflow-hidden min-h-[280px] flex flex-col"
                             :class="!card.free ? 'opacity-75 cursor-not-allowed' : ''">
                            
                            <!-- Card Number -->
                            <div class="absolute top-4 right-4 w-8 h-8 bg-white text-black rounded-full flex items-center justify-center text-xs font-bold z-20">
                                <span x-text="String(index + 1).padStart(2, '0')"></span>
                            </div>
                            
                            <!-- Lock Badge for Members Only -->
                            <div x-show="card.free === false" class="absolute top-4 left-4 bg-yellow-500 text-black px-3 py-1 rounded-full text-xs font-semibold flex items-center space-x-1 z-20">
                                <span>🔒</span>
                                <span>MEMBERS</span>
                            </div>
                            
                            <!-- Free Badge -->
                            <div x-show="card.free === true" class="absolute top-4 left-4 bg-green-500 text-black px-3 py-1 rounded-full text-xs font-semibold flex items-center space-x-1 z-20">
                                <span>✅</span>
                                <span>FREE</span>
                            </div>
                            
                            <!-- Subtle gradient overlay -->
                            <div class="absolute inset-0 bg-gradient-to-br from-gray-800/20 via-transparent to-gray-700/10 pointer-events-none"></div>
                            
                            <div class="relative z-10 flex flex-col flex-grow">
                                <!-- Title with proper top margin -->
                                <h3 class="text-lg font-semibold mb-4 text-white leading-tight mt-12" 
                                    :class="!card.free ? 'opacity-60' : ''"
                                    x-text="card.title"></h3>
                                
                                <!-- Description -->
                                <p class="text-gray-400 mb-8 leading-relaxed text-sm flex-grow" 
                                   :class="!card.free ? 'opacity-40' : ''"
                                   x-text="card.desc"></p>
                                
                                <!-- Download Button or Locked Message -->
                                <div class="mt-auto">
                                <template x-if="card.free === true">
                                    <div>
                                        @livewire('download-counter')
                                    </div>
                                </template>
                                
                                <template x-if="card.free === false">
                                    <div class="inline-flex items-center space-x-2 bg-gray-700 text-gray-400 px-6 py-3 rounded-lg font-medium border border-gray-600 w-full justify-center cursor-not-allowed">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 0h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                        </svg>
                                        <span>Members Only</span>
                                    </div>
                                </template>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-20 border-t border-gray-800 bg-gray-900 relative z-20">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center">
                <div class="mb-12">
                    <h3 class="text-4xl font-bold text-gradient mb-4 glow-text">ReaneyAI</h3>
                    <div class="h-px bg-gradient-to-r from-transparent via-white to-transparent mb-4 opacity-20 max-w-xs mx-auto"></div>
                    <p class="opacity-40 text-sm tracking-wide">Advancing intelligence, one insight at a time</p>
                </div>
                
                <div class="flex justify-center space-x-8 mb-12">
                    <a href="#" class="group p-4 rounded-full bg-gray-800 border border-gray-700 hover:border-white hover:bg-gray-700 transition-all duration-500 hover-lift"> 
                        <svg class="w-5 h-5 group-hover:scale-110 transition-transform duration-300" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                        </svg>
                    </a>
                    <a href="#" class="group p-4 rounded-full bg-gray-800 border border-gray-700 hover:border-white hover:bg-gray-700 transition-all duration-500 hover-lift">
                        <svg class="w-5 h-5 group-hover:scale-110 transition-transform duration-300" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                        </svg>
                    </a>
                    <a href="#" class="group p-4 rounded-full bg-gray-800 border border-gray-700 hover:border-white hover:bg-gray-700 transition-all duration-500 hover-lift">
                        <svg class="w-5 h-5 group-hover:scale-110 transition-transform duration-300" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                        </svg>
                    </a>
                </div>
                
                <div class="h-px bg-gradient-to-r from-transparent via-gray-700 to-transparent mb-8"></div>
                
                <p class="opacity-30 text-xs tracking-wider font-light">
                    © 2025 ReaneyAI. All rights reserved. Built with intelligence and precision.
                </p>
            </div>
        </div>
    </footer>
    @livewireScripts
</body>
</html>