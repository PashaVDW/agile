<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Middleware\RoleMiddleware;

// Admin Routes
Route::middleware(RoleMiddleware::class . ':admin')->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin');
});

Route::get('/', function () {
    return view('home');
})->name('home');
