@extends('layouts.main')

@section('title', 'Welcome to Marahin Aja')

@section('content')
<!-- Hero Section - Fullscreen -->
<div class="h-screen flex flex-col items-center justify-center px-4 relative">
    <div class="mb-12 flex justify-center">
        <img src="{{ asset('images/logo.svg') }}" alt="Marahin Aja Logo" class="w-32 h-32 animate-float">
    </div>
    <h1 class="ye-title bg-clip-text text-transparent bg-gradient-to-r from-ye-accent to-ye-marah mb-12 animate-fadeIn px-4">MARAHIN AJA</h1>
    
    <!-- Main CTA Button -->
    <a href="{{ route('login') }}" class="ye-btn-primary rounded-xl px-10 py-5 text-xl font-bold transform transition hover:scale-105">
        MULAI
    </a>
    
    <!-- Scroll Indicator -->
    <div class="absolute bottom-10 left-10 flex items-center cursor-pointer opacity-100 transition-opacity duration-300" id="scrollDown">
        <p class="mr-2 text-sm opacity-70">Scroll untuk eksplor</p>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
        </svg>
    </div>
</div>

<!-- Content Sections with Scroll Reveal -->
<div class="px-4 md:px-8 lg:px-16 py-16">
    <!-- Two Main Feature Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-20 reveal-section">
        <!-- Card 1: No Censorship -->
        <div class="glass rounded-2xl p-8 md:p-10 transform transition-all duration-500 hover:shadow-xl relative overflow-hidden group">
            <div class="absolute -right-20 -top-20 w-40 h-40 bg-ye-accent opacity-10 rounded-full transition-all duration-500 group-hover:scale-150 group-hover:opacity-20"></div>
            <h2 class="text-2xl md:text-3xl font-bold mb-4 relative z-10">Tanpa sensor, tanpa rem</h2>
            <p class="text-lg opacity-80 relative z-10">
                Bebas ungkapin apapun yang dirasain.
            </p>
            <div class="absolute left-0 bottom-0 h-1 bg-gradient-to-r from-ye-accent to-ye-marah w-0 group-hover:w-full transition-all duration-500"></div>
        </div>
        
        <!-- Card 2: Privacy -->
        <div class="glass rounded-2xl p-8 md:p-10 transform transition-all duration-500 hover:shadow-xl relative overflow-hidden group">
            <div class="absolute -left-20 -top-20 w-40 h-40 bg-ye-accent opacity-10 rounded-full transition-all duration-500 group-hover:scale-150 group-hover:opacity-20"></div>
            <h2 class="text-2xl md:text-3xl font-bold mb-4 relative z-10">Privasi aman</h2>
            <p class="text-lg opacity-80 relative z-10">
                Percakapan hanya bisa dilihat oleh pengirim dan penerima chat.
            </p>
            <div class="absolute left-0 bottom-0 h-1 bg-gradient-to-r from-ye-accent to-ye-marah w-0 group-hover:w-full transition-all duration-500"></div>
        </div>
    </div>
    
    <!-- AI Wizard Card -->
    <div class="glass rounded-2xl p-8 md:p-12 text-center mb-20 relative overflow-hidden reveal-section">
        <div class="absolute -top-20 -right-20 w-60 h-60 rounded-full bg-ye-accent opacity-10 blur-2xl"></div>
        <div class="absolute -bottom-20 -left-20 w-60 h-60 rounded-full bg-ye-marah opacity-10 blur-2xl"></div>
        
        <!-- <h2 class="text-2xl md:text-3xl font-bold mb-4 relative z-10">
            AI Wizard
            <span class="ml-2 px-2 py-0.5 text-xs rounded-full bg-ye-accent text-white">BETA</span>
        </h2> -->

        <h2 class="items-center text-2xl md:text-3xl font-bold mb-4 relative z-10">
            AI Wizard
            <span class="px-2 py-0.5 text-xs rounded-full bg-ye-accent text-white">BETA</span>
        </h2>
        <p class="text-lg max-w-2xl mx-auto opacity-80 relative z-10 mb-8">
            Dapatkan rekomendasi praktis dari AI untuk mengatasi kemarahan.
        </p>
        <a href="{{ route('ai-wizard') }}" class="ye-btn-outline rounded-xl inline-flex items-center group px-6 py-3">
            <span class="group-hover:text-current">Coba Sekarang</span>
            <!-- <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2 transform transition-transform group-hover:translate-x-1" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg> -->
        </a>
    </div>
    
    <!-- Footer dengan margin yang lebih besar agar lebih terlihat -->
    <footer class="mt-auto pt-8 pb-20 border-t border-gray-200 dark:border-gray-800 reveal-section">
        <div class="flex flex-col md:flex-row md:justify-between items-center">
            <div class="mb-4 md:mb-0">
                <img src="{{ asset('images/logo.svg') }}" alt="Marahin Aja Logo" class="w-8 h-8 inline-block mr-2">
                <span class="text-lg font-bold">Marahin Aja</span>
            </div>
            <div class="flex space-x-6">
                <a href="#" class="text-sm opacity-70 hover:opacity-100 transition">Tentang Kami</a>
                <a href="#" class="text-sm opacity-70 hover:opacity-100 transition">Ketentuan & Kebijakan</a>
            </div>
        </div>
        <div class="text-center text-sm opacity-60 mt-4">
            © {{ date('Y') }} Harvest Walukow. All rights reserved.
        </div>
    </footer>
