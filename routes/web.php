<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BoardController;
use App\Http\Controllers\OldBoardsController;
use App\Http\Controllers\CommissionController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\SponsorController;
use App\Http\Controllers\StatueController;

// Publieke routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/announcements', [AnnouncementController::class, 'publicIndex'])->name('public.announcements.index');
Route::get('/events', [EventController::class, 'index'])->name('user.events.index');
Route::get('/event/{id}', [EventController::class, 'show'])->name('user.event.show');

Route::get('/community', [EventController::class, 'community'])->name('user.community.index');
Route::get('/community/{id}', [EventController::class, 'show'])->name('user.community.show');

Route::get('/sponsors', [SponsorController::class, 'index'])->name('user.sponsors.index');

// Guest login/register
Route::middleware(['guest'])->group(function () {
    Route::get('/login', fn () => view('auth.login'))->name('login');
    Route::get('/register', fn () => view('auth.register'))->name('register');
});

// Admin routes
Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/', [AdminController::class, 'index'])->name('index');

    // Announcements
    Route::get('/announcements', [AnnouncementController::class, 'index'])->name('announcements.index');
    Route::prefix('announcement')->name('announcements.')->group(function () {
        Route::get('/create', [AnnouncementController::class, 'create'])->name('create');
        Route::post('/store', [AnnouncementController::class, 'store'])->name('store');
        Route::get('/{announcement}/edit', [AnnouncementController::class, 'edit'])->name('edit');
        Route::put('/update/{announcement}', [AnnouncementController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [AnnouncementController::class, 'delete'])->name('delete');
    });


    // Home images
    Route::put('/home-images/update', [HomeController::class, 'update'])->name('home-images.update');

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

    // Boards
    Route::get('/boards', [BoardController::class, 'index'])->name('board.index');
    Route::prefix('board')->name('board.')->group(function () {
        Route::get('/create', [BoardController::class, 'create'])->name('create');
        Route::post('/store', [BoardController::class, 'store'])->name('store');
        Route::get('/{id}', [BoardController::class, 'show'])->name('show');
        Route::put('/update/{id}', [BoardController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [BoardController::class, 'delete'])->name('delete');
    });

    // Old Boards
    Route::get('/old_boards', [OldBoardsController::class, 'index'])->name('old_boards.index');
    Route::prefix('old_boards')->name('old_boards.')->group(function () {
        Route::get('/create', [OldBoardsController::class, 'create'])->name('create');
        Route::post('/store', [OldBoardsController::class, 'store'])->name('store');
        Route::get('/{id}', [OldBoardsController::class, 'show'])->name('show');
        Route::put('/update/{id}', [OldBoardsController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [OldBoardsController::class, 'delete'])->name('delete');
    });

    // Commissions
    Route::get('/commissions', [CommissionController::class, 'index'])->name('commission.index');
    Route::prefix('commission')->name('commission.')->group(function () {
        Route::get('/create', [CommissionController::class, 'create'])->name('create');
        Route::post('/store', [CommissionController::class, 'store'])->name('store');
        Route::get('/{id}', [CommissionController::class, 'show'])->name('show');
        Route::put('/update/{id}', [CommissionController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [CommissionController::class, 'delete'])->name('delete');
    });
});
