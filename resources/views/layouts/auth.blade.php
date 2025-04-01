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
            .notification {
                @apply fixed z-50 px-4 py-3 rounded-lg shadow-apple backdrop-blur-md transition-all duration-300 transform;
                background-color: var(--notification-bg);
                color: var(--text-primary);
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
            --input-bg: rgba(29, 29, 31, 0.8);
            --input-border: rgba(58, 58, 58, 0.5);
            --input-text: white;
            --bg-gradient: radial-gradient(circle at top right, rgba(255, 0, 0, 0.1), transparent 400px);
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
            --input-bg: rgba(255, 255, 255, 0.8);
            --input-border: rgba(209, 213, 219, 0.5);
            --input-text: black;
            --bg-gradient: radial-gradient(circle at top right, rgba(255, 0, 0, 0.05), transparent 400px);
            --notification-bg: rgba(255, 255, 255, 0.9);
            --notification-border: theme('colors.ye.accent');
            --notification-error-border: theme('colors.ye.marah');
        }
        
        /* Apply theme variables */
        html, body {
            background-color: var(--bg-primary);
            color: var(--text-primary);
            background-image: var(--bg-gradient);
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
        
        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }
        
        .animate-fadeIn {
            animation: fadeIn 0.5s ease-out;
        }
        
        .animate-float {
            animation: float 6s ease-in-out infinite;
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
        
        /* Apply theme variables to text in headers */
        a, button, input, span, div, p, h1, h2, h3, h4, h5, h6 {
            color: var(--text-primary);
        }
    </style>
    
    @stack('styles')
</head>
<body class="h-full">
    <div class="h-full flex items-center justify-center animate-fadeIn">
        @if(session('success'))
        <div class="notification border-l-4 top-4 right-4" style="border-color: var(--notification-border)">
            {{ session('success') }}
        </div>
        @endif
        
        @if(session('error'))
        <div class="notification border-l-4 top-4 right-4" style="border-color: var(--notification-error-border)">
            {{ session('error') }}
        </div>
        @endif
        
        @yield('content')
        
        <div class="fixed bottom-4 inset-x-0 flex justify-center">
            <div class="flex items-center space-x-2 glass px-3 py-1.5 rounded-full">
                <span class="text-xs opacity-70">Dark</span>
                <label class="mode-toggle-sm">
                    <input type="checkbox" id="themeToggle">
                    <span class="mode-slider-sm"></span>
                </label>
                <span class="text-xs opacity-70">Light</span>
            </div>
        </div>
    </div>
    
    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <script>
        // Theme toggle functionality
        document.addEventListener('DOMContentLoaded', function() {
            const themeToggle = document.getElementById('themeToggle');
            const htmlElement = document.documentElement;
            
            // Check saved theme preference or default to dark
            const savedTheme = localStorage.getItem('theme') || 'dark';
            htmlElement.setAttribute('data-theme', savedTheme);
            themeToggle.checked = savedTheme === 'light';
            
            // Toggle theme when switch is clicked
            themeToggle.addEventListener('change', function() {
                if (this.checked) {
                    htmlElement.setAttribute('data-theme', 'light');
                    localStorage.setItem('theme', 'light');
                } else {
                    htmlElement.setAttribute('data-theme', 'dark');
                    localStorage.setItem('theme', 'dark');
                }
            });
        });
    </script>
    
    @stack('scripts')
</body>
</html> 