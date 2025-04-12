# Jusoor Chat System

This document provides instructions for setting up and using the chat and notification system in Jusoor platform.

## Pusher Configuration

The chat system uses Pusher for real-time messaging. The Pusher credentials have already been configured in the application with the following values:

```
PUSHER_APP_ID=1973334
PUSHER_APP_KEY=d767d86681964bbcd7d4
PUSHER_APP_SECRET=f9f029c495677caf1dab
PUSHER_APP_CLUSTER=mt1
```

### Setting up your .env file

To make the chat system work, you need to add these values to your `.env` file:

1. Open your `.env` file
2. Add or update the following lines:

```
PUSHER_APP_ID=1973334
PUSHER_APP_KEY=d767d86681964bbcd7d4
PUSHER_APP_SECRET=f9f029c495677caf1dab
PUSHER_APP_CLUSTER=mt1
BROADCAST_DRIVER=pusher
```

3. Save the file

### Broadcasting Configuration

Make sure the `config/broadcasting.php` file has Pusher configured correctly. The default Laravel configuration should work with the above .env settings.

## Database Migrations

Run the database migrations to create the necessary tables for the chat system:

```
php artisan migrate
```

## Features

The chat system includes the following features:

1. **Real-time messaging** - Send and receive messages instantly
2. **Notifications** - Get notified when you receive a new message
3. **Unread message count** - See how many unread messages you have
4. **Message history** - View your conversation history with other users
5. **Read receipts** - Know when your messages have been read

## Usage

- **Sending a message**: Visit any user's profile and click the "Message" button
- **Viewing conversations**: Click the message icon in the header
- **Checking notifications**: The message icon will show a badge with the number of unread messages

## Troubleshooting

If you encounter issues with the chat system:

1. Make sure Pusher is correctly configured in your .env file
2. Check that you have run the migrations
3. Ensure JavaScript is enabled in your browser
4. Clear your browser cache and reload the page

For any further issues, please contact the system administrator.
