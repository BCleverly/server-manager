<?php

declare(strict_types=1);

namespace App\Livewire\Sites;

use App\Models\Site;
use Livewire\Component;

class Row extends Component
{
    public Site $site;
    public bool $confirmingDelete = false;

    public function mount(Site $site): void
    {
        $this->site = $site;
    }

    public function delete(): void
    {
        $this->authorize('delete', $this->site);
        $this->site->delete();
        $this->dispatch('siteDeleted', id: $this->site->id);
    }

    public function toggleHttps(): void
    {
        $this->authorize('update', $this->site);
        $this->site->letsencrypt_https_enabled = !$this->site->letsencrypt_https_enabled;
        $this->site->save();
        $this->dispatch('httpsToggled', id: $this->site->id, enabled: $this->site->letsencrypt_https_enabled);
    }

    public function render()
    {
        return view('livewire.sites.row');
    }
} 