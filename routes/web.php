<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DonationsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InviteController;
use App\Http\Controllers\TeamController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/teams/new', [TeamController::class, 'create'])->name('teams.create');
Route::post('/teams', [TeamController::class, 'store'])->name('teams.store');
Route::get('/teams/{team}', [TeamController::class, 'show'])->name('teams.show');
Route::post('/donations', [DonationsController::class, 'store'])->name('donations.store');
Route::get('/donations/return/{donation}', [DonationsController::class, 'handleReturn'])->name('donations.return');
Route::post('/donations/webhook', [DonationsController::class, 'webhook'])->name('donations.webhook');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');
Route::post('/dashboard/invites', [DashboardController::class, 'createInvite'])
    ->middleware(['auth', 'admin'])
    ->name('dashboard.invites');
Route::post('/dashboard/members', [DashboardController::class, 'addMember'])
    ->middleware(['auth', 'admin'])
    ->name('dashboard.members.add');
Route::delete('/dashboard/members/{member}', [DashboardController::class, 'removeMember'])
    ->middleware(['auth', 'admin'])
    ->name('dashboard.members.remove');
Route::put('/dashboard/team/goal', [DashboardController::class, 'updateGoal'])
    ->middleware(['auth', 'admin'])
    ->name('dashboard.team.goal');
Route::put('/dashboard/home-news-ticker', [DashboardController::class, 'updateHomeNewsTicker'])
    ->middleware(['auth', 'admin'])
    ->name('dashboard.home-news-ticker');
Route::put('/dashboard/showcase-media', [DashboardController::class, 'updateDashboardShowcaseMedia'])
    ->middleware(['auth', 'admin'])
    ->name('dashboard.showcase-media');

Route::get('/invite/{token}', [InviteController::class, 'show'])->name('invite.show');
Route::post('/invite/{token}', [InviteController::class, 'accept'])->name('invite.accept');
