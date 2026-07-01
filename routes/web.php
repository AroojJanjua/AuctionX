<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Broadcast;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AuctionController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BidController;
use App\Http\Controllers\AdminController;


Broadcast::routes(['middleware' => ['auth']]);

// Home
Route::get('/',               [HomeController::class, 'index'])->name('home');
Route::get('/home/live-data', [HomeController::class, 'homeLiveData'])->name('home.live-data');
// Static pages  
Route::get('/how-it-works',   [HomeController::class, 'howItWorks'])->name('how-it-works');
Route::get('/about',          [HomeController::class, 'about'])->name('about');
Route::get('/contact',        [HomeController::class, 'contact'])->name('contact');
Route::get('/privacy',        [HomeController::class, 'privacy'])->name('privacy');
Route::get('/terms',          [HomeController::class, 'terms'])->name('terms');
Route::get('/support',        [HomeController::class, 'support'])->name('support');


Route::prefix('auctions')->name('auctions.')->group(function(){
    Route::get('/',                 [AuctionController::class, 'index'])->name('index');  
    Route::get('/{id}',             [AuctionController::class, 'show'])->name('show');   
    Route::get('/{id}/live-data',   [AuctionController::class, 'liveData'])->name('live-data');
});

Route::middleware('guest')->group(function(){
    // Login
    Route::get('/login',      [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login',     [LoginController::class, 'login']);
    // Register
    Route::get('/register',   [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register',  [RegisterController::class, 'register']);

});

Route::middleware('auth')->group(function(){
    // Logout 
    Route::post('/logout',          [LoginController::class, 'logout'])->name('logout');
    // Profile
    Route::get('/profile',          [ProfileController::class, 'show'])->name('profile');
    Route::get('/profile/edit',     [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile',          [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    // My Bids
    Route::get('/my-bids',          [BidController::class, 'myBids'])->name('my-bids');

});

Route::middleware(['auth', 'role:bidder,seller,admin'])->group(function(){
    Route::post('/auctions/{auction}/bid',[BidController::class, 'store'])->name('auctions.bid');
});

Route::middleware(['auth','role:seller,admin'])->prefix('seller')->name('seller.')
    ->group(function (){
    // Dashboard
    Route::get('/',                [SellerController::class, 'dashboard'])->name('dashboard');
    // Listings CRUD 
    Route::get('/create',          [SellerController::class, 'create'])->name('create');
    Route::post('/',               [SellerController::class, 'store'])->name('store');
    Route::get('/{id}/edit',       [SellerController::class, 'edit'])->name('edit');
    Route::put('/{id}',            [SellerController::class, 'update'])->name('update');
    Route::delete('/{id}',         [SellerController::class, 'destroy'])->name('destroy');
    // Listing analytics 
    Route::get('/{id}/bids',       [SellerController::class, 'bids'])->name('bids');  
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function(){
    // Dashboard
    Route::get('/',                  [AdminController::class, 'dashboard'])->name('dashboard');
    // Reports
    Route::get('/reports',           [AdminController::class, 'reports'])->name('reports');
    // manage auctions
    Route::prefix('auctions')->name('auctions.')->group(function () {
        Route::get('/',              [AdminController::class, 'auctions'])->name('index');
        Route::put('/{id}/approve',  [AdminController::class, 'approveAuction'])->name('approve');
        Route::put('/{id}/close',    [AdminController::class, 'closeAuction'])->name('close');
        Route::delete('/{id}',       [AdminController::class, 'destroyAuction'])->name('destroy');
    });
    // manage users
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/',              [AdminController::class, 'users'])->name('index');
        Route::get('/{id}',          [AdminController::class, 'showUser'])->name('show');
        Route::put('/{id}/role',     [AdminController::class, 'updateRole'])->name('role');
        Route::put('/{id}/ban',      [AdminController::class, 'banUser'])->name('ban');
        Route::delete('/{id}',       [AdminController::class, 'destroyUser'])->name('destroy');
    });
    // Manage Bids
    Route::prefix('bids')->name('bids.')->group(function () {
        Route::get('/',              [AdminController::class, 'bids'])->name('index');
        Route::delete('/{id}',       [AdminController::class, 'destroyBid'])->name('destroy');
    });

});
