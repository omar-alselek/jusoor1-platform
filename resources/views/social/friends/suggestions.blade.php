@extends('layouts.app')

@section('title', 'Find Friends')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex flex-wrap md:flex-nowrap">
        <!-- Left Sidebar -->
        <div class="w-full md:w-1/4 pr-0 md:pr-6 mb-6 md:mb-0">
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <h2 class="text-xl font-bold mb-4">My Profile</h2>
                <div class="flex items-center mb-4">
                    @if(auth()->user()->profile->avatar)
                        <img src="{{ asset('storage/' . auth()->user()->profile->avatar) }}" alt="{{ auth()->user()->name }}" class="w-16 h-16 rounded-full mr-4">
                    @else
                        <div class="w-16 h-16 rounded-full bg-gray-300 mr-4 flex items-center justify-center text-gray-700 text-xl font-bold">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                    @endif
                    <div>
                        <h3 class="font-bold">{{ auth()->user()->name }}</h3>
                        <p class="text-gray-600 text-sm">{{ auth()->user()->profile->location ?? 'No location set' }}</p>
                    </div>
                </div>
                <a href="{{ route('profile.show', auth()->id()) }}" class="block text-center w-full py-2 px-4 bg-teal-600 text-white rounded-md hover:bg-teal-700 transition">عرض الملف الشخصي</a>
            </div>
            
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-bold mb-4">Quick Links</h2>
                <nav>
                    <ul class="space-y-2">
                        <li>
                            <a href="{{ route('social.feed') }}" class="flex items-center text-gray-700 hover:text-teal-600">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                                </svg>
                                Feed
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('social.friends') }}" class="flex items-center text-gray-700 hover:text-teal-600">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"></path>
                                </svg>
                                Friends
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('social.friends.suggestions') }}" class="flex items-center text-teal-600 font-medium">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6zM16 7a1 1 0 10-2 0v1h-1a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V7z"></path>
                                </svg>
                                Find Friends
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('projects.index') }}" class="flex items-center text-gray-700 hover:text-teal-600">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"></path>
                                </svg>
                                Projects
                            </a>
                        </li>
                    </ul>
                </nav>
                
                <!-- Logout Button -->
                <div class="mt-6 pt-4 border-t border-gray-200">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex items-center w-full text-left text-red-600 hover:text-red-800 font-medium py-2">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            Sign Out
                        </button>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="w-full md:w-3/4">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-bold">People You May Know</h2>
                    <form action="{{ route('social.search.users') }}" method="GET" class="flex">
                        <input type="search" name="query" placeholder="Search by name or location" class="border-gray-300 rounded-l-md shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-200 focus:ring-opacity-50">
                        <button type="submit" class="py-2 px-4 bg-teal-600 text-white rounded-r-md hover:bg-teal-700 transition">Search</button>
                    </form>
                </div>
                
                <!-- Friend Suggestions -->
                @if($suggestions->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($suggestions as $user)
                    <div class="border rounded-lg p-4">
                        <div class="flex items-center mb-3">
                            @if($user->profile && $user->profile->avatar)
                                <img src="{{ asset('storage/' . $user->profile->avatar) }}" alt="{{ $user->name }}" class="w-14 h-14 rounded-full mr-4">
                            @else
                                <div class="w-14 h-14 rounded-full bg-gray-300 mr-4 flex items-center justify-center text-gray-700 text-xl font-bold">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                            @endif
                            <div>
                                <h3 class="font-bold">{{ $user->name }}</h3>
                                <p class="text-gray-600 text-sm">{{ $user->profile && $user->profile->location ? $user->profile->location : 'No location' }}</p>
                            </div>
                        </div>
                        
                        <div class="text-sm text-gray-500 mb-4">
                            <p>{{ $user->profile && $user->profile->bio ? Str::limit($user->profile->bio, 100) : 'No bio available' }}</p>
                        </div>
                        
                        <div class="flex flex-wrap gap-1 mb-4">
                            @if($user->profile && $user->profile->skills)
                                @foreach(explode(',', $user->profile->skills) as $skill)
                                    <span class="px-2 py-1 bg-gray-100 text-xs rounded-full">{{ trim($skill) }}</span>
                                @endforeach
                            @endif
                        </div>
                        
                        <div class="flex justify-between items-center">
                            <a href="{{ route('profile.show', $user->id) }}" class="text-teal-600 hover:text-teal-800">View Profile</a>
                            <form action="{{ route('social.friends.request', $user) }}" method="POST">
                                @csrf
                                <button type="submit" class="inline-flex items-center px-3 py-1 border border-teal-600 text-teal-600 rounded-md hover:bg-teal-600 hover:text-white transition text-sm">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                                    </svg>
                                    Add Friend
                                </button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-10">
                    <svg class="w-16 h-16 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <h3 class="mt-4 text-lg font-medium text-gray-900">No suggestions available</h3>
                    <p class="mt-1 text-gray-500">We couldn't find any people to suggest right now.</p>
                    <div class="mt-6">
                        <a href="{{ route('social.search.users') }}" class="py-2 px-4 bg-teal-600 text-white rounded-md hover:bg-teal-700 transition">Search for People</a>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
