<?php

declare(strict_types=1);

namespace App\Livewire\Utilities;

use Livewire\Component;
use App\Services\ServerStatsService;

class ServerStats extends Component
{
    public array $stats = [
        'cpu' => null,
        'memory' => null,
        'load' => null,
        'updated_at' => null,
    ];

    protected $listeners = [
        'server-stats-updated' => 'updateStats',
    ];

    public function mount(ServerStatsService $service): void
    {
        $this->stats = $service->getStats();
    }

    public function updateStats(array $stats): void
    {
        $this->stats = $stats;
    }

    public function render()
    {
        return view('livewire.utilities.server-stats');
    }
} 