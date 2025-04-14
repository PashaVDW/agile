<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\SponsorController;
use App\Http\Controllers\StatueController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/announcements', [AnnouncementController::class, 'publicIndex'])->name('public.announcements.index');
Route::get('/announcement/{id}', [AnnouncementController::class, 'show'])->name('user.announcement.show');

Route::get('/events', [EventController::class, 'index'])->name('user.events.index');
Route::get('/event/{id}', [EventController::class, 'show'])->name('user.event.show');

Route::get('/sponsors', [SponsorController::class, 'index'])->name('user.sponsors.index');

Route::middleware(['guest'])->group(function () {
    Route::get('/login', fn() => view('auth.login'))->name('login');
    Route::get('/register', fn() => view('auth.register'))->name('register');
});

// Admin routes
Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');

    Route::resource('announcements', AnnouncementController::class)->except(['show']);

    // Events
    Route::get('/events', [EventController::class, 'index'])->name('events.index');

    Route::prefix('event')->name('event.')->group(function () {
        Route::get('/create', [EventController::class, 'create'])->name('create');
        Route::post('/store', [EventController::class, 'store'])->name('store');
        Route::get('/{id}', [EventController::class, 'show'])->name('show');
        Route::put('/update/{id}', [EventController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [EventController::class, 'delete'])->name('delete');
    });

    // Sponsors
    Route::get('/sponsors', [SponsorController::class, 'index'])->name('sponsors.index');

    Route::prefix('sponsor')->name('sponsor.')->group(function () {
        Route::get('/create', [SponsorController::class, 'create'])->name('create');
        Route::post('/store', [SponsorController::class, 'store'])->name('store');
        Route::get('/{id}', [SponsorController::class, 'show'])->name('show');
        Route::put('/update/{id}', [SponsorController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [SponsorController::class, 'delete'])->name('delete');
    });

    // Statuten
    Route::get('/statues', [StatueController::class, 'index'])->name('statues.index');
    Route::post('/statue/store', [StatueController::class, 'store'])->name('statue.store');
    Route::put('/statue/update', [StatueController::class, 'update'])->name('statue.update');
});
