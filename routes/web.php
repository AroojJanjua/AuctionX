<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\whole;

Route::get('/', function () {
    return view('welcome');
});
// === Home ===
Route::get('/home', [whole::class, 'Home'])->name('home');
// === categories ===
Route::view('/categories', 'categories');
Route::get('/categories', function () {
    return view('categories');
})->name('categories');