@extends('layouts.app')

@section('title', 'AI Recommendations - Marahin Aja')

@section('content')
<div class="min-h-screen py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-5xl mx-auto">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold mb-2 gradient-text">Rekomendasi AI</h1>
            <p class="text-lg opacity-80">Berdasarkan informasi yang Anda berikan</p>
        </div>

        <div class="mb-8 glass rounded-xl p-6">
            <h2 class="text-xl font-semibold mb-4">Ringkasan Informasi Anda</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <p><span class="font-medium">Jenis kelamin:</span> {{ $userInput['gender'] == 'male' ? 'Laki-laki' : 'Perempuan' }}</p>
                    <p><span class="font-medium">Status pekerjaan:</span> {{ $userInput['job_status'] }}</p>
                    <p><span class="font-medium">Usia:</span> {{ $userInput['age'] }} tahun</p>
                </div>
                <div>
                    <p><span class="font-medium">Tingkat kemarahan:</span> {{ $userInput['anger_level'] }}/10</p>
                    <p><span class="font-medium">Penyebab kemarahan:</span> "{{ $userInput['anger_reason'] }}"</p>
                </div>
            </div>
        </div>

        <h2 class="text-2xl font-bold mb-6">Rekomendasi Untuk Anda</h2>
        
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

        <div class="text-center mb-12">
            <a href="{{ route('ai.wizard') }}" class="ye-btn-outline px-6 py-3 rounded-lg mr-4">Coba Lagi</a>
            <a href="{{ route('home') }}" class="ye-btn-primary px-6 py-3 rounded-lg">Kembali ke Beranda</a>
        </div>

        <div class="bg-gray-100 dark:bg-gray-800 rounded-xl p-6 text-center opacity-80">
            <h3 class="text-xl font-semibold mb-2">Catatan Penting</h3>
            <p>Rekomendasi yang diberikan bersifat umum dan dihasilkan oleh AI. Untuk masalah serius terkait kesehatan mental, silakan konsultasikan dengan profesional.</p>
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