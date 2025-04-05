<!DOCTYPE html>
<html lang="id" class="h-full" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Marahin Aja')</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;900&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        ye: {
                            bg: '#0a0a0a',
                            text: '#f5f5f5',
                            accent: '#ff0000',
                            marah: '#cc3300',
                            dimarahin: '#006666',
                            muted: '#3a3a3a',
                            light: '#f5f5f5',
                            dark: '#1d1d1f',
                            lightBg: '#f5f5f5',
                            lightText: '#0a0a0a',
                            lightMuted: '#9ca3af'
                        }
                    },
                    fontFamily: {
                        'ye': ['Montserrat', 'sans-serif']
                    },
                    boxShadow: {
                        'apple': '0 4px 30px rgba(0, 0, 0, 0.1)'
                    }
                }
            }
        }
    </script>
    <style type="text/tailwindcss">
        @layer utilities {
            .ye-container {
                @apply max-w-5xl mx-auto px-4;
            }
            .ye-title {
                @apply text-4xl md:text-6xl uppercase font-black tracking-tighter;
            }
            .ye-subtitle {
                @apply text-lg uppercase font-bold tracking-wide;
            }
            .ye-btn {
                @apply uppercase font-bold px-8 py-3 tracking-wider transition-all duration-300 inline-block text-center;
            }
            .ye-btn-primary {
                @apply ye-btn bg-ye-accent text-white hover:opacity-90 hover:scale-[1.02] shadow-apple;
            }
            .ye-btn-outline {
                @apply ye-btn border-2 border-white hover:bg-white hover:text-ye-bg hover:scale-[1.02] shadow-apple;
            }
            .ye-card {
                @apply border-0 backdrop-blur-md rounded-xl hover:shadow-lg transition-all duration-300;
            }
            .ye-input {
                @apply border rounded-lg px-4 py-3 w-full focus:ring-1 focus:ring-ye-accent focus:border-ye-accent focus:outline-none transition-all;
            }
            .chat-window {
                height: 60vh;
                @apply backdrop-blur-sm rounded-xl shadow-apple overflow-hidden;
            }
            .message-sender {
                @apply bg-ye-accent text-white text-right ml-[20%] mb-4 p-3 rounded-2xl rounded-tr-sm shadow-sm;
            }
            .notification {
                @apply fixed z-50 px-4 py-3 rounded-lg shadow-apple backdrop-blur-md transition-all duration-300 transform;
            }
        }
        
        /* Theme properties */
        html[data-theme='dark'] {
            --bg-primary: theme('colors.ye.bg');
            --text-primary: theme('colors.ye.text');
            --text-muted: theme('colors.ye.muted');
            --bg-card: rgba(29, 29, 31, 0.9);
            --bg-glass: rgba(29, 29, 31, 0.7);
            --border-color: rgba(255, 255, 255, 0.1);
            --message-receiver-bg: rgba(50, 50, 50, 0.95);
            --message-receiver-color: rgba(255, 255, 255, 1);
            --input-bg: rgba(29, 29, 31, 0.8);
            --input-border: rgba(58, 58, 58, 0.5);
            --input-text: white;
            --notification-bg: rgba(29, 29, 31, 0.8);
            --notification-border: theme('colors.ye.accent');
            --notification-error-border: theme('colors.ye.marah');
        }
        
        html[data-theme='light'] {
            --bg-primary: theme('colors.ye.lightBg');
            --text-primary: theme('colors.ye.lightText');
            --text-muted: theme('colors.ye.lightMuted');
            --bg-card: rgba(255, 255, 255, 0.9);
            --bg-glass: rgba(255, 255, 255, 0.7);
            --border-color: rgba(0, 0, 0, 0.1);
            --message-receiver-bg: rgba(229, 231, 235, 0.95);
            --message-receiver-color: rgba(0, 0, 0, 0.9);
            --input-bg: rgba(255, 255, 255, 0.8);
            --input-border: rgba(209, 213, 219, 0.5);
            --input-text: black;
            --notification-bg: rgba(255, 255, 255, 0.9);
            --notification-border: theme('colors.ye.accent');
            --notification-error-border: theme('colors.ye.marah');
        }
        
        /* Apply theme variables */
        html, body {
            background-color: var(--bg-primary);
            color: var(--text-primary);
            @apply font-ye h-full transition-colors duration-300;
        }
        
        .ye-card {
            background-color: var(--bg-card);
        }
        
        .ye-input {
            background-color: var(--input-bg);
            border-color: var(--input-border);
            color: var(--input-text);
        }
        
        .message-receiver {
            @apply mr-[20%] mb-4 p-3 rounded-2xl rounded-tl-sm shadow-sm;
            background-color: var(--message-receiver-bg);
            color: var(--message-receiver-color);
            border: 1px solid var(--border-color);
        }
        
        /* Navbar & Footer Styles */
        .nav-blur {
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            background-color: var(--bg-glass);
            border-bottom: 1px solid var(--border-color);
        }
        
        .footer-blur {
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            background-color: var(--bg-glass);
            border-top: 1px solid var(--border-color);
        }
        
        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .animate-fadeIn {
            animation: fadeIn 0.5s ease-out;
        }
        
        .hover-scale {
            transition: all 0.3s ease;
        }
        
        .hover-scale:hover {
            transform: scale(1.02);
        }
        
        /* Apple-like glass morphism */
        .glass {
            background-color: var(--bg-glass);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid var(--border-color);
        }
        
        /* Mode toggle switch */
        .mode-toggle {
            @apply relative inline-block w-12 h-6;
        }
        
        .mode-toggle input {
            @apply opacity-0 w-0 h-0;
        }
        
        .mode-slider {
            @apply absolute cursor-pointer top-0 left-0 right-0 bottom-0 bg-ye-muted rounded-full transition-all duration-300;
        }
        
        .mode-slider:before {
            content: "";
            @apply absolute h-5 w-5 left-0.5 bottom-0.5 bg-white rounded-full transition-all duration-300;
        }
        
        input:checked + .mode-slider {
            @apply bg-ye-accent;
        }
        
        input:checked + .mode-slider:before {
            transform: translateX(1.5rem);
        }
        
        /* Mode toggle switch - small version */
        .mode-toggle-sm {
            @apply relative inline-block w-8 h-4;
        }
        
        .mode-toggle-sm input {
            @apply opacity-0 w-0 h-0;
        }
        
        .mode-slider-sm {
            @apply absolute cursor-pointer top-0 left-0 right-0 bottom-0 bg-ye-muted rounded-full transition-all duration-300;
        }
        
        .mode-slider-sm:before {
            content: "";
            @apply absolute h-3 w-3 left-0.5 bottom-0.5 bg-white rounded-full transition-all duration-300;
        }
        
        input:checked + .mode-slider-sm {
            @apply bg-ye-accent;
        }
        
        input:checked + .mode-slider-sm:before {
            transform: translateX(1rem);
        }
    </style>
    
    <style>
    /* Dropdown menu styles */
    .dropdown-container {
        position: relative;
        display: inline-block;
    }
    
    .dropdown-container:hover .dropdown-menu {
        display: block;
    }
    
    .dropdown-menu {
        position: absolute;
        top: 100%;
        left: 0;
        padding-top: 0.5rem;
        z-index: 50;
        min-width: max-content;
    }
    
    .dropdown-content {
        border-radius: 0.5rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        border: 1px solid var(--border-color);
        overflow: hidden;
        background-color: var(--bg-glass);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
    }
    
    .menu-item {
        display: flex;
        align-items: center;
        padding: 0.75rem 1rem;
        transition: all 0.2s ease;
        white-space: nowrap;
    }
    
    .menu-item:hover {
        background-color: var(--border-color);
    }
    </style>
    
    @stack('styles')
