<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('shows the sites index page for authenticated users', function () {
    $user = User::factory()->create();
    $this->actingAs($user)
        ->get(route('sites.index'))
        ->assertOk()
        ->assertSee('Sites');
});
