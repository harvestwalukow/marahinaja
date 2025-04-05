@extends('layouts.app')

@section('title', 'AI Wizard - Redirecting')

@section('content')
<div class="min-h-screen flex items-center justify-center">
    <!-- Simple redirect -->
    <div class="text-center px-4 py-8">
        <h1 class="text-5xl md:text-7xl font-bold mb-6 gradient-text">AI Wizard</h1>
        <p class="text-xl md:text-2xl opacity-80 mb-6">Redirecting to new AI Wizard...</p>
        <div class="loading-spinner mb-6"></div>
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
    
    /* Loading spinner */
    .loading-spinner {
        width: 40px;
        height: 40px;
        margin: 0 auto;
        border: 4px solid rgba(255, 75, 75, 0.2);
        border-left-color: var(--accent-color);
        border-radius: 50%;
        animation: spinner 1s linear infinite;
    }
    
    @keyframes spinner {
        to { transform: rotate(360deg); }
    }
</style>
@endpush

@push('scripts')
<script>
    // Redirect after a short delay
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            window.location.href = "{{ route('ai.wizard') }}";
        }, 1500);
    });
</script>
@endpush 