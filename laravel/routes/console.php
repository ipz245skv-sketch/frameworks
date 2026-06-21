<?php

use Illuminate\Foundation\Inspiring;
use App\Http\Controllers\PlaylistController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');
