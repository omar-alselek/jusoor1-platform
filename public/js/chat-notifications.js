/**
 * Chat and Notification System for Jusoor
 * 
 * This file handles the real-time messaging and notification functionality
 * using Pusher.
 */

class ChatNotificationSystem {
    constructor(userId, pusherKey, pusherCluster) {
        this.userId = userId;
        this.pusherKey = pusherKey;
        this.pusherCluster = pusherCluster;
        this.pusher = null;
        this.chatChannel = null;
        this.notificationChannel = null;
        this.unreadCount = 0;
        this.notificationBadge = document.getElementById('notification-badge');
        this.unreadCountElement = document.getElementById('unread-count');
        
        // Debug mode
        this.debug = true;
    }

    /**
     * Initialize the Pusher connection and channels
     */
    initialize() {
        // Initialize Pusher
        this.pusher = new Pusher(this.pusherKey, {
            cluster: this.pusherCluster,
            encrypted: true
        });

        if (this.debug) {
            console.log('Initializing ChatNotificationSystem for user ID:', this.userId);
            console.log('Pusher Key:', this.pusherKey);
            console.log('Pusher Cluster:', this.pusherCluster);
        }

        // Subscribe to private channels
        if (this.userId) {
            this.chatChannel = this.pusher.subscribe(`chat.${this.userId}`);
            this.notificationChannel = this.pusher.subscribe(`notifications.${this.userId}`);
            
            // Log channel subscription status
            this.chatChannel.bind('pusher:subscription_succeeded', () => {
                if (this.debug) console.log(`Successfully subscribed to chat.${this.userId}`);
            });
            
            this.notificationChannel.bind('pusher:subscription_succeeded', () => {
                if (this.debug) console.log(`Successfully subscribed to notifications.${this.userId}`);
            });
            
            this.chatChannel.bind('pusher:subscription_error', (error) => {
                console.error(`Error subscribing to chat.${this.userId}:`, error);
            });
            
            this.notificationChannel.bind('pusher:subscription_error', (error) => {
                console.error(`Error subscribing to notifications.${this.userId}:`, error);
            });
            
            this.setupEventListeners();
            this.fetchUnreadCount();
        }

        // Request notification permission
        this.requestNotificationPermission();
    }

    /**
     * Set up event listeners for Pusher channels
     */
    setupEventListeners() {
        // Listen for new messages
        this.chatChannel.bind('message.sent', data => {
            if (this.debug) console.log('Received message event:', data);
            this.handleNewMessage(data);
        });

        // Listen for notifications
        this.notificationChannel.bind('new.message', data => {
            if (this.debug) console.log('Received notification event:', data);
            this.handleNotification(data);
        });
    }

    /**
     * Handle new incoming messages
     */
    handleNewMessage(data) {
        // This is handled in the chat view if the user is in a conversation
        // Otherwise, we just update the unread count
        this.fetchUnreadCount();

        // Trigger a custom event that other parts of the app can listen for
        const event = new CustomEvent('new-message', { detail: data });
        document.dispatchEvent(event);
    }

    /**
     * Handle new notifications
     */
    handleNotification(data) {
        if (this.debug) console.log('Handling notification:', data);
        this.updateUnreadCount(data.count);
        this.showBrowserNotification(data.message);
    }

    /**
     * Fetch the current unread message count from the server
     */
    fetchUnreadCount() {
        fetch('/messages/unread-count')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (this.debug) console.log('Fetched unread count:', data);
                this.updateUnreadCount(data.unread_count);
            })
            .catch(error => console.error('Error fetching unread count:', error));
    }

    /**
     * Update the unread count badge
     */
    updateUnreadCount(count) {
        this.unreadCount = count;
        
        if (this.debug) console.log('Updating unread count to:', count);
        
        if (this.notificationBadge && this.unreadCountElement) {
            if (count > 0) {
                this.unreadCountElement.textContent = count > 99 ? '99+' : count;
                this.notificationBadge.classList.remove('hidden');
            } else {
                this.notificationBadge.classList.add('hidden');
            }
        }
    }

    /**
     * Show a browser notification
     */
    showBrowserNotification(message) {
        if ('Notification' in window && Notification.permission === 'granted') {
            new Notification('Jusoor Message', {
                body: message,
                icon: '/images/logo.png'
            });
        }
    }

    /**
     * Request permission for browser notifications
     */
    requestNotificationPermission() {
        if ('Notification' in window && Notification.permission !== 'granted' && Notification.permission !== 'denied') {
            Notification.requestPermission();
        }
    }

    /**
     * Mark a specific message as read
     */
    markMessageAsRead(messageId) {
        if (this.debug) console.log('Marking message as read:', messageId);
        
        fetch(`/messages/${messageId}/read`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (this.debug) console.log('Message marked as read:', data);
            this.fetchUnreadCount();
        })
        .catch(error => console.error('Error marking message as read:', error));
    }

    /**
     * Send a message to another user
     */
    sendMessage(receiverId, message) {
        if (this.debug) console.log('Sending message to user:', receiverId, message);
        
        return fetch('/messages/send', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
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
        });
    }
}

// Initialize the chat notification system when the DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Check if the user is logged in and the necessary elements exist
    const userIdElement = document.getElementById('auth-user-id');
    
    if (userIdElement) {
        const userId = userIdElement.value;
        const pusherKey = document.getElementById('pusher-key').value;
        const pusherCluster = document.getElementById('pusher-cluster').value;
        
        // Initialize the chat notification system
        const chatSystem = new ChatNotificationSystem(userId, pusherKey, pusherCluster);
        chatSystem.initialize();
        
        // Make the chat system available globally
        window.chatSystem = chatSystem;
        
        console.log('Chat notification system initialized');
    }
});
