<?php

declare(strict_types=1);

use App\Models\Site;
use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->site = Site::factory()->create([
        'user_id' => $this->user->id,
        'name' => 'Test Site',
        'domain' => 'test.com',
        'php_version' => '8.2',
        'folder' => '/var/www/test',
        'letsencrypt_https_enabled' => false,
        'repository' => null,
        'repository_branch' => null,
    ]);
});

test('users can view edit form for their own sites', function () {
    $response = $this->actingAs($this->user)
        ->get(route('sites.edit', $this->site));

    $response->assertOk();
    $response->assertSee('Edit Site');
    $response->assertSee('Test Site');
    $response->assertSee('test.com');
    $response->assertSee('8.2');
});

test('users cannot edit sites they do not own', function () {
    $otherUser = User::factory()->create();
    $otherSite = Site::factory()->create([
        'user_id' => $otherUser->id,
    ]);

    $response = $this->actingAs($this->user)
        ->get(route('sites.edit', $otherSite));

    $response->assertForbidden();
});

test('unauthenticated users cannot edit sites', function () {
    $response = $this->get(route('sites.edit', $this->site));

    $response->assertRedirect(route('login'));
});

test('users can update their own sites', function () {
    $this->actingAs($this->user)
        ->livewire(\App\Livewire\Sites\Edit::class, ['site' => $this->site])
        ->set('form.name', 'Updated Site')
        ->set('form.domain', 'updated.com')
        ->set('form.php_version', '8.3')
        ->set('form.folder', '/var/www/updated')
        ->set('form.repository', 'https://github.com/user/repo')
        ->set('form.repository_branch', 'main')
        ->set('form.letsencrypt_https_enabled', true)
        ->call('save')
        ->assertRedirect(route('sites.show', $this->site));
    
    $this->site->refresh();
    expect($this->site->name)->toBe('Updated Site');
    expect($this->site->domain)->toBe('updated.com');
    expect($this->site->php_version)->toBe('8.3');
    expect($this->site->folder)->toBe('/var/www/updated');
    expect($this->site->repository)->toBe('https://github.com/user/repo');
    expect($this->site->repository_branch)->toBe('main');
    expect($this->site->letsencrypt_https_enabled)->toBeTrue();
});

test('validation works for required fields', function () {
    $this->actingAs($this->user)
        ->livewire(\App\Livewire\Sites\Edit::class, ['site' => $this->site])
        ->set('form.name', '')
        ->set('form.domain', '')
        ->set('form.php_version', '')
        ->set('form.folder', '')
        ->call('save')
        ->assertHasErrors(['form.name', 'form.domain', 'form.php_version', 'form.folder']);
});

test('validation works for PHP version', function () {
    $this->actingAs($this->user)
        ->livewire(\App\Livewire\Sites\Edit::class, ['site' => $this->site])
        ->set('form.php_version', '7.4')
        ->call('save')
        ->assertHasErrors(['form.php_version']);
});

test('validation works for domain uniqueness', function () {
    $otherSite = Site::factory()->create([
        'user_id' => $this->user->id,
        'domain' => 'other.com',
    ]);

    $this->actingAs($this->user)
        ->livewire(\App\Livewire\Sites\Edit::class, ['site' => $this->site])
        ->set('form.domain', 'other.com') // Same as other site
        ->call('save')
        ->assertHasErrors(['form.domain']);
});

test('validation works for repository URL format', function () {
    $this->actingAs($this->user)
        ->livewire(\App\Livewire\Sites\Edit::class, ['site' => $this->site])
        ->set('form.repository', 'invalid-url')
        ->call('save')
        ->assertHasErrors(['form.repository']);
});

test('edit form displays current values', function () {
    $response = $this->actingAs($this->user)
        ->get(route('sites.edit', $this->site));

    $response->assertOk();
    $response->assertSee('value="Test Site"', false);
    $response->assertSee('value="test.com"', false);
    $response->assertSee('value="8.2"', false);
    $response->assertSee('value="/var/www/test"', false);
});

test('edit form has back to sites link', function () {
    $response = $this->actingAs($this->user)
        ->get(route('sites.edit', $this->site));

    $response->assertOk();
    $response->assertSee('Back to Sites');
    $response->assertSee(route('sites.index'));
}); 