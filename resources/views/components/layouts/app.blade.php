<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'ReaneyAI - Clean Intelligence. Clear Insights.' }}</title>
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
        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f0f23 100%);
            background-size: 400% 400%;
            animation: gradientShift 12s ease-in-out infinite;
            min-height: 100vh;
        }
        
        .text-gradient {
            background: linear-gradient(135deg, #ffffff 0%, #a8a8a8 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .glass-effect {
            backdrop-filter: blur(20px);
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        }
        
        .minimal-shadow {
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        }
        
        .hover-lift:hover {
            transform: translateY(-5px);
            transition: transform 0.3s ease;
        }
        
        .glow-text {
            text-shadow: 0 0 30px rgba(255, 255, 255, 0.3);
        }
        
        .shimmer-effect {
            overflow: hidden;
            position: relative;
        }
        
        .shimmer-effect::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            animation: shimmer 2s infinite;
        }
        
        .slider::-webkit-slider-thumb {
            appearance: none;
            height: 20px;
            width: 20px;
            border-radius: 50%;
            background: linear-gradient(135deg, #ffffff 0%, #a8a8a8 100%);
            cursor: pointer;
            box-shadow: 0 2px 10px rgba(255, 255, 255, 0.3);
        }
        
        .slider::-moz-range-thumb {
            height: 20px;
            width: 20px;
            border-radius: 50%;
            background: linear-gradient(135deg, #ffffff 0%, #a8a8a8 100%);
            cursor: pointer;
            border: none;
            box-shadow: 0 2px 10px rgba(255, 255, 255, 0.3);
        }
    </style>
</head>
<body 
    class="min-h-screen text-white"
    x-data="{ loaded: false }"
    x-init="setTimeout(() => loaded = true, 100)">
    
    {{ $slot }}
    
    @livewireScripts
    
    <script>
        // Enhanced interaction feedback
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('prompt-generated', (event) => {
                // Show success notification
                console.log('Success:', event.message);
                // You can add toast notifications here
            });
            
            Livewire.on('ai-error', (event) => {
                // Show error notification
                console.error('Error:', event.message);
                // You can add toast notifications here
            });
            
            Livewire.on('prompt-copied', () => {
                console.log('Prompt copied to clipboard!');
                // You can add toast notifications here
            });
        });
        
        // Copy to clipboard functionality
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(() => {
                Livewire.dispatch('prompt-copied');
            }).catch(err => {
                console.error('Failed to copy: ', err);
            });
        }
    </script>
</body>
</html>

