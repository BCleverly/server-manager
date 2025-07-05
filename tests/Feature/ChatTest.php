<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Livewire\Chat;
use App\Services\ReverbConnectivityService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ChatTest extends TestCase
{
    use RefreshDatabase;

    public function test_chat_component_displays_reverb_status(): void
    {
        // Mock the ReverbConnectivityService
        $this->mock(ReverbConnectivityService::class, function ($mock) {
            $mock->shouldReceive('getReverbStatus')
                ->once()
                ->andReturn([
                    'available' => true,
                    'message' => 'Reverb is connected and working properly',
                    'config' => [
                        'host' => 'localhost',
                        'port' => 8080,
                        'scheme' => 'http',
                        'driver' => 'reverb',
                    ]
                ]);
        });

        Livewire::test(Chat::class)
            ->assertSee('Reverb is connected and working properly')
            ->assertSee('Real-time Chat')
            ->assertDontSee('Reverb Connection Issue');
    }

    public function test_chat_component_displays_error_when_reverb_unavailable(): void
    {
        // Mock the ReverbConnectivityService to return unavailable status
        $this->mock(ReverbConnectivityService::class, function ($mock) {
            $mock->shouldReceive('getReverbStatus')
                ->once()
                ->andReturn([
                    'available' => false,
                    'message' => 'Reverb is currently not available. Real-time features may not work.',
                    'config' => [
                        'host' => 'localhost',
                        'port' => 8080,
                        'scheme' => 'http',
                        'driver' => 'reverb',
                    ]
                ]);
        });

        Livewire::test(Chat::class)
            ->assertSee('Reverb Connection Issue')
            ->assertSee('Reverb is currently not available')
            ->assertSee('Messages will only be visible to you until the connection is restored');
    }

    public function test_chat_sends_message_when_reverb_available(): void
    {
        // Mock the ReverbConnectivityService
        $this->mock(ReverbConnectivityService::class, function ($mock) {
            $mock->shouldReceive('getReverbStatus')
                ->once()
                ->andReturn([
                    'available' => true,
                    'message' => 'Reverb is connected and working properly',
                    'config' => []
                ]);
        });

        Livewire::test(Chat::class)
            ->set('message', 'Hello, world!')
            ->call('sendMessage')
            ->assertSet('message', '')
            ->assertSee('Hello, world!');
    }

    public function test_chat_sends_message_locally_when_reverb_unavailable(): void
    {
        // Mock the ReverbConnectivityService to return unavailable status
        $this->mock(ReverbConnectivityService::class, function ($mock) {
            $mock->shouldReceive('getReverbStatus')
                ->once()
                ->andReturn([
                    'available' => false,
                    'message' => 'Reverb is currently not available. Real-time features may not work.',
                    'config' => []
                ]);
        });

        Livewire::test(Chat::class)
            ->set('message', 'Hello, world!')
            ->call('sendMessage')
            ->assertSet('message', '')
            ->assertSee('Hello, world!');
    }
} 