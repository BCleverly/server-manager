<?php

declare(strict_types=1);

namespace App\Livewire\Sites;

use App\Models\Site;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Show extends Component
{
    use AuthorizesRequests;

    public int $siteId;

    public function mount(Site $site): void
    {
        $this->authorize('view', $site);
        $this->siteId = $site->id;
    }

    #[Computed]
    public function site(): Site
    {
        return Site::findOrFail($this->siteId);
    }

    #[Computed]
    public function hasRepository(): bool
    {
        return !empty($this->site->repository);
    }

    #[Computed]
    public function hasDeployments(): bool
    {
        return $this->site->deployments->count() > 0;
    }

    #[Computed]
    public function isHttpsEnabled(): bool
    {
        return $this->site->letsencrypt_https_enabled;
    }

    public function render()
    {
        return view('livewire.sites.show');
    }
} 