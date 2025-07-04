<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Livewire\Livewire;
use App\Livewire\Utilities\FolderStatus;

it('displays folder status for an existing directory', function () {
    $tempDir = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'test-folder-status';
    if (!File::exists($tempDir)) {
        File::makeDirectory($tempDir);
    }
    Config::set('app.site_root_path', $tempDir);

    Livewire::test(FolderStatus::class)
        ->assertSee($tempDir)
        ->assertSee('Yes')
        ->assertSee('Permissions')
        ->assertSee('Owner')
        ->assertSee('Group');

    File::deleteDirectory($tempDir);
});

it('displays folder status for a non-existing directory', function () {
    $nonExistent = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'does-not-exist-folder-status';
    if (File::exists($nonExistent)) {
        File::deleteDirectory($nonExistent);
    }
    Config::set('app.site_root_path', $nonExistent);

    Livewire::test(FolderStatus::class)
        ->assertSee($nonExistent)
        ->assertSee('No');
}); 