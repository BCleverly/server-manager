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
        'letsencrypt_https_enabled' => true,
        'repository' => null,
        'repository_branch' => null,
    ]);
});

test('users can view their own sites', function () {
    $response = $this->actingAs($this->user)
        ->get(route('sites.show', $this->site));

    $response->assertOk();
    $response->assertSee('Test Site');
    $response->assertSee('test.com');
    $response->assertSee('8.2');
    $response->assertSee('Enabled');
});

test('users cannot view sites they do not own', function () {
    $otherUser = User::factory()->create();
    $otherSite = Site::factory()->create([
        'user_id' => $otherUser->id,
    ]);

    $response = $this->actingAs($this->user)
        ->get(route('sites.show', $otherSite));

    $response->assertForbidden();
});

test('unauthenticated users cannot view sites', function () {
    $response = $this->get(route('sites.show', $this->site));

    $response->assertRedirect(route('login'));
});

test('show page displays site information correctly', function () {
    $response = $this->actingAs($this->user)
        ->get(route('sites.show', $this->site));

    $response->assertOk();
    $response->assertSee('Basic Information');
    $response->assertSee('HTTPS Configuration');
    $response->assertSee('Edit Site');
    $response->assertSee('Back to Sites');
});

test('show page displays repository information when available', function () {
    $siteWithRepo = Site::factory()->withRepository()->create([
        'user_id' => $this->user->id,
        'repository' => 'https://github.com/user/repo',
        'repository_branch' => 'main',
    ]);

    $response = $this->actingAs($this->user)
        ->get(route('sites.show', $siteWithRepo));

    $response->assertOk();
    $response->assertSee('Repository URL');
    $response->assertSee('https://github.com/user/repo');
    $response->assertSee('main');
});

test('show page does not display repository section when not available', function () {
    $response = $this->actingAs($this->user)
        ->get(route('sites.show', $this->site));

        // dd($this->site->repository);

    $response->assertOk();
    // Check that the repository section is not displayed in the site content
    // (not in the navigation which contains "Repository" links)
    $response->assertDontSee('Repository URL');
    $response->assertDontSee('Branch');
}); 