</div>
@endsection

@push('styles')
<style>
    /* Landing page styles */
    .ye-title {
        font-size: 3.5rem;
        line-height: 1;
        font-weight: 800;
    }
    
    @media (min-width: 768px) {
        .ye-title {
            font-size: 5rem;
        }
    }
    
    /* Enhanced animations */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .animate-fadeIn {
        animation: fadeIn 0.8s ease-out;
    }
    
    @keyframes float {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-15px); }
        100% { transform: translateY(0px); }
    }
    
    .animate-float {
        animation: float 6s ease-in-out infinite;
    }
    
    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }
    
    .animate-pulse {
        animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }
    
    /* Scroll reveal animation */
    .reveal-section {
        opacity: 0;
        transform: translateY(50px);
        transition: all 0.8s ease;
    }
    
    .reveal-active {
        opacity: 1;
        transform: translateY(0);
    }
</style>
@endpush

@push('scripts')
<script>
    // Scroll reveal functionality
    document.addEventListener('DOMContentLoaded', function() {
        const revealSections = document.querySelectorAll('.reveal-section');
        const scrollIndicator = document.getElementById('scrollDown');
        let isScrollIndicatorVisible = true;
        
        function checkReveal() {
            const windowHeight = window.innerHeight;
            const revealPoint = 150;
            
            // Hide scroll indicator when scrolled
            if (window.scrollY > 100 && isScrollIndicatorVisible) {
                scrollIndicator.style.opacity = '0';
                scrollIndicator.style.pointerEvents = 'none';
                isScrollIndicatorVisible = false;
            } else if (window.scrollY <= 100 && !isScrollIndicatorVisible) {
                scrollIndicator.style.opacity = '1';
                scrollIndicator.style.pointerEvents = 'auto';
                isScrollIndicatorVisible = true;
            }
            
            revealSections.forEach(section => {
                const sectionTop = section.getBoundingClientRect().top;
                
                if(sectionTop < windowHeight - revealPoint) {
                    section.classList.add('reveal-active');
                }
            });
        }
        
        // Initial check
        checkReveal();
        
        // Add scroll event listener
        window.addEventListener('scroll', checkReveal);
        
        // Scroll down button functionality
        scrollIndicator.addEventListener('click', function() {
            window.scrollTo({
                top: window.innerHeight,
                behavior: 'smooth'
            });
        });
    });
</script>
@endpush
