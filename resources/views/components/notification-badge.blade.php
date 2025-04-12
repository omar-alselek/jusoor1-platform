<div id="notification-badge" class="hidden relative">
    <span id="unread-count" class="absolute -top-1 -right-1 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs">0</span>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const notificationBadge = document.getElementById('notification-badge');
        const unreadCountElement = document.getElementById('unread-count');
        
        // Function to update unread count
        function updateUnreadCount() {
            fetch('/messages/unread-count')
                .then(response => response.json())
                .then(data => {
                    const count = data.unread_count;
                    if (count > 0) {
                        unreadCountElement.textContent = count > 99 ? '99+' : count;
                        notificationBadge.classList.remove('hidden');
                    } else {
                        notificationBadge.classList.add('hidden');
                    }
                })
                .catch(error => console.error('Error fetching unread count:', error));
        }
        
        // Initialize Pusher
        const pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
            cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
            encrypted: true
        });
        
        // Subscribe to private notification channel
        const channel = pusher.subscribe('notifications.{{ auth()->id() }}');
        
        // Listen for new message notifications
        channel.bind('new.message', function(data) {
            updateUnreadCount();
            
            // Show browser notification if supported
            if ('Notification' in window && Notification.permission === 'granted') {
                new Notification('New Message', {
                    body: data.message,
                    icon: '/logo.png'
                });
            }
        });
        
        // Check for unread messages on page load
        updateUnreadCount();
        
        // Check for unread messages every minute
        setInterval(updateUnreadCount, 60000);
        
        // Request notification permission
        if ('Notification' in window && Notification.permission !== 'granted' && Notification.permission !== 'denied') {
            Notification.requestPermission();
        }
    });
</script>
@endpush
