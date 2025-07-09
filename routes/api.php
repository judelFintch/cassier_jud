<?php

use App\Http\Controllers\IncidentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/incidents-map', [IncidentController::class, 'getIncidentsForMap'])->middleware('auth:sanctum');
Route::get('/stats/incidents-by-type', [IncidentController::class, 'getStatsByType'])->middleware('auth:sanctum');
Route::get('/stats/incidents-by-day', [IncidentController::class, 'getStatsByDay'])->middleware('auth:sanctum');
