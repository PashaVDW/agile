<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\EventController;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Middleware\RoleMiddleware;

// Admin Routes
Route::middleware(RoleMiddleware::class.':admin')->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin');
});

Route::get('/', function () {
    return view('home');
})->name('home');

Route::group(['prefix' => 'admin'], function () {
    Route::get('/events', [EventController::class, 'index'])->name('admin.events.index');
    Route::prefix('/event')->group(function () {
        Route::get('/create', [EventController::class, 'create'])->name('admin.event.create');
        Route::post('/store', [EventController::class, 'store'])->name('admin.event.store');

        Route::get('/{id}', [EventController::class, 'show'])->name('admin.event.show');
        Route::put('/update/{id}', [EventController::class, 'update'])->name('admin.event.update');
        Route::delete('/delete/{id}', [EventController::class, 'delete'])->name('admin.event.delete');
    });
});

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::get('/events', [EventController::class, 'index'])->name('user.events.index');
Route::get('/event/{id}', [EventController::class, 'show'])->name('user.event.show');
