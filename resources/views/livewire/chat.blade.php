<div class="max-w-2xl mx-auto p-6 flex flex-col h-[70vh]">
    <div class="flex-1 overflow-y-auto mb-4 bg-base-200 rounded-lg shadow-inner p-4 space-y-3" id="chat-messages">
        @forelse($messages as $message)
            @if(($message['type'] ?? 'message') === 'join')
                <div class="flex items-center justify-center my-2">
                    <span class="badge badge-info px-4 py-2 text-sm">
                        <span class="font-semibold">{{ $message['user']['name'] ?? 'Someone' }}</span> joined the chat
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
        >
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled" wire:target="sendMessage">
            <span wire:loading.remove wire:target="sendMessage">Send</span>
            <span wire:loading wire:target="sendMessage" class="loading loading-spinner loading-xs"></span>
        </button>
    </form>
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
</script>
@endpush