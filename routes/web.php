<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\EventController;
use Illuminate\Support\Facades\Route;

// Admin Routes
// TODO: Middleware must be changed to admin.
Route::controller(AdminController::class)->group(function () {
    Route::get('/admin', 'index');
})->name('admin');

Route::get('/', function () {
    return view('home');
})->name('home');

Route::group(['prefix' => 'admin'], function () {
    Route::prefix('/events')->group(function () {
        Route::get('/', [EventController::class, 'index'])->name('events.index');
    });
    Route::prefix('/event')->group(function () {
        Route::get('/create', [EventController::class, 'create'])->name('event.create');
        Route::post('/store', [EventController::class, 'store'])->name('event.store');

        Route::get('/{id}', [EventController::class, 'event'])->name('event.show');
        Route::put('/update/{id}', [EventController::class, 'update'])->name('event.update');
        Route::delete('/delete/{id}', [EventController::class, 'delete'])->name('event.delete');
    });
})->middleware('checkIfAdmin');
