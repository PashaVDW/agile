<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SponsorController;
use App\Http\Controllers\StatueController;
use Illuminate\Support\Facades\Route;

// Admin home (route name: admin.index)
Route::middleware(['role:admin'])->get('/admin', [AdminController::class, 'index'])->name('admin.index');

// Admin panel routes
Route::middleware(['role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        // Announcements
        Route::get('/announcements', [AnnouncementController::class, 'index'])->name('announcements.index');
        Route::get('/announcements/create', [AnnouncementController::class, 'create'])->name('announcements.create');
        Route::post('/announcements', [AnnouncementController::class, 'store'])->name('announcements.store');
        Route::get('/announcements/{announcement}/edit', [AnnouncementController::class, 'edit'])->name('announcements.edit');
        Route::put('/announcements/{announcement}', [AnnouncementController::class, 'update'])->name('announcements.update');
        Route::delete('/announcements/{announcement}', [AnnouncementController::class, 'destroy'])->name('announcements.destroy');

        // Events
        Route::get('/events', [EventController::class, 'index'])->name('events.index');
        Route::get('/event/create', [EventController::class, 'create'])->name('event.create');
        Route::post('/event/store', [EventController::class, 'store'])->name('event.store');
        Route::get('/event/{id}', [EventController::class, 'show'])->name('event.show');
        Route::put('/event/update/{id}', [EventController::class, 'update'])->name('event.update');
        Route::delete('/event/delete/{id}', [EventController::class, 'delete'])->name('event.delete');

        // Sponsors
        Route::get('/sponsors', [SponsorController::class, 'index'])->name('sponsors.index');
        Route::get('/sponsor/create', [SponsorController::class, 'create'])->name('sponsor.create');
        Route::post('/sponsor/store', [SponsorController::class, 'store'])->name('sponsor.store');
        Route::get('/sponsor/{id}', [SponsorController::class, 'show'])->name('sponsor.show');
        Route::put('/sponsor/update/{id}', [SponsorController::class, 'update'])->name('sponsor.update');
        Route::delete('/sponsor/delete/{id}', [SponsorController::class, 'delete'])->name('sponsor.delete');

        // Statues
        Route::get('/statues', [StatueController::class, 'index'])->name('statues.index');
        Route::post('/statue/store', [StatueController::class, 'store'])->name('statue.store');
        Route::put('/statue/update', [StatueController::class, 'update'])->name('statue.update');
    });

// Guest Auth Routes
Route::middleware(['guest'])->group(function () {
    Route::get('/login', fn() => view('auth.login'))->name('login');
    Route::get('/register', fn() => view('auth.register'))->name('register');
});

// Home
Route::get('/', [HomeController::class, 'index'])->name('home');

// Public Events and Sponsors
Route::get('/events', [EventController::class, 'index'])->name('user.events.index');
Route::get('/event', [EventController::class, 'show'])->name('user.event.show');
Route::get('/sponsors', [SponsorController::class, 'index'])->name('user.sponsors.index');

// Public Announcements
Route::get('/announcements', [HomeController::class, 'announcements'])->name('public.announcements.index');
