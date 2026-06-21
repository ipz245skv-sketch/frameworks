<?php

use App\Http\Controllers\PlaylistController;
use Illuminate\Support\Facades\Route;

Route::apiResource('playlists', PlaylistController::class);