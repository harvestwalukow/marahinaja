@extends('layouts.app')

@section('title', 'AI Wizard - Coming Soon')

@section('content')
<div class="min-h-screen flex items-center justify-center">
    <!-- Simple Content -->
    <div class="text-center px-4 py-8">
        <h1 class="text-5xl md:text-7xl font-bold mb-6 gradient-text">AI Wizard</h1>
        <p class="text-xl md:text-2xl opacity-80">new feature coming soon</p>
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
</style>
@endpush 