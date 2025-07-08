<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Events\Chat\MessageEvent;
use App\Events\Chat\UserJoined;
use App\Services\ReverbConnectivityService;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Livewire\Attributes\On;
use Livewire\Component;

class Chat extends Component
{
    public string $message = '';
    public array $messages = [];
    public bool $reverbAvailable = true;
    public string $reverbStatusMessage = '';

    public function mount(ReverbConnectivityService $reverbService): void
    {
        // Check Reverb connectivity
        $status = $reverbService->getReverbStatus();
        $this->reverbAvailable = $status['available'];
        $this->reverbStatusMessage = $status['message'];

        // Initialize with some sample messages
        $this->messages = [
            ['user' => 'System', 'message' => 'Welcome to the chat!', 'timestamp' => now()->format('H:i')],
        ];

        // Broadcast user joined event
        $this->broadcastUserJoined();
    }

    public function broadcastUserJoined(): void
    {
        if ($this->reverbAvailable && auth()->check()) {
            $userData = [
                'user' => auth()->user()->name,
                'message' => auth()->user()->name . ' joined the chat',
                'timestamp' => now()->format('H:i'),
                'type' => 'join'
            ];

            broadcast(new UserJoined($userData));
        }
    }

    public function sendMessage(): void
    {

        if (empty(trim($this->message))) {
            return;
        }

        $messageData = [
            'user' => auth()->user()?->name ?? 'Anonymous',
            'message' => trim($this->message),
            'timestamp' => now()->format('H:i'),
            'type' => 'message'
        ];

        // Add message to local array
        $this->messages[] = $messageData;

        // Only broadcast if Reverb is available
        if ($this->reverbAvailable) {
            broadcast(new MessageEvent($messageData));
        }

        // Clear the input
        $this->message = '';
    }

    #[On('echo:chat-MessageEvent')]
    public function handleNewMessage($event): void
    {
        dd($event);
        $this->messages[] = $event['message'];
    }

    #[On('echo:chat-UserJoined')]
    public function handleUserJoined($event): void
    {
        dd($event);
        $this->messages[] = $event['user'];
    }

    public function render()
    {
        return view('livewire.chat');
    }
}
