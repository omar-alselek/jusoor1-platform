@if(request()->routeIs('home'))
<header class="bg-white shadow-sm border-b border-gray-200">
    <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center">
                        <img class="h-8 w-auto mr-2" src="{{ asset('images/logo.png') }}" alt="Jusoor">
                        <span class="text-2xl font-bold text-teal-600 hover:text-teal-700 transition">
                            {{ config('app.name', 'Jusoor') }}
                        </span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:ml-10 sm:flex">
                    <a href="{{ route('home') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('home') ? 'border-teal-500 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} text-sm font-medium transition duration-150 ease-in-out">
                        Home
                    </a>
                    <a href="{{ route('projects.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('projects.*') ? 'border-teal-500 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} text-sm font-medium transition duration-150 ease-in-out">
                        Projects
                    </a>
                    <a href="{{ route('about') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('about') ? 'border-teal-500 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} text-sm font-medium transition duration-150 ease-in-out">
                        About
                    </a>
                    <a href="{{ route('contact') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('contact') ? 'border-teal-500 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} text-sm font-medium transition duration-150 ease-in-out">
                        Contact
                    </a>
                </div>
            </div>

            <!-- Auth Links -->
            <div class="hidden sm:ml-6 sm:flex sm:items-center">
                @auth
                    <!-- Chat Notification Icon -->
                    <div class="ml-3 relative">
                        <a href="{{ route('chat.index') }}" class="p-1 rounded-full text-gray-500 hover:text-teal-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 relative">
                            <span class="sr-only">View messages</span>
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                            </svg>
                            <span id="notification-badge" class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-red-500 rounded-full {{ auth()->user()->unreadMessages()->count() > 0 ? '' : 'hidden' }}">
                                <span id="unread-count">{{ auth()->user()->unreadMessages()->count() }}</span>
                            </span>
                        </a>
                    </div>

                    <!-- Hidden inputs for Pusher configuration -->
                    <input type="hidden" id="auth-user-id" value="{{ auth()->id() }}">
                    <input type="hidden" id="pusher-key" value="{{ config('broadcasting.connections.pusher.key') }}">
                    <input type="hidden" id="pusher-cluster" value="{{ config('broadcasting.connections.pusher.options.cluster') }}">

                    <!-- Profile dropdown -->
                    <div class="ml-3 relative">
                        <div>
                            <button type="button" class="bg-white flex text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                <span class="sr-only">Open user menu</span>
                                @if(auth()->user()->profile && auth()->user()->profile->avatar)
                                    <img class="h-8 w-8 rounded-full object-cover border border-gray-200" src="{{ asset('storage/' . auth()->user()->profile->avatar) }}" alt="{{ auth()->user()->name }}">
                                @else
                                    <div class="h-8 w-8 rounded-full bg-teal-600 flex items-center justify-center">
                                        <span class="text-white font-medium text-sm">{{ substr(auth()->user()->name, 0, 1) }}</span>
                                    </div>
                                @endif
                            </button>
                        </div>

                        <!-- Dropdown menu -->
                        <div class="hidden origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
                            <div class="px-4 py-2 border-b border-gray-100">
                                <p class="text-sm font-medium text-gray-700">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email }}</p>
                            </div>
                            @if(auth()->user()->hasRole('admin'))
                                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Dashboard</a>
                            @endif
                            <a href="{{ route('profile.show', auth()->id()) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Profile</a>
                            <a href="{{ route('social.feed') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Social Feed</a>
                            <form method="POST" action="{{ route('logout') }}" class="border-t border-gray-100 mt-1">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:text-red-700 hover:bg-gray-100" role="menuitem">Sign out</button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700 mr-4">Log in</a>
                    <a href="{{ route('register') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-teal-600 hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 transition">Register</a>
                @endauth
            </div>

            <!-- Mobile menu button -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button type="button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-teal-500" aria-controls="mobile-menu" aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <!-- Icon when menu is closed -->
                    <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <!-- Icon when menu is open -->
                    <svg class="hidden h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </nav>

    <!-- Mobile menu, show/hide based on menu state. -->
    <div class="sm:hidden hidden" id="mobile-menu">
        <div class="pt-2 pb-3 space-y-1">
            <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'bg-teal-50 border-teal-500 text-teal-700' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800' }} block pl-3 pr-4 py-2 border-l-4 text-base font-medium">Home</a>
            <a href="{{ route('projects.index') }}" class="{{ request()->routeIs('projects.*') ? 'bg-teal-50 border-teal-500 text-teal-700' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800' }} block pl-3 pr-4 py-2 border-l-4 text-base font-medium">Projects</a>
            <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'bg-teal-50 border-teal-500 text-teal-700' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800' }} block pl-3 pr-4 py-2 border-l-4 text-base font-medium">About</a>
            <a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'bg-teal-50 border-teal-500 text-teal-700' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800' }} block pl-3 pr-4 py-2 border-l-4 text-base font-medium">Contact</a>
        </div>
        <div class="pt-4 pb-3 border-t border-gray-200">
            @auth
                <div class="flex items-center px-4">
                    <div class="flex-shrink-0">
                        @if(auth()->user()->profile && auth()->user()->profile->avatar)
                            <img class="h-10 w-10 rounded-full object-cover border border-gray-200" src="{{ asset('storage/' . auth()->user()->profile->avatar) }}" alt="{{ auth()->user()->name }}">
                        @else
                            <div class="h-10 w-10 rounded-full bg-teal-600 flex items-center justify-center">
                                <span class="text-white font-medium text-sm">{{ substr(auth()->user()->name, 0, 1) }}</span>
                            </div>
                        @endif
                    </div>
                    <div class="ml-3">
                        <div class="text-base font-medium text-gray-800">{{ auth()->user()->name }}</div>
                        <div class="text-sm font-medium text-gray-500">{{ auth()->user()->email }}</div>
                    </div>
                </div>
                <div class="mt-3 space-y-1">
                    @if(auth()->user()->hasRole('admin'))
                        <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">Dashboard</a>
                    @endif
                    <a href="{{ route('profile.show', auth()->id()) }}" class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">Profile</a>
                    <a href="{{ route('social.feed') }}" class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">Social Feed</a>
                    <form method="POST" action="{{ route('logout') }}" class="border-t border-gray-100 mt-1">
                        @csrf
                        <button type="submit" class="block w-full text-left px-4 py-2 text-base font-medium text-red-600 hover:text-red-800 hover:bg-gray-100">Sign out</button>
                    </form>
                </div>
            @else
                <div class="mt-3 space-y-1">
                    <a href="{{ route('login') }}" class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">Log in</a>
                    <a href="{{ route('register') }}" class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">Register</a>
                </div>
            @endauth
        </div>
    </div>
