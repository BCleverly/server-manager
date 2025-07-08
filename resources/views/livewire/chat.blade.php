<div class="max-w-4xl mx-auto p-6 flex flex-row h-[70vh] gap-6"
     x-data
     x-init="window.addEventListener('beforeunload', () => { $wire.userLeft(); });">
    <!-- Sidebar: Active Users -->
    <div class="w-64 bg-base-100 rounded-lg shadow-inner p-4 flex flex-col" wire:poll.5000ms="refreshActiveUsers">
        <div class="font-bold mb-2 flex items-center gap-2">
            <span class="text-primary">Active Users</span>
            <span class="badge badge-primary">{{ count($activeUsers) }}</span>
        </div>
        <ul class="space-y-2 flex-1 overflow-y-auto">
            @forelse($activeUsers as $user)
                <li class="flex items-center gap-3">
                    <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-primary text-white font-bold text-base">
                        {{ $user['initials'] ?? '?' }}
                    </span>
                    <span class="font-medium">{{ $user['name'] ?? 'Unknown' }}</span>
                </li>
            @empty
                <li class="text-zinc-400">No users online</li>
            @endforelse
        </ul>
        <div class="mt-4 text-xs text-zinc-400">Users who join or leave will appear here in real-time.</div>
    </div>
    <!-- Chat Main -->
    <div class="flex-1 flex flex-col">
        <div class="flex-1 overflow-y-auto mb-4 bg-base-200 rounded-lg shadow-inner p-4 space-y-3" id="chat-messages">
            @forelse($messages as $message)
                @if(($message['type'] ?? 'message') === 'join')
                    <div class="flex items-center justify-center my-2">
                        <span class="badge badge-info px-4 py-2 text-sm">
                            <span class="font-semibold">{{ $message['user']['name'] ?? 'Someone' }}</span> joined the chat
                        </span>
                    </div>
                @elseif(($message['type'] ?? 'message') === 'left')
                    <div class="flex items-center justify-center my-2">
                        <span class="badge badge-error px-4 py-2 text-sm">
                            <span class="font-semibold">{{ $message['user']['name'] ?? 'Someone' }}</span> left the chat
                        </span>
                    </div>
                @else
                    <div class="flex items-start gap-3">
                        <div class="flex-shrink-0">
                            <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-primary text-white font-bold text-lg">
                                {{ $message['user']['initials'] ?? '?' }}
                            </span>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center gap-2">
                                <span class="font-semibold text-primary">{{ $message['user']['name'] ?? 'Unknown' }}</span>
                                <span class="text-xs text-zinc-400">{{ \Illuminate\Support\Carbon::parse($message['timestamp'])->diffForHumans() }}</span>
                            </div>
                            <div class="text-base-content mt-1">{{ $message['content'] }}</div>
                        </div>
                    </div>
                @endif
            @empty
                <div class="text-center text-zinc-400">No messages yet. Start the conversation!</div>
            @endforelse
        </div>

        <form wire:submit.prevent="sendMessage" class="flex gap-2 items-end">
            <input
                type="text"
                wire:model.defer="newMessage"
                class="input input-bordered flex-1"
                placeholder="Type your message..."
                maxlength="1000"
                autocomplete="off"
                required
                wire:keydown="typingStart"
            >
            <button type="submit" class="btn btn-primary" wire:loading.attr="disabled" wire:target="sendMessage">
                <span wire:loading.remove wire:target="sendMessage">Send</span>
                <span wire:loading wire:target="sendMessage" class="loading loading-spinner loading-xs"></span>
            </button>
        </form>
        <!-- Typing Indicator -->
        <div class="mt-2 min-h-[1.5rem]">
            @php $otherTypingUsers = collect($typingUsers)->filter(fn($u) => $u['id'] !== auth()->id())->values(); @endphp
            @if(count($otherTypingUsers) > 0)
                <div class="flex items-center gap-2 text-sm text-zinc-500">
                    <span>
                        @foreach($otherTypingUsers as $i => $user)
                            <span class="font-semibold text-primary">{{ $user['name'] }}</span>@if($i < count($otherTypingUsers) - 1), @endif
                        @endforeach
                    </span>
                    <span>is typing...</span>
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Auto-scroll to bottom on new message
    window.addEventListener('livewire:update', () => {
        const chat = document.getElementById('chat-messages');
        if (chat) {
            chat.scrollTop = chat.scrollHeight;
        }
    });
    // Remove typing user after debounce (3s)
    Livewire.on('remove-typing-user', ({ userId }) => {
        setTimeout(() => {
            Livewire.find(document.querySelector('[wire\:id]').getAttribute('wire:id')).call('removeTypingUser', userId);
        }, 3000);
    });
</script>
@endpush