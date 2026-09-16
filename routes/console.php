<?php

use App\Models\Profile;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('portfolio:install', function (): int {
    if (Profile::query()->exists()) {
        $this->info('Portfolio data already exists; seeding skipped.');

        return self::SUCCESS;
    }

    $this->call('db:seed', ['--force' => true]);

    return self::SUCCESS;
})->purpose('Seed the initial portfolio only when the database is empty');
