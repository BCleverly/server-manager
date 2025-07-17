<?php

declare(strict_types=1);

use App\Livewire\Sites\Row;
use App\Models\Site;
use App\Models\User;

it('renders a site row with correct data', function () {
    $user = User::factory()->create();
    $site = Site::factory()->create([
        'user_id' => $user->id,
        'name' => 'Row Test Site',
        'domain' => 'rowtest.com',
        'php_version' => '8.3',
        'folder' => '/var/www/rowtest',
        'letsencrypt_https_enabled' => true,
    ]);

    $this->actingAs($user)
        ->livewire(Row::class, ['site' => $site])
        ->assertSee('Row Test Site')
        ->assertSee('rowtest.com')
        ->assertSee('8.3')
        ->assertSee('Enabled')
        ->assertSee('/var/www/rowtest');
});

it('can toggle HTTPS status', function () {
    $user = User::factory()->create();
    $site = Site::factory()->create([
        'user_id' => $user->id,
        'letsencrypt_https_enabled' => false,
    ]);

    $this->actingAs($user)
        ->livewire(Row::class, ['site' => $site])
        ->call('toggleHttps')
        ->assertSet('site.letsencrypt_https_enabled', true);

    $site->refresh();
    expect($site->letsencrypt_https_enabled)->toBeTrue();
});

it('can delete a site', function () {
    $user = User::factory()->create();
    $site = Site::factory()->create([
        'user_id' => $user->id,
    ]);

    $this->actingAs($user)
        ->livewire(Row::class, ['site' => $site])
        ->set('confirmingDelete', true)
        ->call('delete');

    expect(Site::find($site->id))->toBeNull();
}); 