</header>
@else
<header class="bg-white shadow-sm sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <div class="flex-shrink-0 flex items-center">
                <a href="{{ route('home') }}" class="flex items-center group">
                    <img class="h-8 w-auto mr-2" src="{{ asset('images/logo.png') }}" alt="Jusoor">
                    <span class="text-2xl font-bold text-teal-600 group-hover:text-teal-700 transition">Jusoor</span>
                </a>
            </div>

            <!-- Navigation Links (Desktop) -->
            <div class="hidden md:flex md:items-center md:space-x-6">
                <nav class="flex space-x-6">
                    <a href="{{ route('social.feed') }}" class="text-gray-700 hover:text-teal-600 px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('social.feed') ? 'border-b-2 border-teal-500 text-teal-700' : '' }} transition-colors duration-150">
                        Feed
                    </a>
                    <a href="{{ route('social.friends') }}" class="text-gray-700 hover:text-teal-600 px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('social.friends') ? 'border-b-2 border-teal-500 text-teal-700' : '' }} transition-colors duration-150">
                        Friends
                    </a>
                    <a href="{{ route('social.friends.suggestions') }}" class="text-gray-700 hover:text-teal-600 px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('social.friends.suggestions') ? 'border-b-2 border-teal-500 text-teal-700' : '' }} transition-colors duration-150">
                        Find Friends
                    </a>
                    <a href="{{ route('projects.index') }}" class="text-gray-700 hover:text-teal-600 px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('projects.*') ? 'border-b-2 border-teal-500 text-teal-700' : '' }} transition-colors duration-150">
                        Projects
                    </a>
                </nav>
            </div>

            <!-- Right Side Menu (Desktop) -->
            <div class="hidden md:flex md:items-center md:space-x-4">
                <!-- Messages Button -->
                <a href="{{ route('chat.index') }}" class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 hover:text-teal-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 transition-colors duration-150">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                    </svg>
                    @auth
                        <x-notification-badge />
                    @endauth
                </a>

                <!-- Create new post button -->
                <a href="{{ route('social.posts.create') }}" class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-teal-600 hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 transition-colors duration-150">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    New Post
                </a>

                <!-- User Profile Dropdown -->
                @auth
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" type="button" class="flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 transition-opacity duration-150">
                        <span class="sr-only">Open user menu</span>
                        @if(auth()->user()->profile && auth()->user()->profile->avatar)
                            <img class="h-9 w-9 rounded-full object-cover border border-gray-200" src="{{ asset('storage/'.auth()->user()->profile->avatar) }}" alt="{{ auth()->user()->name }}">
                        @else
                            <div class="h-9 w-9 rounded-full bg-teal-600 flex items-center justify-center">
                                <span class="text-white font-medium">{{ substr(auth()->user()->name, 0, 1) }}</span>
                            </div>
                        @endif
                    </button>

                    <!-- Dropdown menu -->
                    <div x-show="open" @click.away="open = false" class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50" style="display: none;">
                        <div class="py-1">
                            <div class="px-4 py-2 border-b border-gray-100">
                                <p class="text-sm font-medium text-gray-700">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email }}</p>
                            </div>

                            <a href="{{ route('profile.show', auth()->id()) }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                Profile
                            </a>

                            <form method="POST" action="{{ route('logout') }}" class="border-t border-gray-100 mt-1">
                                @csrf
                                <button type="submit" class="w-full flex items-center px-4 py-2 text-sm text-red-600 hover:bg-red-50 font-medium">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    Sign out
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endauth
            </div>

            <!-- Mobile menu button -->
            <div class="flex md:hidden">
                <button type="button" class="mobile-menu-toggle inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-teal-500" aria-controls="mobile-menu" aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu -->
    <div class="md:hidden hidden" id="mobile-menu">
        <div class="px-2 pt-2 pb-3 space-y-1 border-b border-gray-200">
            <a href="{{ route('social.feed') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-teal-600 hover:bg-gray-50 {{ request()->routeIs('social.feed') ? 'bg-teal-50 text-teal-700' : '' }}">Feed</a>
            <a href="{{ route('social.friends') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-teal-600 hover:bg-gray-50 {{ request()->routeIs('social.friends') ? 'bg-teal-50 text-teal-700' : '' }}">Friends</a>
            <a href="{{ route('social.friends.suggestions') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-teal-600 hover:bg-gray-50 {{ request()->routeIs('social.friends.suggestions') ? 'bg-teal-50 text-teal-700' : '' }}">Find Friends</a>
            <a href="{{ route('projects.index') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-teal-600 hover:bg-gray-50 {{ request()->routeIs('projects.*') ? 'bg-teal-50 text-teal-700' : '' }}">Projects</a>
            <a href="{{ route('social.posts.create') }}" class="block px-3 py-2 rounded-md text-base font-medium text-teal-600 hover:text-teal-700 hover:bg-gray-50">New Post</a>
        </div>
        
        @auth
            <div class="pt-4 pb-3 border-t border-gray-200">
                <div class="flex items-center px-4">
                    <div class="flex-shrink-0">
                        @if(auth()->user()->profile && auth()->user()->profile->avatar)
                            <img class="h-10 w-10 rounded-full object-cover border border-gray-200" src="{{ asset('storage/'.auth()->user()->profile->avatar) }}" alt="{{ auth()->user()->name }}">
                        @else
                            <div class="h-10 w-10 rounded-full bg-teal-600 flex items-center justify-center">
                                <span class="text-white font-medium">{{ substr(auth()->user()->name, 0, 1) }}</span>
                            </div>
                        @endif
                    </div>
                    <div class="ml-3">
                        <div class="text-base font-medium text-gray-800">{{ auth()->user()->name }}</div>
                        <div class="text-sm font-medium text-gray-500">{{ auth()->user()->email }}</div>
                    </div>
                </div>
                <div class="mt-3 px-2 space-y-1">
                    <a href="{{ route('profile.show', auth()->id()) }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-teal-600 hover:bg-gray-50">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Profile
                        </div>
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center px-3 py-2 rounded-md text-base font-medium text-red-600 hover:text-red-700 hover:bg-red-50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            Sign out
                        </button>
                    </form>
                </div>
            </div>
        @endauth
    </div>
</header>
@endif 