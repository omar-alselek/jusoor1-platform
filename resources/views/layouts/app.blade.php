<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Jusoor') }} - @yield('title', 'Home')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        teal: {
                            50: '#f0fdfa',
                            100: '#ccfbf1',
                            200: '#99f6e4',
                            300: '#5eead4',
                            400: '#2dd4bf',
                            500: '#14b8a6',
                            600: '#0d9488',
                            700: '#0f766e',
                            800: '#115e59',
                            900: '#134e4a',
                            950: '#042f2e',
                        }
                    },
                    fontFamily: {
                        sans: ['Instrument Sans', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    
    <!-- Custom Styles -->
    <style>
        /* Add any custom styles here */
    </style>
    
    <!-- Alpine.js for interactive components -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-900">
    <div class="min-h-screen flex flex-col">
        <!-- Header -->
        @include('includes.header')

        <!-- Main Content -->
        <main class="flex-grow">
            @yield('content')
        </main>

        <!-- Footer -->
        @include('includes.footer')
    </div>

    <!-- Custom JavaScript -->
    <script>
        // Mobile menu toggle
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuButton = document.querySelector('[aria-controls="mobile-menu"]');
            const mobileMenu = document.getElementById('mobile-menu');
            
            if (mobileMenuButton && mobileMenu) {
                mobileMenuButton.addEventListener('click', function() {
                    const expanded = this.getAttribute('aria-expanded') === 'true' || false;
                    this.setAttribute('aria-expanded', !expanded);
                    mobileMenu.classList.toggle('hidden');
                });
            }
            
            // User menu dropdown
            const userMenuButton = document.getElementById('user-menu-button');
            const userMenu = userMenuButton?.nextElementSibling;
            
            if (userMenuButton && userMenu) {
                userMenuButton.addEventListener('click', function() {
                    const expanded = this.getAttribute('aria-expanded') === 'true' || false;
                    this.setAttribute('aria-expanded', !expanded);
                    userMenu.classList.toggle('hidden');
                });
                
                // Close when clicking outside
                document.addEventListener('click', function(event) {
                    if (userMenuButton && !userMenuButton.contains(event.target) && !userMenu.contains(event.target)) {
                        userMenuButton.setAttribute('aria-expanded', 'false');
                        userMenu.classList.add('hidden');
                    }
                });
            }
        });
    </script>
    
    @yield('scripts')
</body>
</html> 