<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\SponsorController;
use Illuminate\Support\Facades\Route;

// Admin Routes
// TODO: Middleware must be changed to admin.
Route::controller(AdminController::class)->group(function () {
    Route::get('/admin', 'index');
})->name('admin');

Route::get('/', function () {
    return view('home');
})->name('home');

Route::resource('sponsors', SponsorController::class);
