<?php

declare(strict_types=1);

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class SiteForm extends Form
{
    #[Validate('required|string|max:255')]
    public string $name = '';

    #[Validate('required|string|max:255|unique:sites,domain')]
    public string $domain = '';

    #[Validate('required|string|max:255|alpha_dash')]
    public string $folder = '';

    #[Validate('required|in:8.1,8.2,8.3,8.4npm')]
    public string $php_version = '';

    #[Validate('nullable|string|max:255|url')]
    public ?string $repository = null;

    #[Validate('nullable|string|max:255')]
    public ?string $repository_branch = null;

    public array $phpVersions = ['8.1', '8.2', '8.3', '8.4npm'];
}
