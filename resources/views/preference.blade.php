@extends('layouts.app')

@section('title', 'Pilih Preferensi - Marahin Aja')

@section('content')
<div class="ye-container">
    <div class="text-center mb-12">
        <h1 class="ye-title mb-4" style="color: var(--text-primary)">MAU NGAPAIN?</h1>
        <p class="text-sm px-4 py-1.5 rounded-full glass inline-block">
            <span id="online-count" class="text-ye-accent font-semibold">0</span> <span style="color: var(--text-primary); opacity: 0.8;">ORANG ONLINE</span>
        </p>
    </div>

    <div class="grid md:grid-cols-2 gap-8" id="preference-options">
        <!-- Marah-marah Option -->
        <div class="ye-card p-8 md:p-10 text-center preference-card transition-all duration-300" data-card="marah">
            <div class="rounded-full w-16 h-16 flex items-center justify-center bg-ye-accent/20 backdrop-blur-sm border border-ye-accent/30 mx-auto mb-6">
                <span class="text-2xl">😡</span>
            </div>
            <h2 class="text-2xl font-bold mb-4">MARAH-MARAH</h2>
            <p class="text-ye-muted mb-8">Ga pernah semarah ini!</p>
            <form action="{{ route('preference.save') }}" method="POST" id="marah-form">
                @csrf
                <input type="hidden" name="preference" value="marah">
                <button type="submit" class="ye-btn-primary w-full">
                    PILIH
                </button>
            </form>
        </div>

        <!-- Dimarahin Option -->
        <div class="ye-card p-8 md:p-10 text-center preference-card transition-all duration-300" data-card="dimarahin">
            <div class="rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-6 skull-circle">
                <span class="text-2xl">💀</span>
            </div>
            <h2 class="text-2xl font-bold mb-4">DIMARAHIN</h2>
            <p class="text-ye-muted mb-8">Bukan salah gue, tapi ya udah terima aja.</p>
            <form action="{{ route('preference.save') }}" method="POST" id="dimarahin-form">
                @csrf
                <input type="hidden" name="preference" value="dimarahin">
                <button type="submit" class="dimarahin-btn w-full">
                    PILIH
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Loading Modal -->
<div id="loading-modal" class="fixed inset-0 bg-black/60 backdrop-blur-sm hidden items-center justify-center z-50">
    <div class="glass p-8 rounded-xl shadow-apple text-center max-w-md">
        <div class="flex justify-center mb-6">
            <div class="relative w-20 h-20">
                <div class="absolute inset-0 rounded-full border-t-2 border-ye-accent animate-spin"></div>
                <div class="absolute inset-0 rounded-full border-r-2 border-transparent animate-pulse"></div>
            </div>
        </div>
        <h3 class="text-xl font-bold text-white mb-2">MENCARI PARTNER...</h3>
        <p class="text-ye-muted mb-6">Tunggu sebentar ya, sedang mencari partner yang cocok</p>
        <div class="text-3xl font-bold text-ye-accent mb-2" id="countdown">30</div>
        <p class="text-sm text-ye-muted">detik tersisa</p>
    </div>
</div>

