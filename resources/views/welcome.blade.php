<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>ReaneyAI — AI for Everyone</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@alpinejs/intersect@3.x.x/dist/cdn.min.js"></script>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap');
    
    body {
      font-family: 'Inter', sans-serif;
    }
    
    .glass {
      backdrop-filter: blur(20px);
      -webkit-backdrop-filter: blur(20px);
    }
    
    .gradient-bg {
      background: linear-gradient(135deg, 
        rgba(29, 161, 242, 0.1) 0%, 
        rgba(26, 145, 218, 0.05) 25%,
        rgba(0, 0, 0, 0.8) 50%,
        rgba(20, 184, 166, 0.05) 75%,
        rgba(59, 130, 246, 0.1) 100%);
    }
    
    .particle {
      position: absolute;
      border-radius: 50%;
      pointer-events: none;
      animation: float 6s ease-in-out infinite;
    }
    
    @keyframes float {
      0%, 100% { transform: translateY(0px) rotate(0deg); }
      33% { transform: translateY(-20px) rotate(120deg); }
      66% { transform: translateY(10px) rotate(240deg); }
    }
    
    .hover-lift {
      transition: all 0.4s cubic-bezier(0.23, 1, 0.32, 1);
    }
    
    .hover-lift:hover {
      transform: translateY(-8px) scale(1.02);
    }
    
    .glow-blue {
      box-shadow: 0 0 20px rgba(29, 161, 242, 0.3);
    }
    
    .text-glow {
      text-shadow: 0 0 30px rgba(29, 161, 242, 0.5);
    }
    
    .cursor-trail {
      position: fixed;
      width: 20px;
      height: 20px;
      background: radial-gradient(circle, rgba(29, 161, 242, 0.3) 0%, transparent 70%);
      border-radius: 50%;
      pointer-events: none;
      z-index: 9999;
      transition: all 0.3s ease;
    }
    
    @keyframes spin-slow {
      from { transform: rotate(0deg); }
      to { transform: rotate(360deg); }
    }
    
    @keyframes reverse-spin {
      from { transform: rotate(360deg); }
      to { transform: rotate(0deg); }
    }
    
    .animate-spin-slow {
      animation: spin-slow 20s linear infinite;
    }
    
    .animate-reverse-spin {
      animation: reverse-spin 15s linear infinite;
    }
  </style>
