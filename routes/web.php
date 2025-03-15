<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\SponsorController;
use Illuminate\Support\Facades\Route;

// Admin Routes
// TODO: Middleware must be changed to admin.
Route::controller(AdminController::class)->group(function () {
    Route::get('/admin', 'index');
})->name('admin');

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::group(['prefix' => 'admin'], function () {
    Route::get('/events', [EventController::class, 'index'])->name('admin.events.index');
    Route::prefix('/event')->group(function () {
        Route::get('/create', [EventController::class, 'create'])->name('admin.event.create');
        Route::post('/store', [EventController::class, 'store'])->name('admin.event.store');

        Route::get('/{id}', [EventController::class, 'show'])->name('admin.event.show');
        Route::put('/update/{id}', [EventController::class, 'update'])->name('admin.event.update');
        Route::delete('/delete/{id}', [EventController::class, 'delete'])->name('admin.event.delete');
    });

    Route::get('/sponsors', [SponsorController::class, 'index'])->name('admin.sponsors.index');
    Route::prefix('/sponsor')->group(function () {
        Route::get('/create', [SponsorController::class, 'create'])->name('admin.sponsor.create');
        Route::post('/store', [SponsorController::class, 'store'])->name('admin.sponsor.store');

        Route::get('/{id}', [SponsorController::class, 'show'])->name('admin.sponsor.show');
        Route::put('/update/{id}', [SponsorController::class, 'update'])->name('admin.sponsor.update');
        Route::delete('/delete/{id}', [SponsorController::class, 'delete'])->name('admin.sponsor.delete');
    });
});

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::get('/events', [EventController::class, 'index'])->name('user.events.index');
Route::get('/event/{id}', [EventController::class, 'show'])->name('user.event.show');
