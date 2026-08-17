<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Broadcast;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\AuctionController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BidController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PaymentController;

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
    // Forgot password
    Route::get('/forgot-password',        [ForgotPasswordController::class, 'show'])->name('password.request');
    Route::post('/forgot-password',       [ForgotPasswordController::class, 'send'])->name('password.email'); 
    // Reset password
    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'show'])->name('password.reset');
    Route::post('/reset-password',        [ResetPasswordController::class, 'reset'])->name('password.update');

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

    // Payments — buyer and seller access
    Route::get('/payment/{auction}/checkout',         [PaymentController::class, 'checkout'])->name('payment.checkout');
    Route::post('/payment/{auction}/submit',          [PaymentController::class, 'submit'])->name('payment.submit');
    Route::get('/payment/{auction}/status',           [PaymentController::class, 'status'])->name('payment.status');
    Route::get('/payment/{payment}/ship',             [PaymentController::class, 'shipForm'])->name('payment.ship.form');
    Route::post('/payment/{payment}/ship',            [PaymentController::class, 'ship'])->name('payment.ship');
    Route::post('/payment/{payment}/confirm-receipt', [PaymentController::class, 'confirmReceipt'])->name('payment.confirm-receipt');
    Route::post('/payment/{payment}/dispute',         [PaymentController::class, 'dispute'])->name('payment.dispute');
 

  // ── Notifications ─────────────────────────────────────────────────────
    Route::get('/notifications',            [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/dropdown',   [NotificationController::class, 'dropdown'])->name('notifications.dropdown');
    Route::post('/notifications/mark-all',  [NotificationController::class, 'markAllRead'])->name('notifications.mark-all');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markRead'])->name('notifications.read');
    Route::delete('/notifications/{id}',    [NotificationController::class, 'destroy'])->name('notifications.destroy');
 
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
    // Earnings / payment history
    Route::get('/earnings',        [SellerController::class, 'earnings'])->name('earnings');
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

    // Manage Payments (Escrow)
    Route::prefix('payments')->name('payments.')->group(function () {
        Route::get('/',                   [PaymentController::class, 'index'])->name('index');
        Route::post('/{payment}/confirm', [PaymentController::class, 'confirm'])->name('confirm');
        Route::post('/{payment}/release', [PaymentController::class, 'release'])->name('release');
        Route::post('/{payment}/refund',  [PaymentController::class, 'refund'])->name('refund');
    });

});
