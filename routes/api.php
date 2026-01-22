<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiTeamController;
use App\Http\Controllers\Api\DonationsController;
use App\Http\Controllers\Api\LightsController;
use App\Http\Controllers\Api\StatsController;

Route::get('/stats', [StatsController::class, 'index']);
Route::get('/teams', [ApiTeamController::class, 'index']);
Route::get('/teams/{team}/public', [ApiTeamController::class, 'showPublic']);
Route::get('/lights/{lightIndex}', [LightsController::class, 'show']);
Route::post('/donations', [DonationsController::class, 'store']);
