<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::view('/why-magewire', 'why-magewire')->name('why-magewire');

Route::redirect('/features', '/features/compiler')->name('features.index');
Route::view('/features/compiler', 'features.compiler')->name('features.compiler');
Route::view('/features/fragments', 'features.fragments')->name('features.fragments');
