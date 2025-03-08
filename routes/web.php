<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

// Admin Routes
// TODO: Middleware must be changed to admin.
Route::controller(AdminController::class)->group(function () {
    Route::get('/admin', 'index');
})->name('admin');

Route::get('/', [HomeController::class, 'index'])->name('home');
