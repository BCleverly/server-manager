# Real-time Chat with Laravel Reverb

This project now includes a real-time chat feature powered by Laravel Reverb and Livewire.

## Features

- Real-time messaging using Laravel Reverb WebSocket server
- Modern UI built with Flux components
- Auto-scrolling message container
- User avatars with initials
- Timestamp display
- Responsive design

## Setup Instructions

### 1. Complete Reverb Installation

Run the broadcasting installation command and select "reverb":

```bash
php artisan install:broadcasting
# Select "reverb" when prompted
```

### 2. Environment Configuration

Add these variables to your `.env` file:

```env
BROADCAST_CONNECTION=reverb
REVERB_APP_ID=your-app-id
REVERB_APP_KEY=your-app-key
REVERB_APP_SECRET=your-app-secret
REVERB_HOST=localhost
REVERB_PORT=8080
REVERB_SCHEME=http
```

For local development, you can use these default values:
```env
REVERB_APP_ID=local
REVERB_APP_KEY=local
REVERB_APP_SECRET=local
```

### 3. Start the Reverb Server

In a separate terminal, start the Reverb WebSocket server:

```bash
php artisan reverb:start
```

### 4. Access the Chat

1. Navigate to `/chat` in your browser
2. Or click the "Chat" link in the sidebar navigation
3. Start typing messages to see real-time broadcasting

## How It Works

### Component Structure

- **`app/Livewire/Chat.php`**: Main Livewire component handling the chat logic
- **`resources/views/livewire/chat.blade.php`**: Blade template with Flux UI components
- **`MessageSent` event**: Broadcasts messages to all connected users

### Broadcasting Flow

1. User types a message and clicks "Send"
2. `sendMessage()` method is called
3. Message is added to local messages array
4. `MessageSent` event is broadcast to the 'chat' channel
5. Other users receive the event via `handleNewMessage()`
6. Message appears in real-time for all users

### Security

- Only authenticated users can access the chat
- Channel authorization is handled in `routes/channels.php`
- Messages are sanitized before broadcasting

## Customization

### Styling
The chat uses Flux components for consistent styling. You can customize the appearance by modifying the Blade template.

### Features to Add
- Message persistence (database storage)
- User typing indicators
- Message reactions
- File attachments
- Private messaging
- Message editing/deletion

## Troubleshooting

### Messages not appearing in real-time
1. Ensure Reverb server is running: `php artisan reverb:start`
2. Check browser console for WebSocket connection errors
3. Verify environment variables are set correctly

### Reverb server won't start
1. Check if port 8080 is available
2. Ensure all required extensions are installed
3. Try a different port: `php artisan reverb:start --port=8081`

## Production Deployment

For production, consider:
- Using a process manager like Supervisor
- Setting up SSL/TLS for secure WebSocket connections
- Implementing Redis for horizontal scaling
- Adding rate limiting for message sending
- Implementing message persistence 