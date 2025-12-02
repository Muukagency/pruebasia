<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebhookController;

Route::post('/meta/webhook', [WebhookController::class, 'meta']);
Route::post('/google/webhook', [WebhookController::class, 'google']);
