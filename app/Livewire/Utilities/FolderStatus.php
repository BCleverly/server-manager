<?php

declare(strict_types=1);

namespace App\Livewire\Utilities;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Livewire\Component;

class FolderStatus extends Component
{
    public string $path;
    public bool $exists = false;
    public ?string $permissions = null;
    public ?string $owner = null;
    public ?string $group = null;
    public ?string $system = null;

    public function mount(): void
    {
        $this->path = Config::get('app.site_root_path');
        $this->system = strtoupper(substr(PHP_OS, 0, 3)) === 'WIN' ? 'Windows' : 'Unix';
        $this->checkFolder();
    }

    public function checkFolder(): void
    {
        if (File::exists($this->path)) {
            $this->exists = true;
            $this->permissions = $this->getPermissions($this->path);
            [$this->owner, $this->group] = $this->getOwnerAndGroup($this->path);
        } else {
            $this->exists = false;
            $this->permissions = null;
            $this->owner = null;
            $this->group = null;
        }
    }

    private function getPermissions(string $path): string
    {
        $perms = fileperms($path);
        if ($this->system === 'Windows') {
            return decoct($perms & 0777);
        }
        return substr(sprintf('%o', $perms), -4);
    }

    private function getOwnerAndGroup(string $path): array
    {
        if ($this->system === 'Windows') {
            return [get_current_user(), 'N/A'];
        }
        $owner = function_exists('posix_getpwuid') ? posix_getpwuid(fileowner($path))['name'] ?? 'Unknown' : 'Unknown';
        $group = function_exists('posix_getgrgid') ? posix_getgrgid(filegroup($path))['name'] ?? 'Unknown' : 'Unknown';
        return [$owner, $group];
    }

    public function render()
    {
        return view('livewire.utilities.folder-status');
    }
} 