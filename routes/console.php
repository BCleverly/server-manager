<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Services\ServerStatsService;
use App\Events\ServerStatsUpdated;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('server:stats:broadcast', function (ServerStatsService $service) {
    $stats = $service->getStats();
    event(new ServerStatsUpdated($stats));
    $this->info('Server stats broadcasted.');
})->purpose('Broadcast server performance statistics');
