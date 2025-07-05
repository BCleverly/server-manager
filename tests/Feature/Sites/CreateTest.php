<?php

declare(strict_types=1);

use App\Models\User;

it('shows the sites create page for authenticated users', function () {
    $user = User::factory()->create();
    $this->actingAs($user)
        ->get(route('sites.create'))
        ->assertOk()
        ->assertSee('Create Site');
});
