<?php

declare(strict_types=1);

use App\Models\Site;
use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();
});

it('shows the sites index page for authenticated users', function () {
    $this->actingAs($this->user)
        ->get(route('sites.index'))
        ->assertOk()
        ->assertSee('Sites');
});

it('shows create new site CTA button', function () {
    $this->actingAs($this->user)
        ->get(route('sites.index'))
        ->assertOk()
        ->assertSee('Create New Site')
        ->assertSee(route('sites.create'));
});

it('shows sites table with action buttons when sites exist', function () {
    $site = Site::factory()->create([
        'user_id' => $this->user->id,
        'name' => 'Test Site',
        'domain' => 'test.com',
        'php_version' => '8.2',
    ]);

    $this->actingAs($this->user)
        ->get(route('sites.index'))
        ->assertOk()
        ->assertSee('Test Site')
        ->assertSee('test.com')
        ->assertSee('8.2')
        ->assertSee('View')
        ->assertSee('Edit')
        ->assertSee(route('sites.show', $site))
        ->assertSee(route('sites.edit', $site));
});

it('shows empty state when no sites exist', function () {
    $this->actingAs($this->user)
        ->get(route('sites.index'))
        ->assertOk()
        ->assertSee('No sites found')
        ->assertSee('Get started by creating your first site.')
        ->assertSee('Create a new site now')
        ->assertSee(route('sites.create'));
});

it('shows HTTPS status correctly', function () {
    $siteWithHttps = Site::factory()->create([
        'user_id' => $this->user->id,
        'letsencrypt_https_enabled' => true,
    ]);

    $siteWithoutHttps = Site::factory()->create([
        'user_id' => $this->user->id,
        'letsencrypt_https_enabled' => false,
    ]);

    $response = $this->actingAs($this->user)
        ->get(route('sites.index'));

    $response->assertOk();
    $response->assertSee('Enabled');
    $response->assertSee('Disabled');
});

it('shows PHP version as badge', function () {
    $site = Site::factory()->create([
        'user_id' => $this->user->id,
        'php_version' => '8.3',
    ]);

    $this->actingAs($this->user)
        ->get(route('sites.index'))
        ->assertOk()
        ->assertSee('8.3');
});

it('redirects unauthenticated users to login', function () {
    $this->get(route('sites.index'))
        ->assertRedirect(route('login'));
});
