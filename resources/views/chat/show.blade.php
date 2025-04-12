@extends('layouts.app')

@section('title', 'Chat with ' . $otherUser->name)

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <!-- Chat header -->
        <div class="bg-teal-600 text-white p-4 flex items-center justify-between">
            <div class="flex items-center">
                <a href="{{ route('chat.index') }}" class="mr-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <div class="flex items-center">
                    @if($otherUser->profile && $otherUser->profile->avatar)
                        <img src="{{ asset('storage/' . $otherUser->profile->avatar) }}" alt="{{ $otherUser->name }}" class="w-10 h-10 rounded-full object-cover mr-3">
                    @else
                        <div class="w-10 h-10 rounded-full bg-teal-100 flex items-center justify-center mr-3">
                            <span class="text-teal-800 font-bold">{{ substr($otherUser->name, 0, 1) }}</span>
                        </div>
                    @endif
                    <div>
                        <h2 class="font-semibold">{{ $otherUser->name }}</h2>
                        <p class="text-xs text-teal-100">
                            @if($otherUser->profile && $otherUser->profile->location)
                                {{ $otherUser->profile->location }}
                            @else
                                No location set
                            @endif
                        </p>
                    </div>
                </div>
            </div>
            <a href="{{ route('profile.show', $otherUser->id) }}" class="text-white hover:text-teal-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </a>
        </div>
        
        <!-- Chat messages -->
        <div id="chat-messages" class="p-4 h-96 overflow-y-auto bg-gray-50">
            @foreach($messages as $message)
                <div class="mb-4 {{ $message->sender_id == auth()->id() ? 'text-right' : 'text-left' }}">
                    <div class="inline-block max-w-3/4 rounded-lg px-4 py-2 {{ $message->sender_id == auth()->id() ? 'bg-teal-600 text-white' : 'bg-gray-200 text-gray-800' }}">
                        <p>{{ $message->message }}</p>
                        <p class="text-xs mt-1 {{ $message->sender_id == auth()->id() ? 'text-teal-100' : 'text-gray-500' }}">
                            {{ $message->created_at->format('g:i A') }}
                            @if($message->is_read && $message->sender_id == auth()->id())
                                <span class="ml-1">
                                    <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </span>
                            @endif
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- Chat input -->
        <div class="p-4 border-t">
            <form id="message-form" class="flex">
                <input type="hidden" id="receiver-id" value="{{ $otherUser->id }}">
                <input type="text" id="message-input" class="flex-1 border border-gray-300 rounded-l-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-teal-500" placeholder="Type your message...">
                <button type="submit" class="bg-teal-600 text-white px-4 py-2 rounded-r-lg hover:bg-teal-700 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                    </svg>
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://js.pusher.com/8.0/pusher.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const receiverId = document.getElementById('receiver-id').value;
        const messageForm = document.getElementById('message-form');
        const messageInput = document.getElementById('message-input');
        const chatMessages = document.getElementById('chat-messages');
        
        // Scroll to bottom of chat
        function scrollToBottom() {
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }
        
        // Scroll to bottom initially
        scrollToBottom();
        
        // Initialize Pusher
        const pusher = new Pusher('{{ config('broadcasting.connections.pusher.key') }}', {
            cluster: '{{ config('broadcasting.connections.pusher.options.cluster') }}',
            encrypted: true
        });
        
        // Subscribe to private channel
        const channel = pusher.subscribe('chat.' + {{ auth()->id() }});
        
        // Listen for new messages
        channel.bind('message.sent', function(data) {
            console.log('Received message:', data);
            if (data.message.sender_id == receiverId) {
                // Create message element
                const messageDiv = document.createElement('div');
                messageDiv.className = 'mb-4 text-left';
                
                const messageContent = document.createElement('div');
                messageContent.className = 'inline-block max-w-3/4 rounded-lg px-4 py-2 bg-gray-200 text-gray-800';
                
                const messageText = document.createElement('p');
                messageText.textContent = data.message.message;
                
                const messageTime = document.createElement('p');
                messageTime.className = 'text-xs mt-1 text-gray-500';
                messageTime.textContent = new Date(data.message.created_at).toLocaleTimeString([], { hour: 'numeric', minute: '2-digit' });
                
                messageContent.appendChild(messageText);
                messageContent.appendChild(messageTime);
                messageDiv.appendChild(messageContent);
                
                chatMessages.appendChild(messageDiv);
                
                // Mark message as read
                fetch(`/messages/${data.message.id}/read`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                });
                
                // Scroll to bottom
                scrollToBottom();
            }
        });
        
        // Send message
        messageForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const message = messageInput.value.trim();
            if (!message) return;
            
            // Send message to server
            fetch('/messages/send', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    receiver_id: receiverId,
                    message: message
                })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                console.log('Message sent successfully:', data);
                // Create message element
                const messageDiv = document.createElement('div');
                messageDiv.className = 'mb-4 text-right';
                
                const messageContent = document.createElement('div');
                messageContent.className = 'inline-block max-w-3/4 rounded-lg px-4 py-2 bg-teal-600 text-white';
                
                const messageText = document.createElement('p');
                messageText.textContent = message;
                
                const messageTime = document.createElement('p');
                messageTime.className = 'text-xs mt-1 text-teal-100';
                messageTime.textContent = new Date().toLocaleTimeString([], { hour: 'numeric', minute: '2-digit' });
                
                messageContent.appendChild(messageText);
                messageContent.appendChild(messageTime);
                messageDiv.appendChild(messageContent);
                
                chatMessages.appendChild(messageDiv);
                
                // Clear input
                messageInput.value = '';
                
                // Scroll to bottom
                scrollToBottom();
            })
            .catch(error => {
                console.error('Error sending message:', error);
                alert('Failed to send message. Please try again.');
            });
        });
    });
</script>
@endsection