</head>
<body class="h-full flex flex-col">
    <!-- Navbar -->
    <nav class="nav-blur fixed top-0 left-0 right-0 z-50">
        <div class="ye-container py-2">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-2">
                    <a href="{{ route('login') }}" class="flex items-center space-x-2 hover-scale">
                        <img src="{{ asset('images/logo.svg') }}" alt="Marahin Aja Logo" class="w-8 h-8">
                        <span class="font-bold tracking-tight text-xl" style="color: var(--text-primary)">MARAHIN AJA</span>
                    </a>
                    <!-- Dropdown Menu Container -->
                    <div class="dropdown-container">
                        <!-- Menu Button -->
                        <button id="menuButton" class="ml-2 p-1 rounded-md">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                        
                        <!-- Dropdown Menu -->
                        <div id="dropdownMenu" class="hidden dropdown-menu">
                            <div class="dropdown-content">
                                <ul>
                                    <li>
                                        <a href="{{ route('ai-wizard') }}" class="menu-item">
                                            <span class="text-sm font-medium">AI WIZARD</span>
                                            <span class="ml-2 px-2 py-0.5 text-xs rounded-full bg-ye-accent text-white">BETA</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="flex items-center space-x-4">
                    @auth
                        <span class="text-sm font-medium px-3 py-1 rounded-full glass backdrop-blur-sm border border-white/10">
                            {{ Auth::user()->name }}
                        </span>
                        <a href="{{ route('logout') }}" class="text-sm hover:text-ye-accent transition-colors">
                            KELUAR
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-1 pt-20 pb-16 animate-fadeIn">
        @if(session('success'))
        <div class="notification border-l-4 top-20 right-4" style="border-color: var(--notification-border)">
            {{ session('success') }}
        </div>
        @endif
        
        @if(session('error'))
        <div class="notification border-l-4 top-20 right-4" style="border-color: var(--notification-error-border)">
            {{ session('error') }}
        </div>
        @endif
        
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer-blur">
        <div class="ye-container py-2">
            <div class="flex justify-between items-center">
                <div class="text-sm opacity-70">
                    © {{ date('Y') }} MARAHIN AJA
                </div>
                <div class="flex items-center space-x-2">
                    <span class="text-xs opacity-70">Dark</span>
                    <label class="mode-toggle-sm">
                        <input type="checkbox" id="themeToggle">
                        <span class="mode-slider-sm"></span>
                    </label>
                    <span class="text-xs opacity-70">Light</span>
                </div>
            </div>
        </div>
    </footer>
    
    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <script>
        // Theme Toggle
        document.addEventListener('DOMContentLoaded', function() {
            const themeToggle = document.getElementById('themeToggle');
            
            // Check for saved theme preference
            const savedTheme = localStorage.getItem('theme');
            
            // Set initial theme based on saved preference or default to dark
            if (savedTheme) {
                document.documentElement.setAttribute('data-theme', savedTheme);
                themeToggle.checked = savedTheme === 'light';
            } else {
                document.documentElement.setAttribute('data-theme', 'dark');
                themeToggle.checked = false;
            }
            
            // Toggle theme on checkbox change
            themeToggle.addEventListener('change', function() {
                const newTheme = this.checked ? 'light' : 'dark';
                document.documentElement.setAttribute('data-theme', newTheme);
                localStorage.setItem('theme', newTheme);
            });
        });
    </script>
    
    @stack('scripts')
</body>
</html> 