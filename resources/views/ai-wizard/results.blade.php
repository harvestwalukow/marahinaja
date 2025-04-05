@extends('layouts.app')

@section('title', 'AI Recommendations - Marahin Aja')

@section('content')
<div class="min-h-screen py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-5xl mx-auto">

        <h2 class="text-2xl font-bold mb-6">Rekomendasi AI</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
            @foreach($results as $result)
            <div class="glass rounded-xl overflow-hidden transform transition-all duration-300 hover:scale-105 hover:shadow-xl">
                <div class="h-40 overflow-hidden relative">
                    <!-- Placeholder image with gradient overlay -->
                    <div class="absolute inset-0 bg-gradient-to-r from-ye-accent to-ye-marah opacity-50"></div>
                    <!-- Overlay text as placeholder for the image -->
                    <div class="absolute inset-0 flex items-center justify-center">
                        <p class="text-white text-center px-4">{{ $result['title'] }}</p>
                    </div>
                </div>
                <div class="p-5">
                    <h3 class="text-xl font-bold mb-2">{{ $result['title'] }}</h3>
                    <p>{{ $result['description'] }}</p>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Action buttons -->
        <div class="text-center mb-12">
            <a href="{{ route('ai-wizard') }}" class="ye-btn-outline px-6 py-3 rounded-lg mr-4">Coba Lagi</a>
            <a href="{{ route('home') }}" class="ye-btn-primary px-6 py-3 rounded-lg">Kembali ke Beranda</a>
        </div>

        <!-- Important note section with improved visibility in light mode -->
        <div class="bg-gray-100 dark:bg-gray-800 rounded-xl p-6 text-center border border-gray-200 dark:border-gray-700 shadow-sm">
            <h3 class="text-xl font-semibold mb-2 text-gray-800 dark:text-gray-200">Catatan Penting</h3>
            <p class="text-gray-700 dark:text-gray-300">Rekomendasi yang diberikan bersifat umum dan dihasilkan oleh AI. Untuk masalah serius terkait kesehatan mental, silakan konsultasikan dengan profesional.</p>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Gradient text */
    .gradient-text {
        background: linear-gradient(to right, #ff4b4b, #ff8080);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    /* Animation for cards */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .grid > div {
        animation: fadeIn 0.5s ease-out forwards;
        opacity: 0;
    }
    
    .grid > div:nth-child(1) {
        animation-delay: 0.1s;
    }
    
    .grid > div:nth-child(2) {
        animation-delay: 0.3s;
    }
    
    .grid > div:nth-child(3) {
        animation-delay: 0.5s;
    }
</style>
@endpush 