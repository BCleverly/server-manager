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

    public function updatedFormDomain($value)
    {
        if (! $this->form->folder) {
            $this->form->folder = Str::slug(Str::before($value, '.'));
        }
    }

    public function updatedFormFolder($value)
    {
        if (! $this->form->domain) {
            $this->form->domain = $value . '.com';
        }
    }

    public function createSite()
    {
        $this->validate();
        
        $site = auth()->user()->sites()->create(
            $this->form->all()
        );
        
        session()->flash('success', __('Site created successfully.'));

        return redirect()->route('sites.show', $site);
    }

    public function render()
    {
        return view('livewire.sites.create');
    }
}
