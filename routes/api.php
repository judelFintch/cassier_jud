<?php

use App\Http\Controllers\IncidentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/incidents-map', [IncidentController::class, 'getIncidentsForMap'])->middleware('auth:sanctum');
