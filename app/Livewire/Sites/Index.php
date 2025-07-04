<?php

declare(strict_types=1);

namespace App\Livewire\Sites;

use App\Models\Site;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public function render()
    {
        $sites = Site::orderByDesc('created_at')->paginate(10);

        return view('livewire.sites.index', [
            'sites' => $sites,
        ]);
    }
}
