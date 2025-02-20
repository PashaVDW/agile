<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/Evenementen', function () {
    return view('Evenementen');
})->name('Evenementen');

Route::get('/Inloggen', function () {
    return view('Inloggen');
})->name('Inloggen');