</head>
<body class="bg-black text-white overflow-x-hidden" 
      x-data="{
        mouseX: 0,
        mouseY: 0,
        showEmailModal: false,
        email: '',
        isSubmitting: false,
        isSubmitted: false,
        particles: Array.from({length: 50}, (_, i) => ({
          id: i,
          x: Math.random() * 100,
          y: Math.random() * 100,
          size: Math.random() * 4 + 1,
          speed: Math.random() * 2 + 1
        })),
        async submitEmail() {
          if (!this.email || !this.email.includes('@')) {
            return;
          }
          this.isSubmitting = true;
          try {
            const response = await fetch('/api/early-access/signup', {
              method: 'POST',
              headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]')?.getAttribute('content') || ''
              },
              body: JSON.stringify({ email: this.email })
            });
            const data = await response.json();
            if (data.success) {
              this.isSubmitting = false;
              this.isSubmitted = true;
              setTimeout(() => {
                this.showEmailModal = false;
                this.isSubmitted = false;
                this.email = '';
              }, 2500);
            } else {
              this.isSubmitting = false;
              alert(data.message || 'Something went wrong. Please try again.');
            }
          } catch (error) {
            this.isSubmitting = false;
            console.error('Error submitting email:', error);
            alert('Something went wrong. Please try again.');
          }
        }
      }"
      @mousemove="mouseX = $event.clientX; mouseY = $event.clientY"
      @keydown.escape="showEmailModal = false">

  <!-- Cursor Trail -->
  <div class="cursor-trail" 
       :style="`left: ${mouseX - 10}px; top: ${mouseY - 10}px; opacity: ${mouseX > 0 ? 1 : 0}`"></div>

  <!-- Email Signup Modal -->
  <div x-show="showEmailModal" 
       x-transition:enter="transition ease-out duration-300" 
       x-transition:enter-start="opacity-0" 
       x-transition:enter-end="opacity-100"
       x-transition:leave="transition ease-in duration-200" 
       x-transition:leave-start="opacity-100" 
       x-transition:leave-end="opacity-0"
       class="fixed inset-0 z-50 flex items-center justify-center p-4"
       @click.self="showEmailModal = false">
    
    <!-- Modal Backdrop -->
    <div class="absolute inset-0 bg-black/80 backdrop-blur-sm"></div>
    
    <!-- Modal Content -->
    <div x-show="showEmailModal"
         x-transition:enter="transition ease-out duration-300 delay-100" 
         x-transition:enter-start="opacity-0 transform scale-95 translate-y-8" 
         x-transition:enter-end="opacity-100 transform scale-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200" 
         x-transition:leave-start="opacity-100 transform scale-100 translate-y-0" 
         x-transition:leave-end="opacity-0 transform scale-95 translate-y-8"
         class="relative glass bg-gradient-to-br from-white/15 to-white/5 backdrop-blur-2xl border border-white/20 rounded-3xl p-8 shadow-2xl max-w-md w-full mx-4 overflow-hidden">
      
      <!-- Ambient Glow -->
      <div class="absolute -inset-4 bg-gradient-to-br from-blue-500/20 to-cyan-500/10 rounded-[2rem] blur-xl opacity-60"></div>
      
      <!-- Close Button -->
      <button @click="showEmailModal = false" 
              class="absolute top-4 right-4 w-8 h-8 flex items-center justify-center rounded-full glass bg-white/10 hover:bg-white/20 transition-colors duration-200 group">
        <svg class="w-5 h-5 text-gray-400 group-hover:text-white transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
      </button>
      
      <!-- Modal Header -->
      <div class="relative z-10 text-center mb-8">
        <div class="w-16 h-16 mx-auto mb-4 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-2xl flex items-center justify-center">
          <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM9 3H4v5l5-5zM7 21l7-7-7 7zM3 9l9 9-9-9z"></path>
          </svg>
        </div>
        <h3 class="text-3xl font-bold mb-2 bg-gradient-to-r from-blue-400 to-cyan-400 bg-clip-text text-transparent">
          Get Early Access
        </h3>
        <p class="text-gray-300 leading-relaxed">
          Be the first to know when ReaneyAI Membership launches on <strong class="text-orange-400">October 16, 2025</strong>
        </p>
      </div>
      
      <!-- Success State -->
      <div x-show="isSubmitted" 
           x-transition:enter="transition ease-out duration-300" 
           x-transition:enter-start="opacity-0 transform scale-95" 
           x-transition:enter-end="opacity-100 transform scale-100"
           class="relative z-10 text-center">
        <div class="w-16 h-16 mx-auto mb-4 bg-gradient-to-br from-green-500 to-emerald-500 rounded-full flex items-center justify-center">
          <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
          </svg>
        </div>
        <h4 class="text-2xl font-bold text-green-400 mb-2">You're In!</h4>
        <p class="text-gray-300">We'll notify you as soon as membership opens.</p>
      </div>
      
      <!-- Email Form -->
      <form x-show="!isSubmitted" 
            @submit.prevent="submitEmail()"
            class="relative z-10 space-y-6">
        
        <div class="space-y-4">
          <div>
            <label for="email" class="block text-sm font-medium text-gray-300 mb-2">Email Address</label>
            <input type="email" 
                   id="email"
                   x-model="email"
                   placeholder="your@email.com"
                   required
                   class="w-full px-4 py-3 glass bg-white/10 border border-white/20 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition-all duration-200"
                   :disabled="isSubmitting">
          </div>
          
          <div class="text-xs text-gray-400 leading-relaxed">
            <p>✓ No spam, ever. Just a single notification when we launch.</p>
            <p>✓ Early access to exclusive features and content.</p>
          </div>
        </div>
        
        <button type="submit" 
                :disabled="!email || !email.includes('@') || isSubmitting"
                class="w-full bg-gradient-to-r from-blue-500 to-cyan-500 text-white font-bold py-3 px-6 rounded-xl shadow-lg hover:shadow-xl disabled:opacity-50 disabled:cursor-not-allowed transition-all duration-300 relative overflow-hidden group"
                :class="isSubmitting ? 'cursor-wait' : ''">
          
          <!-- Loading State -->
          <span x-show="isSubmitting" class="flex items-center justify-center space-x-2">
            <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
              <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span>Signing you up...</span>
          </span>
          
          <!-- Normal State -->
          <span x-show="!isSubmitting" class="relative z-10">Notify Me When Available</span>
          <div class="absolute inset-0 bg-gradient-to-r from-cyan-500 to-blue-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
        </button>
      </form>
    </div>
  </div>

  <!-- Floating Particles Background -->
  <div class="fixed inset-0 overflow-hidden pointer-events-none z-0">
    <template x-for="particle in particles" :key="particle.id">
      <div class="particle"
           :style="`
             left: ${particle.x}%;
             top: ${particle.y}%;
             width: ${particle.size}px;
             height: ${particle.size}px;
             background: radial-gradient(circle, rgba(29, 161, 242, 0.6) 0%, rgba(20, 184, 166, 0.4) 50%, transparent 100%);
             animation-delay: ${particle.id * 0.1}s;
             animation-duration: ${4 + particle.speed}s;
           `"></div>
    </template>
  </div>

  <!-- Hero Section -->
  <section class="relative min-h-screen flex flex-col justify-center items-center text-center px-6 gradient-bg">
    <div class="absolute inset-0 glass opacity-30"></div>
    
    <div class="relative z-10 max-w-5xl mx-auto"
         x-data="{ loaded: false }"
         x-init="setTimeout(() => loaded = true, 100)">
      
      <h1 class="text-6xl md:text-8xl font-black mb-8 text-glow leading-tight"
          x-show="loaded"
          x-transition:enter="transition ease-out duration-1000 delay-300"
          x-transition:enter-start="opacity-0 transform translate-y-16"
          x-transition:enter-end="opacity-100 transform translate-y-0">
        AI that belongs to <span class="bg-gradient-to-r from-blue-400 via-cyan-400 to-blue-500 bg-clip-text text-transparent">Everyone</span>
      </h1>
      
      <p class="max-w-4xl mx-auto text-xl md:text-2xl text-gray-300 mb-8 font-light leading-relaxed"
         x-show="loaded"
         x-transition:enter="transition ease-out duration-1000 delay-700"
         x-transition:enter-start="opacity-0 transform translate-y-12"
         x-transition:enter-end="opacity-100 transform translate-y-0">
        Not just the privileged. Not just the young. <strong class="text-white">Everyone.</strong>
      </p>
      
      <p class="max-w-3xl mx-auto text-lg md:text-xl text-gray-400 mb-12 font-light leading-relaxed"
         x-show="loaded"
         x-transition:enter="transition ease-out duration-1000 delay-900"
         x-transition:enter-start="opacity-0 transform translate-y-8"
         x-transition:enter-end="opacity-100 transform translate-y-0">
        Too often, new technology gets locked away. ReaneyAI exists to break down those walls. 
        To make AI simple, human, and open to anyone who's curious.
      </p>
      
      <div x-show="loaded"
           x-transition:enter="transition ease-out duration-1000 delay-1000"
           x-transition:enter-start="opacity-0 transform translate-y-8"
           x-transition:enter-end="opacity-100 transform translate-y-0">
        <a href="#join" 
           class="inline-block bg-gradient-to-r from-blue-500 to-cyan-500 text-white font-bold py-4 px-12 rounded-2xl shadow-2xl hover-lift glow-blue relative overflow-hidden group"
           @mouseenter="$el.style.transform = 'translateY(-8px) scale(1.05)'"
           @mouseleave="$el.style.transform = 'translateY(0) scale(1)'">
          <span class="relative z-10">Join the Movement</span>
          <div class="absolute inset-0 bg-gradient-to-r from-cyan-500 to-blue-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
        </a>
      </div>
    </div>

    <!-- Scroll Indicator -->
    <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2"
         x-show="loaded"
         x-transition:enter="transition ease-out duration-1000 delay-1500"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100">
      <div class="w-6 h-10 border-2 border-gray-400 rounded-full flex justify-center">
        <div class="w-1 h-3 bg-gray-400 rounded-full mt-2 animate-bounce"></div>
      </div>
    </div>
  </section>

  <!-- Cameron's Story Section -->
  <section class="py-32 px-6 bg-gradient-to-b from-transparent to-blue-900/5">
    <div class="max-w-6xl mx-auto">
      <div class="grid lg:grid-cols-2 gap-16 items-stretch">
        <!-- Image Side -->
        <div x-data="{ visible: false }" x-intersect="visible = true">
          <div class="relative h-full"
               x-show="visible"
               x-transition:enter="transition ease-out duration-1000"
               x-transition:enter-start="opacity-0 transform translate-x-12"
               x-transition:enter-end="opacity-100 transform translate-x-0">
            <div class="glass bg-gradient-to-br from-white/10 to-white/5 backdrop-blur-xl border border-white/20 rounded-3xl p-8 hover-lift h-full flex flex-col justify-center">
              <div class="aspect-square bg-gradient-to-br from-blue-500/20 to-cyan-500/20 rounded-2xl overflow-hidden mb-6 relative max-w-sm mx-auto">
                <img src="/cameron.png" 
                     alt="Cameron Reaney, Founder of ReaneyAI" 
                     class="w-full h-full object-cover rounded-2xl"
                     style="object-position: center;">
                <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent rounded-2xl"></div>
              </div>
              <div class="text-center">
                <h3 class="text-2xl font-bold mb-2 text-blue-400">Cameron Reaney</h3>
                <p class="text-gray-400">Founder & Chief Educator</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Content Side -->
        <div x-data="{ visible: false }" x-intersect="visible = true">
          <div x-show="visible"
               x-transition:enter="transition ease-out duration-1000 delay-300"
               x-transition:enter-start="opacity-0 transform translate-x-12"
               x-transition:enter-end="opacity-100 transform translate-x-0">
            <h2 class="text-4xl md:text-5xl font-bold mb-8">
              Meet <span class="bg-gradient-to-r from-blue-400 to-cyan-400 bg-clip-text text-transparent">Cameron</span>
            </h2>
            
            <div class="space-y-6 text-lg text-gray-300 leading-relaxed">
              <p>
                <strong class="text-white">I'm not the world's greatest AI expert.</strong> And that's exactly the point.
              </p>
              
              <p>
                I'm Cameron, founder of ReaneyAI. My background spans web agencies, dev teams, blockchain, 
                and creative collectives. <strong class="text-blue-400">One thread connects everything: 
                using technology to empower people.</strong>
              </p>
              
              <p>
                But I've seen how quickly new tools leave people behind. AI risks becoming another divide. 
                <strong class="text-white">That's why I created ReaneyAI.</strong>
              </p>
              
              <div class="glass bg-white/5 backdrop-blur-xl border border-white/10 rounded-2xl p-6 mt-8">
                <p class="text-xl font-semibold text-blue-400 mb-3">My Promise:</p>
                <p class="text-gray-200">
                  <strong class="text-white">AI for everyone. Nobody left behind.</strong> 
                  No jargon, no corporate agenda. Just honest education that meets you where you are.
                </p>
              </div>
            </div>
        </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Mission Manifesto Section -->
  <section class="py-32 px-6 bg-gradient-to-b from-blue-900/5 to-transparent relative overflow-hidden">
    <!-- Background Elements -->
    <div class="absolute inset-0 opacity-10">
      <div class="absolute top-20 left-10 w-32 h-32 bg-blue-500 rounded-full blur-3xl"></div>
      <div class="absolute bottom-20 right-10 w-40 h-40 bg-cyan-500 rounded-full blur-3xl"></div>
    </div>
    
    <div class="max-w-7xl mx-auto relative z-10">
      <div x-data="{ visible: false }" x-intersect="visible = true">
        <div class="text-center mb-20">
          <h2 class="text-5xl md:text-7xl font-black mb-8"
              x-show="visible"
              x-transition:enter="transition ease-out duration-1000"
              x-transition:enter-start="opacity-0 transform translate-y-16"
              x-transition:enter-end="opacity-100 transform translate-y-0">
            What We <span class="bg-gradient-to-r from-blue-400 via-cyan-400 to-blue-500 bg-clip-text text-transparent">Stand For</span>
          </h2>
          <p class="text-xl md:text-2xl text-gray-300 max-w-4xl mx-auto leading-relaxed"
             x-show="visible"
             x-transition:enter="transition ease-out duration-1000 delay-300"
             x-transition:enter-start="opacity-0 transform translate-y-12"
             x-transition:enter-end="opacity-100 transform translate-y-0">
            This isn't just about AI education. This is about <strong class="text-white">fighting for a future where technology serves everyone.</strong>
          </p>
        </div>
        
        <!-- Revolutionary Values Interface -->
        <div class="relative" 
             x-data="{ 
               activeCard: null,
               hoverEffect: false,
               cardStates: {
                 against: { particles: [], glowIntensity: 0 },
                 for: { particles: [], glowIntensity: 0 }
               }
             }"
             x-init="
               // Initialize particle systems for each card
               setInterval(() => {
                 if (activeCard === 'against') cardStates.against.glowIntensity = Math.sin(Date.now() * 0.003) * 0.3 + 0.7;
                 if (activeCard === 'for') cardStates.for.glowIntensity = Math.sin(Date.now() * 0.003) * 0.3 + 0.7;
               }, 50);
             ">
          
          <!-- Dynamic Connection Line -->
          <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-0">
            <div class="w-24 h-1 bg-gradient-to-r from-red-500/30 via-white/20 to-green-500/30 rounded-full"
                 :class="activeCard ? 'animate-pulse' : ''"></div>
          </div>

          <!-- VS Badge -->
          <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-10">
            <div class="glass bg-black/80 backdrop-blur-xl border border-white/30 rounded-full w-16 h-16 flex items-center justify-center">
              <span class="text-white font-black text-sm tracking-wider">VS</span>
            </div>
          </div>

          <div class="grid lg:grid-cols-2 gap-12 relative z-5">
            <!-- FIGHT AGAINST Card -->
            <div class="group relative"
                 @mouseenter="activeCard = 'against'; hoverEffect = true"
                 @mouseleave="activeCard = null; hoverEffect = false"
                 x-show="visible"
                 x-transition:enter="transition ease-out duration-1200 delay-400"
                 x-transition:enter-start="opacity-0 transform translate-x-16 rotate-3"
                 x-transition:enter-end="opacity-100 transform translate-x-0 rotate-0">
              
              <!-- Ambient Glow Effects -->
              <div class="absolute -inset-4 bg-gradient-to-br from-red-500/20 to-orange-600/10 rounded-[2rem] blur-xl opacity-0 group-hover:opacity-100 transition-all duration-700"></div>
              <div class="absolute -inset-2 bg-gradient-to-br from-red-500/10 to-orange-500/5 rounded-[1.8rem] opacity-0 group-hover:opacity-60 transition-all duration-500"></div>
              
              <!-- Main Card -->
              <div class="relative glass bg-gradient-to-br from-red-500/15 to-orange-500/8 backdrop-blur-2xl border border-red-500/30 rounded-3xl p-8 overflow-hidden transition-all duration-500 group-hover:border-red-400/50 group-hover:shadow-2xl group-hover:shadow-red-500/20"
                   :class="activeCard === 'against' ? 'scale-[1.02] -rotate-1' : ''">
                
                <!-- Animated Background Pattern -->
                <div class="absolute inset-0 opacity-5">
                  <div class="absolute top-4 right-4 w-32 h-32 border border-red-500 rounded-full animate-spin-slow"></div>
                  <div class="absolute bottom-4 left-4 w-24 h-24 border border-orange-500 rounded-full animate-reverse-spin"></div>
                </div>
                
                <!-- Header with Advanced Typography -->
                <div class="relative z-10 mb-8">
                  <div class="flex items-center space-x-4 mb-4">
                    <div class="relative">
                      <div class="w-14 h-14 bg-gradient-to-br from-red-500 to-orange-600 rounded-2xl flex items-center justify-center relative overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-br from-white/20 to-transparent"></div>
                        <div class="w-6 h-6 bg-white/90 rounded-full relative">
                          <div class="absolute inset-1 bg-red-500 rounded-full"></div>
                        </div>
                      </div>
                      <div class="absolute -top-1 -right-1 w-4 h-4 bg-red-400 rounded-full animate-ping opacity-75"></div>
                    </div>
                    <div>
                      <h3 class="text-2xl font-black text-red-400 tracking-tight">FIGHT AGAINST</h3>
                      <p class="text-red-300/60 text-sm font-medium">What We Oppose</p>
                    </div>
                  </div>
                </div>

                <!-- Advanced List Items -->
                <div class="space-y-5">
                  <template x-for="(item, index) in [
                    { title: 'Corporate Gatekeeping', desc: 'Knowledge locked behind paywalls and privilege' },
                    { title: 'Intimidating Jargon', desc: 'Making people feel stupid for asking questions' },
                    { title: 'Age Discrimination', desc: 'Technology is only for young people mentality' },
                    { title: 'Fear-Mongering', desc: 'Scaring people instead of empowering them' },
                    { title: 'Profit Over People', desc: 'Selling courses instead of building movements' }
                  ]" :key="index">
                    <div class="group/item flex items-start space-x-4 p-3 rounded-2xl transition-all duration-300 hover:bg-red-500/10 hover:scale-[1.02]"
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 transform translate-x-4"
                         x-transition:enter-end="opacity-100 transform translate-x-0"
                         :style="`transition-delay: ${index * 100 + 600}ms`">
                      
                      <!-- Animated X Icon -->
                      <div class="relative flex-shrink-0 mt-1">
                        <div class="w-6 h-6 flex items-center justify-center">
                          <div class="absolute w-4 h-0.5 bg-red-400 rounded-full transform rotate-45 group-hover/item:rotate-180 transition-transform duration-300"></div>
                          <div class="absolute w-4 h-0.5 bg-red-400 rounded-full transform -rotate-45 group-hover/item:-rotate-180 transition-transform duration-300"></div>
                        </div>
                      </div>
                      
                      <div class="flex-1 min-w-0">
                        <h4 class="text-white font-bold text-lg mb-1 group-hover/item:text-red-300 transition-colors duration-300" 
                            x-text="item.title"></h4>
                        <p class="text-gray-400 text-sm leading-relaxed group-hover/item:text-gray-300 transition-colors duration-300" 
                           x-text="item.desc"></p>
                      </div>
                    </div>
                  </template>
                </div>
              </div>
            </div>

            <!-- FIGHT FOR Card -->
            <div class="group relative"
                 @mouseenter="activeCard = 'for'; hoverEffect = true"
                 @mouseleave="activeCard = null; hoverEffect = false"
                 x-show="visible"
                 x-transition:enter="transition ease-out duration-1200 delay-600"
                 x-transition:enter-start="opacity-0 transform translate-x-16 rotate-3"
                 x-transition:enter-end="opacity-100 transform translate-x-0 rotate-0">
              
              <!-- Ambient Glow Effects -->
              <div class="absolute -inset-4 bg-gradient-to-br from-green-500/20 to-blue-600/10 rounded-[2rem] blur-xl opacity-0 group-hover:opacity-100 transition-all duration-700"></div>
              <div class="absolute -inset-2 bg-gradient-to-br from-green-500/10 to-blue-500/5 rounded-[1.8rem] opacity-0 group-hover:opacity-60 transition-all duration-500"></div>
              
              <!-- Main Card -->
              <div class="relative glass bg-gradient-to-br from-green-500/15 to-blue-500/8 backdrop-blur-2xl border border-green-500/30 rounded-3xl p-8 overflow-hidden transition-all duration-500 group-hover:border-green-400/50 group-hover:shadow-2xl group-hover:shadow-green-500/20"
                   :class="activeCard === 'for' ? 'scale-[1.02] rotate-1' : ''">
                
                <!-- Animated Background Pattern -->
                <div class="absolute inset-0 opacity-5">
                  <div class="absolute top-4 left-4 w-32 h-32 border border-green-500 rounded-full animate-spin-slow"></div>
                  <div class="absolute bottom-4 right-4 w-24 h-24 border border-blue-500 rounded-full animate-reverse-spin"></div>
                </div>
                
                <!-- Header with Advanced Typography -->
                <div class="relative z-10 mb-8">
                  <div class="flex items-center space-x-4 mb-4">
                    <div class="relative">
                      <div class="w-14 h-14 bg-gradient-to-br from-green-500 to-blue-600 rounded-2xl flex items-center justify-center relative overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-br from-white/20 to-transparent"></div>
                        <div class="w-6 h-6 bg-white/90 rounded-full relative">
                          <div class="absolute inset-1 bg-green-500 rounded-full"></div>
                        </div>
                      </div>
                      <div class="absolute -top-1 -right-1 w-4 h-4 bg-green-400 rounded-full animate-ping opacity-75"></div>
                    </div>
                    <div>
                      <h3 class="text-2xl font-black text-green-400 tracking-tight">FIGHT FOR</h3>
                      <p class="text-green-300/60 text-sm font-medium">What We Champion</p>
                    </div>
                  </div>
                </div>

                <!-- Advanced List Items -->
                <div class="space-y-5">
                  <template x-for="(item, index) in [
                    { title: 'Radical Inclusion', desc: 'Education for every age, background, and learning style' },
                    { title: 'Human-First Language', desc: 'Clear explanations that respect your intelligence' },
                    { title: 'Empowerment Over Fear', desc: 'Confidence-building, not intimidation' },
                    { title: 'Free Core Knowledge', desc: 'Essential literacy should never cost money' },
                    { title: 'Mission Over Profit', desc: 'Building movements, not just selling products' }
                  ]" :key="index">
                    <div class="group/item flex items-start space-x-4 p-3 rounded-2xl transition-all duration-300 hover:bg-green-500/10 hover:scale-[1.02]"
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 transform translate-x-4"
                         x-transition:enter-end="opacity-100 transform translate-x-0"
                         :style="`transition-delay: ${index * 100 + 800}ms`">
                      
                      <!-- Animated Check Icon -->
                      <div class="relative flex-shrink-0 mt-1">
                        <div class="w-6 h-6 flex items-center justify-center">
                          <div class="w-5 h-5 border-2 border-green-400 rounded-full relative overflow-hidden group-hover/item:border-green-300 transition-colors duration-300">
                            <div class="absolute inset-0 bg-green-400 rounded-full scale-0 group-hover/item:scale-100 transition-transform duration-300"></div>
                            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                              <div class="w-2 h-1 border-l-2 border-b-2 border-white transform -rotate-45 scale-0 group-hover/item:scale-100 transition-transform duration-300 delay-100"></div>
                            </div>
                          </div>
                        </div>
                      </div>
                      
                      <div class="flex-1 min-w-0">
                        <h4 class="text-white font-bold text-lg mb-1 group-hover/item:text-green-300 transition-colors duration-300" 
                            x-text="item.title"></h4>
                        <p class="text-gray-400 text-sm leading-relaxed group-hover/item:text-gray-300 transition-colors duration-300" 
                           x-text="item.desc"></p>
                      </div>
                    </div>
                  </template>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Bold Statement -->
        <div class="my-32"
             x-data="{ visible: false }"
             x-intersect="visible = true">
          <div class="max-w-6xl mx-auto text-center"
               x-show="visible"
               x-transition:enter="transition ease-out duration-1200"
               x-transition:enter-start="opacity-0 transform scale-95"
               x-transition:enter-end="opacity-100 transform scale-100">
            
            <!-- Main Statement -->
            <div class="mb-20">
              <h2 class="text-4xl md:text-6xl lg:text-7xl font-black leading-tight mb-8">
                <span class="text-white">We believe technology should</span><br>
                <span class="bg-gradient-to-r from-blue-400 via-cyan-400 to-blue-500 bg-clip-text text-transparent">lift people up</span><br>
                <span class="text-gray-400">not leave them behind</span>
              </h2>
            </div>

            <!-- Simple Promise -->
            <div class="max-w-4xl mx-auto mb-16">
              <p class="text-xl md:text-2xl text-gray-300 leading-relaxed font-light">
                ReaneyAI isn't about selling you courses or making you an expert. 
                It's about giving you <strong class="text-blue-400">clarity, confidence, and belonging</strong> in a world where technology moves fast.
              </p>
            </div>

            <!-- Mission Line -->
            <div class="border-t border-white/20 pt-16">
              <p class="text-2xl md:text-3xl font-bold text-white">
                Technology for everyone. <span class="text-blue-400">Nobody left behind.</span>
              </p>
            </div>
          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- Call to Action Bridge Section -->
  <section class="py-24 px-6 bg-gradient-to-b from-transparent via-blue-900/10 to-transparent">
    <div class="max-w-5xl mx-auto text-center">
      <div x-data="{ visible: false }" x-intersect="visible = true">
        
        <!-- Main CTA Message -->
        <div x-show="visible"
             x-transition:enter="transition ease-out duration-1000"
             x-transition:enter-start="opacity-0 transform translate-y-12"
             x-transition:enter-end="opacity-100 transform translate-y-0">
          
          <h2 class="text-3xl md:text-5xl font-bold mb-8 leading-tight">
            Ready to be part of something <span class="bg-gradient-to-r from-blue-400 to-cyan-400 bg-clip-text text-transparent">bigger</span>?
          </h2>
          
          <p class="text-xl md:text-2xl text-gray-300 mb-8 max-w-4xl mx-auto leading-relaxed">
            This isn't just about learning AI. It's about building a world where technology 
            <strong class="text-white">belongs to everyone</strong>, not just the privileged few.
          </p>
          
          <div class="glass bg-gradient-to-br from-white/10 to-white/5 backdrop-blur-xl border border-white/20 rounded-2xl p-8 max-w-3xl mx-auto mb-12">
            <p class="text-lg text-gray-200 leading-relaxed">
              <strong class="text-blue-400">Join thousands</strong> who believe AI should be accessible, 
              understandable, and available to people of all ages and backgrounds. 
              <strong class="text-white">Your support makes free education possible for everyone.</strong>
            </p>
          </div>
          
          <!-- Visual Connector -->
          <div class="relative">
            <div class="w-1 h-16 bg-gradient-to-b from-blue-500 via-cyan-400 to-transparent mx-auto opacity-30"></div>
            <div class="absolute top-12 left-1/2 transform -translate-x-1/2">
              <div class="w-3 h-3 bg-blue-400 rounded-full animate-pulse"></div>
            </div>
          </div>
        </div>
        
      </div>
    </div>
  </section>

  <!-- Pricing Section -->
  <section id="join" class="py-32 px-6">
    <div class="max-w-4xl mx-auto text-center">
      <div x-data="{ visible: false }" x-intersect="visible = true">
        <h2 class="text-5xl md:text-6xl font-bold mb-8"
            x-show="visible"
            x-transition:enter="transition ease-out duration-800"
            x-transition:enter-start="opacity-0 transform translate-y-12"
            x-transition:enter-end="opacity-100 transform translate-y-0">
          Join the <span class="bg-gradient-to-r from-blue-400 to-cyan-400 bg-clip-text text-transparent">Movement</span>
        </h2>
        
        <div class="max-w-4xl mx-auto mb-16"
             x-show="visible"
             x-transition:enter="transition ease-out duration-800 delay-200"
             x-transition:enter-start="opacity-0 transform translate-y-8"
             x-transition:enter-end="opacity-100 transform translate-y-0">
          <p class="text-xl md:text-2xl text-gray-200 mb-6 leading-relaxed">
            <strong class="text-white">Our core mission will always be free.</strong> 
            Essential AI education belongs to everyone, no matter your budget.
          </p>
          <p class="text-lg text-gray-300 leading-relaxed">
            But for those who want to dive deeper and support our mission, 
            we offer exclusive content that funds our work and keeps everything else free for everyone.
          </p>
        </div>

        <div class="glass bg-gradient-to-br from-gray-700/20 to-gray-800/20 backdrop-blur-xl border border-gray-500/30 rounded-3xl p-12 shadow-2xl max-w-lg mx-auto opacity-75 transition-all duration-500"
             x-show="visible"
             x-transition:enter="transition ease-out duration-1000 delay-400"
             x-transition:enter-start="opacity-0 transform translate-y-16 scale-95"
             x-transition:enter-end="opacity-100 transform translate-y-0 scale-100">
          
          <div class="relative">
            <div class="absolute -top-4 left-1/2 transform -translate-x-1/2">
              <span class="bg-gradient-to-r from-gray-600 to-gray-700 text-gray-200 px-4 py-1 rounded-full text-sm font-semibold">
                Coming Soon
              </span>
            </div>
            
            <h3 class="text-3xl font-bold mb-4 text-gray-300 transition-colors duration-300">
              Membership
            </h3>
            <p class="text-gray-500 mb-8">Support the mission. Unlock the deeper tools.</p>
            
            <div class="text-4xl font-black mb-8 text-gray-400">
              <div class="text-2xl font-semibold text-orange-400 mb-2">Launching</div>
              <div class="text-3xl">October 16, 2025</div>
            </div>

            <ul class="text-left text-gray-400 mb-10 space-y-4">
              <li class="flex items-center space-x-3">
                <span class="text-gray-500 text-xl">✓</span>
                <span><strong>Deep-dive dispatches</strong> — essays and insights you won't find anywhere else</span>
              </li>
              <li class="flex items-center space-x-3">
                <span class="text-gray-500 text-xl">✓</span>
                <span><strong>Advanced lesson series</strong> — beyond the basics, for those ready to go deeper</span>
              </li>
              <li class="flex items-center space-x-3">
                <span class="text-gray-500 text-xl">✓</span>
                <span><strong>Community voice</strong> — help shape what we build and teach next</span>
              </li>
              <li class="flex items-center space-x-3">
                <span class="text-gray-500 text-xl">✓</span>
                <span><strong>Mission support</strong> — keep free education available for everyone</span>
              </li>
        </ul>

        <button @click="console.log('Button clicked'); showEmailModal = true" 
                class="block w-full bg-gradient-to-r from-blue-500 to-cyan-500 text-white font-bold py-4 px-8 rounded-2xl shadow-lg hover:shadow-xl relative overflow-hidden group transition-all duration-300 hover-lift"
                @mouseenter="$el.style.transform = 'scale(1.02)'"
                @mouseleave="$el.style.transform = 'scale(1)'">
              <span class="relative z-10">Notify Me When Available</span>
              <div class="absolute inset-0 bg-gradient-to-r from-cyan-500 to-blue-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            </button>

      <p class="text-sm text-gray-500 mt-6">
        Sign up for early access and be the first to know when we launch.
      </p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="py-20 px-6 bg-black border-t border-white/10">
    <div class="max-w-6xl mx-auto">
      <div class="text-center"
           x-data="{ visible: false }"
           x-intersect="visible = true">
        <div x-show="visible"
             x-transition:enter="transition ease-out duration-800"
             x-transition:enter-start="opacity-0 transform translate-y-8"
             x-transition:enter-end="opacity-100 transform translate-y-0">
          <div class="mb-16">
            <h3 class="text-4xl font-bold mb-6 bg-gradient-to-r from-blue-400 to-cyan-400 bg-clip-text text-transparent">
              ReaneyAI
            </h3>
            <p class="text-xl text-gray-300 max-w-3xl mx-auto mb-6 leading-relaxed">
              Technology without gatekeepers. Learning without barriers. 
              <strong class="text-white">For everyone.</strong>
            </p>
            <p class="text-gray-400 max-w-2xl mx-auto leading-relaxed">
              Because the future isn't just for a few — it's for all of us.
            </p>
          </div>
          
          <div class="grid md:grid-cols-3 gap-8 mb-12 max-w-4xl mx-auto">
            <div class="text-center">
              <h4 class="font-semibold text-blue-400 mb-2">Mission</h4>
              <p class="text-gray-400 text-sm">Making AI accessible to everyone, regardless of age or background</p>
            </div>
            <div class="text-center">
              <h4 class="font-semibold text-blue-400 mb-2">Values</h4>
              <p class="text-gray-400 text-sm">Inclusion over exclusion. Clarity over jargon. People over profit.</p>
            </div>
            <div class="text-center">
              <h4 class="font-semibold text-blue-400 mb-2">Promise</h4>
              <p class="text-gray-400 text-sm">Core education will always be free. No one gets left behind.</p>
            </div>
          </div>
          
          <div class="flex justify-center space-x-8 mb-8">
            <a href="#" class="text-gray-400 hover:text-blue-400 transition-colors duration-300 hover-lift">
              Privacy
            </a>
            <a href="#" class="text-gray-400 hover:text-blue-400 transition-colors duration-300 hover-lift">
              Terms
            </a>
            <a href="https://t.me/cameronreaney" target="_blank" class="text-gray-400 hover:text-blue-400 transition-colors duration-300 hover-lift">
              Contact Cameron
            </a>
          </div>
          
          <p class="text-gray-500 text-sm">
            © 2025 ReaneyAI. Built for the people, by the people.
          </p>
        </div>
      </div>
    </div>
  </footer>

</body>
</html>
</body>
</html>