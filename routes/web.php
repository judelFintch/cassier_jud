<?php

use App\Http\Controllers\IncidentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::resource('incidents', IncidentController::class);

    Route::get('/map', function() {
        return view('map.index');
    })->name('map.index');
});
