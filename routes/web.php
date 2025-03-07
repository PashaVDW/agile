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
        Route::get('/', [SponsorController::class, 'index'])->name('sponsors.index');
    });
    Route::prefix('/sponsor')->group(function () {
        Route::get('/create', [SponsorController::class, 'create'])->name('sponsor.create');
        Route::post('/store', [SponsorController::class, 'store'])->name('sponsor.store');

        Route::get('/{id}', [SponsorController::class, 'sponsor'])->name('sponsor.show');
        Route::put('/update/{id}', [SponsorController::class, 'update'])->name('sponsor.update');
        Route::delete('/delete/{id}', [SponsorController::class, 'delete'])->name('sponsor.delete');
    });
})->middleware('checkIfAdmin');
