<?php

use App\Http\Controllers\DiscordAlertController;
use Illuminate\Support\Facades\Route;

// Discord Alert Routes
Route::prefix('discord-alerts')->group(function () {
    Route::get('/simple', [DiscordAlertController::class, 'sendSimpleAlert'])->name('discord.alerts.simple');
    Route::get('/formatted', [DiscordAlertController::class, 'sendFormattedAlert'])->name('discord.alerts.formatted');
    Route::post('/custom', [DiscordAlertController::class, 'sendCustomAlert'])->name('discord.alerts.custom');
}); 