@push('styles')
<style>
    /* Card styles for better hover effects */
    .preference-card {
        transition: all 0.3s ease;
        will-change: transform, box-shadow;
        backface-visibility: hidden;
        -webkit-font-smoothing: subpixel-antialiased;
    }
    
    .preference-card h2,
    .preference-card p, 
    .preference-card span, 
    .preference-card div, 
    .preference-card button {
        transition: all 0.3s ease;
    }
    
    .preference-card.active {
        transform: scale(1.02);
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
        z-index: 10;
    }
    
    .preference-card.inactive {
        opacity: 0.5;
        filter: blur(2px);
    }
    
    .preference-card.active h2,
    .preference-card.active p, 
    .preference-card.active span, 
    .preference-card.active div {
        filter: none !important;
        opacity: 1 !important;
    }
    
    /* Dark/Light specific styles for emoji circles */
    html[data-theme='dark'] .skull-circle {
        background-color: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(5px);
        border: 1px solid rgba(255, 255, 255, 0.3);
    }
    
    html[data-theme='light'] .skull-circle {
        background-color: rgba(0, 0, 0, 0.1);
        backdrop-filter: blur(5px);
        border: 1px solid rgba(0, 0, 0, 0.3);
    }
    
    /* Dark/Light specific styles for dimarahin button */
    .dimarahin-btn {
        @apply ye-btn w-full rounded-md text-center uppercase font-bold tracking-wider shadow-apple transition-all duration-300;
        line-height: 1;
        padding: 0.75rem 2rem;
    }
    
    html[data-theme='dark'] .dimarahin-btn {
        background-color: transparent;
        color: white;
        border: 2px solid white;
    }
    
    html[data-theme='dark'] .dimarahin-btn:hover {
        background-color: white;
        color: #1a1a1a;
        opacity: 0.9;
        transform: scale(1.02);
    }
    
    html[data-theme='light'] .dimarahin-btn {
        background-color: transparent;
        color: black;
        border: 2px solid black;
    }
    
    html[data-theme='light'] .dimarahin-btn:hover {
        background-color: black;
        color: white;
        opacity: 0.9;
        transform: scale(1.02);
    }
</style>
@endpush

@push('scripts')
<script>
    // Update online count every 5 seconds
    function updateOnlineCount() {
        fetch('/api/online-count', {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'Cache-Control': 'no-cache'
            },
            credentials: 'same-origin'
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            console.log('Online count response:', data);
            if (data.success) {
                document.getElementById('online-count').textContent = data.count;
            } else {
                console.error('Error in response:', data.error);
            }
        })
        .catch(error => {
            console.error('Error fetching online count:', error);
        });
    }

    // Initial update
    updateOnlineCount();
    
    // Update every 5 seconds
    setInterval(updateOnlineCount, 5000);

    // Card hover effects
    const cards = document.querySelectorAll('.preference-card');
    
    cards.forEach(card => {
        card.addEventListener('mouseenter', () => {
            cards.forEach(otherCard => {
                if (otherCard !== card) {
                    otherCard.classList.add('inactive');
                } else {
                    otherCard.classList.add('active');
                }
            });
        });
        
        card.addEventListener('mouseleave', () => {
            cards.forEach(otherCard => {
                otherCard.classList.remove('inactive');
                otherCard.classList.remove('active');
            });
        });
    });

    // Handle form submission
    document.getElementById('marah-form').addEventListener('submit', handleSubmit);
    document.getElementById('dimarahin-form').addEventListener('submit', handleSubmit);

    function handleSubmit(e) {
        e.preventDefault();
        
        // Show loading modal
        const modal = document.getElementById('loading-modal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');

        // Start countdown
        let timeLeft = 30;
        const countdownElement = document.getElementById('countdown');
        
        // Submit form
        const formData = new FormData(e.target);
        fetch(e.target.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Start polling for match
                const pollInterval = setInterval(() => {
                    fetch('/api/matching/check', {
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                            'Cache-Control': 'no-cache'
                        },
                        credentials: 'same-origin'
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success && data.matched) {
                            clearInterval(pollInterval);
                            window.location.href = `/chat/${data.room_id}`;
                        }
                    })
                    .catch(error => {
                        console.error('Error checking match:', error);
                    });
                }, 1000);

                // Update countdown
                const countdown = setInterval(() => {
                    timeLeft--;
                    countdownElement.textContent = timeLeft;
                    
                    if (timeLeft <= 0) {
                        clearInterval(countdown);
                        clearInterval(pollInterval);
                        modal.classList.add('hidden');
                        modal.classList.remove('flex');
                        
                        // Show error message
                        alert('Maaf, tidak ada partner yang tersedia saat ini. Silakan coba lagi nanti.');
                    }
                }, 1000);
            }
        })
        .catch(error => {
            console.error('Error saving preference:', error);
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            alert('Terjadi kesalahan. Silakan coba lagi.');
        });
    }
</script>
@endpush
@endsection 