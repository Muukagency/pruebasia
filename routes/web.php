<?php

use App\Http\Controllers\AdvisorDashboardController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\WebhookController;
use App\Http\Controllers\WorkingHourController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LandingController::class, 'index'])->name('landing');
Route::post('/reservar', [LandingController::class, 'book'])->name('landing.book');

Route::post('/webhooks/meta', [WebhookController::class, 'meta']);
Route::post('/webhooks/google', [WebhookController::class, 'google']);
Route::post('/webhooks/payments', [PaymentController::class, 'webhook']);

Route::middleware(['web'])->group(function () {
    Route::resource('clients', ClientController::class);
    Route::resource('services', ServiceController::class);
    Route::resource('appointments', AppointmentController::class)->only(['index', 'create', 'store']);
    Route::get('/horarios', [WorkingHourController::class, 'index'])->name('working-hours.index');
    Route::post('/horarios', [WorkingHourController::class, 'store'])->name('working-hours.store');
    Route::get('/advisors/dashboard', [AdvisorDashboardController::class, 'index'])->name('advisor.dashboard');
});
