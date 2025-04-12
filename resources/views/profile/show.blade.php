@extends('layouts.app')

@section('title', 'Profile')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <!-- Header with background image -->
        <div class="relative h-48 bg-gradient-to-r from-teal-600 to-cyan-700">
            <div class="absolute -bottom-16 left-6">
                @if($user->profile && $user->profile->avatar)
                    <img src="{{ asset('storage/' . $user->profile->avatar) }}" alt="{{ $user->name }}" class="w-32 h-32 rounded-full border-4 border-white object-cover shadow-md">
                @else
                    <div class="w-32 h-32 rounded-full bg-teal-100 border-4 border-white flex items-center justify-center shadow-md">
                        <span class="text-teal-800 font-bold text-4xl">{{ substr($user->name, 0, 1) }}</span>
                    </div>
                @endif
            </div>
        </div>
        
        <div class="p-6 pt-20">
            <div class="flex flex-wrap md:flex-nowrap">
                <!-- Basic user information -->
                <div class="w-full md:w-1/3 mb-6 md:mb-0 md:pr-6">
                    <div class="text-left mb-6">
                        <h2 class="text-2xl font-bold">{{ $user->name }}</h2>
                        
                        @if(auth()->id() == $user->id)
                            <div class="mt-4">
                                <a href="{{ route('profile.edit', $user->id) }}" class="inline-block bg-teal-600 text-white px-4 py-2 rounded-md hover:bg-teal-700 transition">Edit Profile</a>
                            </div>
                        @else
                            <div class="mt-4">
                                <a href="{{ route('chat.show', $user->id) }}" class="inline-flex items-center bg-teal-600 text-white px-4 py-2 rounded-md hover:bg-teal-700 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                    </svg>
                                    Message
                                </a>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Contact Information -->
                    <div class="bg-gray-50 rounded-lg p-4 mb-6">
                        <h3 class="text-lg font-semibold mb-3">Contact Information</h3>
                        <div class="space-y-2">
                            @if(auth()->id() == $user->id || ($user->profile && $user->profile->phone))
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                    <span>{{ $user->profile && $user->profile->phone ? $user->profile->phone : 'No phone number specified' }}</span>
                                </div>
                            @endif
                            
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <span>{{ $user->profile && $user->profile->location ? $user->profile->location : 'No location specified' }}</span>
                            </div>
                            
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-2a4 4 0 014-4h14a4 4 0 014 4v2"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                                <span>{{ $user->profile && $user->profile->current_country ? $user->profile->current_country : 'No current country specified' }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Social Media Links -->
                    @if($user->profile && ($user->profile->social_facebook || $user->profile->social_twitter || $user->profile->social_linkedin))
                    <div class="bg-gray-50 rounded-lg p-4 mb-6">
                        <h3 class="text-lg font-semibold mb-3">Social Media</h3>
                        <div class="flex space-x-4">
                            @if($user->profile->social_facebook)
                            <a href="{{ $user->profile->social_facebook }}" target="_blank" class="text-blue-600 hover:text-blue-800">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" />
                                </svg>
                            </a>
                            @endif
                            
                            @if($user->profile->social_twitter)
                            <a href="{{ $user->profile->social_twitter }}" target="_blank" class="text-blue-400 hover:text-blue-600">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723 10.012 10.012 0 01-3.127 1.195 4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z" />
                                </svg>
                            </a>
                            @endif
                            
                            @if($user->profile->social_linkedin)
                            <a href="{{ $user->profile->social_linkedin }}" target="_blank" class="text-blue-700 hover:text-blue-900">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
                                </svg>
                            </a>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
                
                <!-- Profile Details -->
                <div class="w-full md:w-2/3">
                    <!-- Bio -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-3">About Me</h3>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p>{{ $user->profile && $user->profile->bio ? $user->profile->bio : 'No bio added yet.' }}</p>
                        </div>
                    </div>
                    
                    <!-- Skills -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-3">Skills</h3>
                        <div class="bg-gray-50 rounded-lg p-4">
                            @if($user->profile && $user->profile->skills)
                                <div class="flex flex-wrap gap-2">
                                    @foreach(explode(',', $user->profile->skills) as $skill)
                                        <span class="px-3 py-1 bg-teal-100 text-teal-800 rounded-full">{{ trim($skill) }}</span>
                                    @endforeach
                                </div>
                            @else
                                <p>No skills added yet.</p>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Social Activity -->
                    @if(isset($user->posts) && count($user->posts) > 0)
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-3">Social Activity</h3>
                        <div class="space-y-4">
                            @foreach($user->posts as $post)
                            <div class="bg-gray-50 rounded-lg p-4 shadow-sm">
                                <div class="flex items-center mb-3">
                                    @if($user->profile && $user->profile->avatar)
                                        <img src="{{ asset('storage/' . $user->profile->avatar) }}" alt="{{ $user->name }}" class="w-10 h-10 rounded-full mr-3 object-cover">
                                    @else
                                        <div class="w-10 h-10 rounded-full bg-teal-100 mr-3 flex items-center justify-center">
                                            <span class="text-teal-800 font-bold">{{ substr($user->name, 0, 1) }}</span>
                                        </div>
                                    @endif
                                    <div>
                                        <h4 class="font-semibold">{{ $user->name }}</h4>
                                        <p class="text-xs text-gray-500">{{ $post->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <p class="text-gray-800">{{ $post->content }}</p>
                                </div>
                                
                                @if($post->images && is_array($post->images) && count($post->images) > 0)
                                <div class="mt-4 grid grid-cols-{{ min(count($post->images), 3) }} gap-2 mb-3">
                                    @foreach($post->images as $image)
                                    <div class="relative">
                                        <img src="{{ asset('storage/' . $image) }}" alt="Post image" class="rounded-md w-full h-48 object-cover">
                                    </div>
                                    @endforeach
                                </div>
                                @endif
                                
                                <div class="flex text-sm text-gray-500 border-t pt-3">
                                    <div class="flex items-center mr-4">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z"></path>
                                        </svg>
                                        <span>{{ $post->likes ? $post->likes->count() : 0 }} {{ ($post->likes ? $post->likes->count() : 0) == 1 ? 'Like' : 'Likes' }}</span>
                                    </div>
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zM7 8H5v2h2V8zm2 0h2v2H9V8zm6 0h-2v2h2V8z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span>{{ $post->comments ? $post->comments->count() : 0 }} {{ ($post->comments ? $post->comments->count() : 0) == 1 ? 'Comment' : 'Comments' }}</span>
                                    </div>
                                    <div class="ml-auto">
                                        <a href="{{ route('social.posts.show', $post) }}" class="text-teal-600 hover:text-teal-800 font-medium">View Post</a>
                                    </div>
                                </div>
                                
                                <!-- Comments Preview -->
                                @if($post->comments && $post->comments->count() > 0)
                                <div class="mt-3 pt-2 border-t">
                                    @foreach($post->comments->take(2) as $comment)
                                    <div class="flex mb-2">
                                        @if($comment->user->profile && $comment->user->profile->avatar)
                                            <img src="{{ asset('storage/' . $comment->user->profile->avatar) }}" alt="{{ $comment->user->name }}" class="w-8 h-8 rounded-full mr-2">
                                        @else
                                            <div class="w-8 h-8 rounded-full bg-gray-300 mr-2 flex items-center justify-center text-gray-700 text-sm font-bold">
                                                {{ substr($comment->user->name, 0, 1) }}
                                            </div>
                                        @endif
                                        <div class="bg-gray-100 rounded-lg py-2 px-3 flex-grow">
                                            <div class="flex justify-between items-start">
                                                <p class="font-semibold text-sm">{{ $comment->user->name }}</p>
                                                <p class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</p>
                                            </div>
                                            <p class="text-sm mt-1">{{ $comment->content }}</p>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                @endif
                            </div>
                            @endforeach
                            
                            @if(count($user->posts) > 5)
                            <div class="text-center">
                                <a href="{{ route('social.feed') }}?user={{ $user->id }}" class="inline-block py-2 px-4 bg-teal-600 text-white rounded-lg hover:bg-teal-700 transition">View More Posts</a>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif
                    
                    <!-- Projects -->
                    @if(isset($user->projects) && count($user->projects) > 0 || (isset($user->volunteers) && count($user->volunteers) > 0))
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-3">Project Participation</h3>
                        
                        <!-- Projects Created -->
                        @if(isset($user->projects) && count($user->projects) > 0)
                        <div class="mb-4">
                            <h4 class="text-md font-medium mb-2">Projects Created</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach($user->projects->take(4) as $project)
                                <div class="bg-gray-50 rounded-lg p-3">
                                    <a href="{{ route('projects.show', $project) }}" class="text-teal-700 hover:text-teal-900 font-semibold">{{ $project->title }}</a>
                                    <p class="text-sm text-gray-600">{{ $project->location }} - {{ $project->start_date->format('Y/m/d') }}</p>
                                </div>
                                @endforeach
                            </div>
                            @if(count($user->projects) > 4)
                                <div class="mt-2 text-right">
                                    <a href="#" class="text-teal-600 hover:text-teal-800 text-sm">View more...</a>
                                </div>
                            @endif
                        </div>
                        @endif
                        
                        <!-- Projects Volunteered For -->
                        @if(isset($user->volunteers) && count($user->volunteers) > 0)
                        <div>
                            <h4 class="text-md font-medium mb-2">Volunteered Projects</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach($user->volunteers->take(4) as $volunteer)
                                <div class="bg-gray-50 rounded-lg p-3">
                                    <a href="{{ route('projects.show', $volunteer->project) }}" class="text-teal-700 hover:text-teal-900 font-semibold">{{ $volunteer->project->title }}</a>
                                    <p class="text-sm text-gray-600">{{ $volunteer->project->location }} - {{ $volunteer->approved_at ? 'Approved' : 'Pending Approval' }}</p>
                                </div>
                                @endforeach
                            </div>
                            @if(count($user->volunteers) > 4)
                                <div class="mt-2 text-right">
                                    <a href="#" class="text-teal-600 hover:text-teal-800 text-sm">View more...</a>
                                </div>
                            @endif
                        </div>
                        @endif
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 