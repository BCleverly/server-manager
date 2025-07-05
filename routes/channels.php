<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

// Allow all authenticated users to access the chat channel
Broadcast::channel('chat', function ($user) {
    return auth()->check();
});
