<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AuctionController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\ProfileController;

//    1. PUBLIC ROUTES(guests + loggin users)
// Home
Route::get('/', [HomeController::class, 'index'])->name('home');
// Static pages
Route::get('/how-it-works', [HomeController::class, 'howItWorks'])->name('how-it-works');
Route::get('/about',   [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::get('/privacy', [HomeController::class, 'privacy'])->name('privacy');
Route::get('/terms',   [HomeController::class, 'terms'])->name('terms');
Route::get('/support', [HomeController::class, 'support'])->name('support');

Route::prefix('auctions')->name('auctions.')->group(function (){
    Route::get('/',        [AuctionController::class, 'index'])->name('index');  
    Route::get('/{id}',    [AuctionController::class, 'show'])->name('show');   
});


Route::middleware('guest')->group(function(){
    // Login
    Route::get('/login',   [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login',  [LoginController::class, 'login']);
    // Register
    Route::get('/register',  [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);

});


Route::middleware('auth')->group(function(){
    // Profile
    Route::get('/profile',        [ProfileController::class, 'show'])->name('profile');
    Route::get('/profile/edit',   [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile',        [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password',[ProfileController::class, 'updatePassword'])->name('profile.password');
});


Route::middleware(['auth','role:seller,admin'])->prefix('seller')->name('seller.')
    ->group(function (){
    // Dashboard
    Route::get('/',               [SellerController::class, 'dashboard'])->name('dashboard');
    // Listings CRUD
    Route::get('/create',         [SellerController::class, 'create'])->name('create');
    Route::post('/',              [SellerController::class, 'store'])->name('store');
    Route::get('/{id}/edit',      [SellerController::class, 'edit'])->name('edit');
    Route::put('/{id}',           [SellerController::class, 'update'])->name('update');
    Route::delete('/{id}',        [SellerController::class, 'destroy'])->name('destroy');
    // Listing analytics
    Route::get('/{id}/bids',      [SellerController::class, 'bids'])->name('bids');  
});
