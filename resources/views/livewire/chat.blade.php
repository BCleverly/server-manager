<div class="max-w-2xl mx-auto p-6">
    <div class="bg-white dark:bg-zinc-900 rounded-lg border border-zinc-200 dark:border-zinc-700 shadow-sm">
        <!-- Header -->
        <div class="px-6 py-4 border-b border-zinc-200 dark:border-zinc-700">
            <h2 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100">Real-time Chat</h2>
            <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">
                Messages are broadcast to all users on this page using Laravel Reverb
            </p>
        </div>

        <!-- Reverb Status Alert -->
        @if(!$reverbAvailable)
            <div class="px-6 py-4 bg-red-50 dark:bg-red-900/20 border-b border-red-200 dark:border-red-800">
                <div class="flex items-center space-x-3">
                    <div class="flex-shrink-0">
                        <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-sm font-medium text-red-800 dark:text-red-200">
                            Reverb Connection Issue
                        </h3>
                        <p class="text-sm text-red-700 dark:text-red-300 mt-1">
                            {{ $reverbStatusMessage }}
                        </p>
                        <p class="text-xs text-red-600 dark:text-red-400 mt-2">
                            Messages will only be visible to you until the connection is restored.
                        </p>
                    </div>
                </div>
            </div>
        @else
            <div class="px-6 py-3 bg-green-50 dark:bg-green-900/20 border-b border-green-200 dark:border-green-800">
                <div class="flex items-center space-x-3">
                    <div class="flex-shrink-0">
                        <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm text-green-700 dark:text-green-300">
                            {{ $reverbStatusMessage }}
                        </p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Content -->
        <div class="p-6">
            <!-- Messages Container -->
            <div class="h-96 overflow-y-auto mb-4 space-y-3" id="messages-container">
                @foreach($messages as $message)
                    @if(isset($message['type']) && $message['type'] === 'join')
                        <!-- Join Notification -->
                        <div class="flex justify-center">
                            <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-full px-4 py-2">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    <span class="text-sm text-blue-700 dark:text-blue-300">{{ $message['message'] }}</span>
                                    <span class="text-xs text-blue-600 dark:text-blue-400">{{ $message['timestamp'] }}</span>
                                </div>
                            </div>
                        </div>
                    @else
                        <!-- Regular Message -->
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center text-white text-sm font-medium">
                                    {{ substr($message['user'], 0, 1) }}
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center space-x-2">
                                    <span class="text-sm font-medium text-zinc-900 dark:text-zinc-100">{{ $message['user'] }}</span>
                                    <span class="text-xs text-zinc-500 dark:text-zinc-400">{{ $message['timestamp'] }}</span>
                                </div>
                                <p class="text-sm text-zinc-700 dark:text-zinc-300 mt-1">{{ $message['message'] }}</p>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>

            <!-- Message Input -->
            <div class="flex space-x-2">
                <input 
                    type="text"
                    wire:model="message" 
                    placeholder="Type your message..." 
                    class="flex-1 px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-md bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 placeholder-zinc-500 dark:placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    wire:keydown.enter="sendMessage"
                />
                <button 
                    wire:click="sendMessage" 
                    wire:loading.attr="disabled"
                    class="px-4 py-2 bg-blue-500 hover:bg-blue-600 disabled:bg-blue-300 text-white rounded-md flex items-center space-x-2 transition-colors duration-200"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                    </svg>
                    <span wire:loading.remove>Send</span>
                    <span wire:loading>Sending...</span>
                </button>
            </div>
        </div>
    </div>

    <script>
        // Auto-scroll to bottom when new messages arrive
        document.addEventListener('livewire:init', () => {
            Livewire.on('echo:chat,MessageEvent', () => {
                setTimeout(() => {
                    const container = document.getElementById('messages-container');
                    container.scrollTop = container.scrollHeight;
                }, 100);
            });

            Livewire.on('echo:chat,UserJoined', () => {
                setTimeout(() => {
                    const container = document.getElementById('messages-container');
                    container.scrollTop = container.scrollHeight;
                }, 100);
            });
        });
    </script>
</div> 