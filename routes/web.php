<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');

    // Sites section
    Route::get('sites', \App\Livewire\Sites\Index::class)->name('sites.index');
    Route::get('sites/create', \App\Livewire\Sites\Create::class)->name('sites.create');
    Route::get('sites/{site}', \App\Livewire\Sites\Show::class)->name('sites.show');
    Route::get('sites/{site}/edit', \App\Livewire\Sites\Edit::class)->name('sites.edit');

    // Chat section
    Route::get('chat', \App\Livewire\Chat::class)->name('chat');
});

Route::passkeys();

require __DIR__.'/auth.php';
