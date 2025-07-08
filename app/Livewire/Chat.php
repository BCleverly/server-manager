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

/**
 * @property array $activeUsers List of users currently in the chat
 * @property array $typingUsers List of users currently typing
 */
class Chat extends Component
{
    public array $messages = [];
    public string $newMessage = '';
    public array $activeUsers = [];
    public array $typingUsers = [];

    public function mount(): void
    {
        $user = Auth::user();
        $this->messages = [];
        $this->activeUsers = [
            [
                'id' => $user->id,
                'name' => $user->name,
                'initials' => $user->initials(),
            ]
        ];
        $this->typingUsers = [];
        // Only broadcast join if not already present (first load)
        // (No-op here, as on mount user is always new)
        broadcast(new UserJoined([
            'id' => $user->id,
            'name' => $user->name,
            'initials' => $user->initials(),
        ]))->toOthers();
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
        // Remove self from typing users (for local state)
        $this->typingUsers = array_values(array_filter($this->typingUsers, fn($u) => $u['id'] !== $user->id));
        // Broadcast that user stopped typing (for others)
        // Optionally, you could broadcast a UserStoppedTyping event here if you want instant removal for others
    }

    #[On('echo:GlobalChat,.App\\Events\\Chat\\UserJoined')]
    public function userJoined($payload): void
    {
        $user = $payload['user'] ?? null;
        if ($user) {
            // Add to active users if not already present
            if (!collect($this->activeUsers)->contains('id', $user['id'])) {
                $this->activeUsers[] = $user;
                $this->messages[] = [
                    'user' => $user,
                    'content' => null,
                    'timestamp' => now()->toISOString(),
                    'type' => 'join',
                ];
            }
        }
    }

    #[On('echo:GlobalChat,.App\\Events\\Chat\\MessageEvent')]
    public function receiveMessage($payload): void
    {
        $this->messages[] = $payload['message'];
    }

    public function userLeft(): void
    {
        $user = Auth::user();
        broadcast(new \App\Events\Chat\UserLeft([
            'id' => $user->id,
            'name' => $user->name,
            'initials' => $user->initials(),
        ]))->toOthers();
    }

    #[On('echo:GlobalChat,.App\\Events\\Chat\\UserLeft')]
    public function userLeftEvent($payload): void
    {
        $user = $payload['user'] ?? null;
        if ($user) {
            $this->messages[] = [
                'user' => $user,
                'content' => null,
                'timestamp' => now()->toISOString(),
                'type' => 'left',
            ];
            // Remove from active users
            $this->activeUsers = array_values(array_filter($this->activeUsers, fn($u) => $u['id'] !== $user['id']));
            // Remove from typing users
            $this->typingUsers = array_values(array_filter($this->typingUsers, fn($u) => $u['id'] !== $user['id']));
        }
    }

    // Typing indicator logic
    public function typingStart(): void
    {
        $user = Auth::user();
        broadcast(new \App\Events\Chat\UserTyping([
            'id' => $user->id,
            'name' => $user->name,
            'initials' => $user->initials(),
        ]))->toOthers();
    }

    #[On('echo:GlobalChat,.App\\Events\\Chat\\UserTyping')]
    public function userTyping($payload): void
    {
        $user = $payload['user'] ?? null;
        $currentUser = Auth::user();
        if ($user && $user['id'] !== $currentUser->id && !collect($this->typingUsers)->contains('id', $user['id'])) {
            $this->typingUsers[] = $user;
        }
        // Remove after 3 seconds (debounce)
        $this->dispatch('remove-typing-user', userId: $user['id']);
    }

    public function removeTypingUser($userId): void
    {
        $this->typingUsers = array_values(array_filter($this->typingUsers, fn($u) => $u['id'] !== $userId));
    }

    // Polling method to refresh active users
    public function refreshActiveUsers(): void
    {
        $user = Auth::user();
        // Only broadcast if not already present in active users
        if (!collect($this->activeUsers)->contains('id', $user->id)) {
            broadcast(new UserJoined([
                'id' => $user->id,
                'name' => $user->name,
                'initials' => $user->initials(),
            ]))->toOthers();
        }
    }

    public function render()
    {
        return view('livewire.chat');
    }
}
