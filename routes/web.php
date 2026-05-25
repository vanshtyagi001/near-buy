<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/deal/{slug}', [HomeController::class, 'showDeal'])->name('deal.show');
Route::post('/set-city', [HomeController::class, 'setCity'])->name('set-city');

/*
|--------------------------------------------------------------------------
| Guest Authentication Routes
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

/*
|--------------------------------------------------------------------------
| Authenticated (All Roles) Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

/*
|--------------------------------------------------------------------------
| Admin Panel Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // City Management
    Route::get('/cities', [AdminController::class, 'cities'])->name('cities');
    Route::post('/cities', [AdminController::class, 'storeCity'])->name('cities.store');
    Route::delete('/cities/{city}', [AdminController::class, 'destroyCity'])->name('cities.destroy');
    
    // Category Management
    Route::get('/categories', [AdminController::class, 'categories'])->name('categories');
    Route::post('/categories', [AdminController::class, 'storeCategory'])->name('categories.store');
    
    // Business Profile Supervision
    Route::get('/businesses', [AdminController::class, 'businesses'])->name('businesses');
    Route::post('/businesses/{business}/toggle', [AdminController::class, 'toggleBusiness'])->name('businesses.toggle');
    
    // Deal Moderation
    Route::get('/deals', [AdminController::class, 'deals'])->name('deals');
    Route::delete('/deals/{deal}', [AdminController::class, 'deleteDeal'])->name('deals.delete');
    
    // User Control
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::post('/users/{user}/toggle', [AdminController::class, 'toggleUser'])->name('users.toggle');
});

/*
|--------------------------------------------------------------------------
| Business Owner Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:business'])->prefix('business')->name('business.')->group(function () {
    // Force profile creation first if no profile registered
    Route::get('/profile/create', [BusinessController::class, 'create'])->name('create');
    Route::post('/profile', [BusinessController::class, 'store'])->name('store');
    
    // Protected behind active profile check
    Route::get('/dashboard', [BusinessController::class, 'dashboard'])->name('dashboard');
    
    // Business Deal CRUD Operations
    Route::get('/deals/create', [BusinessController::class, 'createDeal'])->name('deals.create');
    Route::post('/deals', [BusinessController::class, 'storeDeal'])->name('deals.store');
    Route::get('/deals/{deal}/edit', [BusinessController::class, 'editDeal'])->name('deals.edit');
    Route::put('/deals/{deal}', [BusinessController::class, 'updateDeal'])->name('deals.update');
    Route::delete('/deals/{deal}', [BusinessController::class, 'destroyDeal'])->name('deals.destroy');
});

/*
|--------------------------------------------------------------------------
| Customer/User Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:user'])->prefix('my-dashboard')->name('user.')->group(function () {
    Route::get('/', [UserController::class, 'dashboard'])->name('dashboard');
    Route::post('/favorite/{deal}', [UserController::class, 'toggleFavorite'])->name('favorite.toggle');
});