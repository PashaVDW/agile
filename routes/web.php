<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BoardController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SponsorController;
use App\Http\Controllers\StatueController;
use App\Http\Controllers\OldBoardsController;
use App\Http\Controllers\CommissionController;
use Illuminate\Support\Facades\Route;

// Admin Routes
Route::middleware(['role:admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin');
});

Route::middleware(['role:admin'])->resource('announcements', AnnouncementController::class)->except('show');

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware(['role:admin'])->group(function () {
    Route::prefix('admin')->group(function () {
        Route::put('/home-images/update', [HomeController::class, 'update'])->name('admin.home-images.update');

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


        Route::get('/boards', [BoardController::class, 'index'])->name('admin.board.index');
        Route::prefix('/board')->group(function () {
            Route::get('/create', [BoardController::class, 'create'])->name('admin.board.create');
            Route::post('/store', [BoardController::class, 'store'])->name('admin.board.store');
            Route::get('/{id}', [BoardController::class, 'show'])->name('admin.board.show');
            Route::put('/update/{id}', [BoardController::class, 'update'])->name('admin.board.update');
            Route::delete('/delete/{id}', [BoardController::class, 'delete'])->name('admin.board.delete');
        });
        Route::get('/statues', [StatueController::class, 'index'])->name('admin.statues.index');

        Route::prefix('statue')->group(function () {
            Route::post('/store', [StatueController::class, 'store'])->name('admin.statue.store');
            Route::put('/update', [StatueController::class, 'update'])->name('admin.statue.update');

        });

        Route::get('/old_boards', [OldBoardsController::class, 'index'])->name('admin.old_boards.index');
        Route::prefix('/old_boards')->group(function () {
            Route::get('/create', [OldBoardsController::class, 'create'])->name('admin.old_boards.create');
            Route::post('/store', [OldBoardsController::class, 'store'])->name('admin.old_boards.store');
            Route::get('/{id}', [OldBoardsController::class, 'show'])->name('admin.old_boards.show');
            Route::put('/update/{id}', [OldBoardsController::class, 'update'])->name('admin.old_boards.update');
            Route::delete('/delete/{id}', [OldBoardsController::class, 'delete'])->name('admin.old_boards.delete');
        });

        Route::get('/commissions', [CommissionController::class, 'index'])->name('admin.commission.index');
        Route::prefix('/commission')->group(function () {
            Route::get('/create', [CommissionController::class, 'create'])->name('admin.commission.create');
            Route::post('/store', [CommissionController::class, 'store'])->name('admin.commission.store');
            Route::get('/{id}', [CommissionController::class, 'show'])->name('admin.commission.show');
            Route::put('/update/{id}', [CommissionController::class, 'update'])->name('admin.commission.update');
            Route::delete('/delete/{id}', [CommissionController::class, 'delete'])->name('admin.commission.delete');
        });
    });
});

Route::middleware(['guest'])->group(function () {
    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');
    Route::get('/register', function () {
        return view('auth.register');
    })->name('register');
});

Route::get('/events', [EventController::class, 'index'])->name('user.events.index');
Route::get('/event/{id}', [EventController::class, 'show'])->name('user.event.show');


Route::get('/sponsors', [SponsorController::class, 'index'])->name('user.sponsors.index');
