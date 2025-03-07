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

Route::group(['prefix' => 'admin'], function () {
    Route::prefix('/sponsors')->group(function () {
        Route::get('/', [SponsorController::class, 'index'])->name('admin.sponsors.index');
    });
    Route::prefix('/sponsor')->group(function () {
        Route::get('/create', [SponsorController::class, 'create'])->name('admin.sponsor.create');
        Route::post('/store', [SponsorController::class, 'store'])->name('admin.sponsor.store');

        Route::get('/{id}', [SponsorController::class, 'show'])->name('admin.sponsor.show');
        Route::put('/update/{id}', [SponsorController::class, 'update'])->name('admin.sponsor.update');
        Route::delete('/delete/{id}', [SponsorController::class, 'delete'])->name('admin.sponsor.delete');
    });
});
