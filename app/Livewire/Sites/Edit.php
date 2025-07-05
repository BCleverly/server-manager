<?php

declare(strict_types=1);

namespace App\Livewire\Sites;

use App\Livewire\Forms\SiteForm;
use App\Models\Site;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Str;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Edit extends Component
{
    use AuthorizesRequests;

    public SiteForm $form;
    
    public int $siteId;

    public function mount(Site $site): void
    {
        $this->authorize('update', $site);
        $this->siteId = $site->id;
        
        $this->form->name = $site->name;
        $this->form->domain = $site->domain;
        $this->form->php_version = $site->php_version;
        $this->form->repository = $site->repository;
        $this->form->repository_branch = $site->repository_branch;
        $this->form->folder = $site->folder;
        $this->form->letsencrypt_https_enabled = $site->letsencrypt_https_enabled;
    }

    #[Computed]
    public function site(): Site
    {
        return Site::findOrFail($this->siteId);
    }

    #[Computed]
    public function siteId(): int
    {
        return $this->siteId;
    }

    #[Computed]
    public function siteName(): string
    {
        return $this->site->name;
    }

    #[Computed]
    public function siteDomain(): string
    {
        return $this->site->domain;
    }

    public function updatedFormDomain($value)
    {
        if (! $this->form->folder) {
            $this->form->folder = Str::slug(Str::before($value, '.'));
        }
    }

    public function updateSite()
    {
        $this->validate($this->form->rulesForUpdate($this->siteId));
        
        $this->site->update([
            'name' => $this->form->name,
            'domain' => $this->form->domain,
            'php_version' => $this->form->php_version,
            'repository' => $this->form->repository,
            'repository_branch' => $this->form->repository_branch,
            'folder' => $this->form->folder,
            'letsencrypt_https_enabled' => $this->form->letsencrypt_https_enabled,
        ]);

        session()->flash('success', __('Site updated successfully.'));

        return redirect()->route('sites.show', $this->site);
    }

    public function save(): void
    {
        $this->updateSite();
    }

    public function render()
    {
        return view('livewire.sites.edit');
    }
} 