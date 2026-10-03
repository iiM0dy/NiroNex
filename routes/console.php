<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('profit:add-to-users')->everyMinute()->withoutOverlapping();

Schedule::command('queue:work --stop-when-empty')->everyMinute();
