<?php

declare(strict_types=1);

namespace App\Livewire\Sites;

use App\Livewire\Forms\SiteForm;
use App\Models\Site;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Component;

class Create extends Component
{
    public SiteForm $form;

    public array $phpVersions = ['8.1', '8.2', '8.3', '8.4'];

    public function updatedFormDomain($value)
    {
        if (! $this->form->folder) {
            $this->form->folder = Str::slug(Str::before($value, '.'));
        }
    }

    public function createSite()
    {
        $this->validate();
        Site::create([
            'user_id' => Auth::id(),
            'name' => $this->form->name,
            'domain' => $this->form->domain,
            'folder' => $this->form->folder,
            'php_version' => $this->form->php_version,
            'repository' => $this->form->repository,
            'repository_branch' => $this->form->repository_branch,
        ]);
        session()->flash('success', __('Site created successfully.'));

        return redirect()->route('sites.index');
    }

    public function render()
    {
        return view('livewire.sites.create');
    }
}
