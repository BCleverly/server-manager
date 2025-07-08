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
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class Chat extends Component
{
    public array $messages = [];
    public string $newMessage = '';

    public function mount(): void
    {
        $user = Auth::user();
        // Broadcast user joined event
        broadcast(new UserJoined([
            'id' => $user->id,
            'name' => $user->name,
            'initials' => $user->initials(),
        ]))->toOthers();
        $this->messages = [];
    }

    public function sendMessage(): void
    {
        $this->validate([
            'newMessage' => ['required', 'string', 'max:1000'],
        ]);

        $user = Auth::user();
        $message = [
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'initials' => $user->initials(),
            ],
            'content' => $this->newMessage,
            'timestamp' => now()->toISOString(),
            'type' => 'message',
        ];

        $this->messages[] = $message;
        broadcast(new MessageEvent($message))->toOthers();
        $this->newMessage = '';
    }

    #[On('echo:GlobalChat,.App\\Events\\Chat\\UserJoined')]
    public function userJoined($payload): void
    {
        $user = $payload['user'] ?? null;
        if ($user) {
            $this->messages[] = [
                'user' => $user,
                'content' => null,
                'timestamp' => now()->toISOString(),
                'type' => 'join',
            ];
        }
    }

    #[On('echo:GlobalChat,.App\\Events\\Chat\\MessageEvent')]
    public function receiveMessage($payload): void
    {
        $this->messages[] = $payload['message'];
    }

    public function render()
    {
        return view('livewire.chat');
    }
}
