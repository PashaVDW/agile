<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

// Admin Routes
Route::controller(AdminController::class)->name('admin')->group(function () {
    Route::get('/admin', 'index');
});

Route::get('/', function () {
    return view('home');
})->name('home');
