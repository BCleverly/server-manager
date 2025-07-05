<?php

declare(strict_types=1);

namespace App\Livewire\Forms;

use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class SiteForm extends Form
{
    public string $name = '';

    public string $domain = '';

    public string $folder = '';

    public string $php_version = '';

    public ?string $repository = null;

    public ?string $repository_branch = null;

    public bool $letsencrypt_https_enabled = false;

    public array $phpVersions = ['8.1', '8.2', '8.3', '8.4'];

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'domain' => [
                'required',
                'string',
                'max:255',
                Rule::unique('sites')->ignore($siteId ?? null),
            ],
            'folder' => 'required|string|max:255|alpha_dash',
            'php_version' => 'required|in:8.1,8.2,8.3,8.4',
            'repository' => 'nullable|string|max:255|url',
            'repository_branch' => 'nullable|string|max:255',
            'letsencrypt_https_enabled' => 'boolean',
        ];
    }

  
}
