@extends('layouts.app')

@section('title', 'My Conversations')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="p-6">
            <h1 class="text-2xl font-bold mb-6">My Conversations</h1>
            
            @if(count($conversations) > 0)
                <div class="space-y-4">
                    @foreach($conversations as $conversation)
                        <a href="{{ route('chat.show', $conversation['user']->id) }}" class="block">
                            <div class="flex items-center p-4 rounded-lg hover:bg-gray-50 transition {{ $conversation['unread_count'] > 0 ? 'bg-teal-50' : '' }}">
                                <div class="relative">
                                    @if($conversation['user']->profile && $conversation['user']->profile->avatar)
                                        <img src="{{ asset('storage/' . $conversation['user']->profile->avatar) }}" alt="{{ $conversation['user']->name }}" class="w-12 h-12 rounded-full object-cover">
                                    @else
                                        <div class="w-12 h-12 rounded-full bg-teal-100 flex items-center justify-center">
                                            <span class="text-teal-800 font-bold text-lg">{{ substr($conversation['user']->name, 0, 1) }}</span>
                                        </div>
                                    @endif
                                    
                                    @if($conversation['unread_count'] > 0)
                                        <div class="absolute -top-1 -right-1 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs">
                                            {{ $conversation['unread_count'] }}
                                        </div>
                                    @endif
                                </div>
                                
                                <div class="ml-4 flex-1">
                                    <div class="flex justify-between items-center">
                                        <h3 class="font-semibold text-gray-900">{{ $conversation['user']->name }}</h3>
                                        <span class="text-xs text-gray-500">{{ $conversation['last_message']->created_at->diffForHumans() }}</span>
                                    </div>
                                    <p class="text-sm text-gray-600 truncate">
                                        @if($conversation['last_message']->sender_id == auth()->id())
                                            <span class="text-gray-400">You: </span>
                                        @endif
                                        {{ $conversation['last_message']->message }}
                                    </p>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                    </svg>
                    <p class="text-gray-500">You don't have any conversations yet.</p>
                    <p class="text-gray-500 mt-2">Start a conversation by messaging a friend from their profile.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
