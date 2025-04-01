@extends('layouts.auth')

@section('title', 'Login - Marahin Aja')

@section('content')
<div class="w-full max-w-md p-4">
    <div class="text-center mb-14">
        <h1 class="ye-title mb-6" style="color: var(--text-primary)">MARAHIN AJA</h1>
        <div class="w-16 h-1 bg-ye-accent mx-auto mt-4"></div>
    </div>
    
    <form action="{{ route('login.post') }}" method="POST" class="ye-card p-8 md:p-10">
        @csrf
        
        <div class="mb-8">
            <input type="text" class="ye-input" id="name" name="name" placeholder="NAMA ANDA" required autofocus>
            <div class="h-0.5 w-0 bg-ye-accent transition-all duration-300 group-focus-within:w-full"></div>
        </div>
        
        <button type="submit" class="ye-btn-primary w-full">
            MASUK
        </button>
    </form>
</div>
@endsection 