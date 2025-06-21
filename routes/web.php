<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\PicviewController;
use App\Http\Controllers\ClaimController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\ImageRecognitionController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\MessageController;

// Redirect root to login page
Route::get('/', fn() => redirect()->route('login'));

// ======================
// Public (Student/User)
// ======================
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.perform');
Route::get('/register', [RegisterController::class, 'index']);
Route::post('/register', [RegisterController::class, 'register']);
Route::get('/logout', [LogoutController::class, 'logout']);

Route::get('/home/{username}', [HomeController::class, 'index'])->name('home.index');
Route::post('/home/{username}', [HomeController::class, 'add'])->name('home.add');

Route::get('/search', fn() => view('search'))->name('search.page');
Route::post('/search/image', [ImageRecognitionController::class, 'searchByImage'])->name('search.by.image');

Route::get('/picview/{id}', [PicviewController::class, 'index']);
Route::get('/profile/{username}/{id}', [PicviewController::class, 'index']);
Route::get('/picview/delete/{id}', [PicviewController::class, 'delete']);

Route::get('/profile/{username}', [ProfileController::class, 'index']);
Route::put('/profile/{username}', [ProfileController::class, 'profile_update']);
Route::get('/profile/{username}/delete', [ProfileController::class, 'delete']);

Route::get('/claim', [ClaimController::class, 'index']);
Route::get('/claim/pic/{id}', [ClaimController::class, 'claim']);
Route::get('/claim/approve/{student}/{id}', [ClaimController::class, 'approve']);
Route::get('/claim/delete/{student}/{id}', [ClaimController::class, 'delete']);
Route::post('/claim/{item}', [ClaimController::class, 'initiate'])->name('claim.initiate');

Route::get('/chat/{itemId}/{userId}', [MessageController::class, 'show'])->name('chat.show');
Route::post('/chat/send', [MessageController::class, 'send'])->name('chat.send');

// ======================
// Admin Routes
// ======================
Route::prefix('admin')->group(function () {
    // Admin Public Login
    Route::get('/login', [AdminController::class, 'showLogin'])->name('admin.login.form');
    Route::post('/login', [AdminController::class, 'login'])->name('admin.login');

    // Protected Admin Area
    Route::middleware('auth:admin')->group(function () {
        Route::post('/logout', [AdminController::class, 'logout'])->name('admin.logout');

        // Dashboard Pages
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/moderation', [AdminController::class, 'moderationPage'])->name('admin.moderation');
        Route::get('/claims', [AdminController::class, 'claimsPage'])->name('admin.claims');
        Route::get('/reports', [AdminController::class, 'reportsPage'])->name('admin.reports');

        // Item & Claim Moderation
        Route::post('/moderate', [AdminController::class, 'moderate'])->name('admin.moderate');
        Route::post('/claims/moderate', [AdminController::class, 'moderateClaim'])->name('admin.claims.moderate');
        Route::get('/claims', [AdminController::class, 'claims'])->name('admin.claims');
        Route::get('/item-details/{id}', [AdminController::class, 'getItemDetails'])->name('admin.item.details');

        // AI/ML Tools
        Route::post('/recognize-image', [ImageRecognitionController::class, 'recognize'])->name('admin.image.recognize');
        Route::post('/items/{id}/label', [HomeController::class, 'updateLabel'])->name('items.updateLabel');
        Route::get('/search-items', [ItemController::class, 'searchItems']);
        Route::post('/search/image', [ImageRecognitionController::class, 'searchByImage'])->name('admin.search.by.image');

        // Admin Chat
        Route::get('/chat/{itemId}/{userId}', [MessageController::class, 'show'])->name('admin.chat.show');
        Route::post('/chat/send', [MessageController::class, 'send'])->name('admin.chat.send');
        Route::post('/chat/{itemId}/decision', [MessageController::class, 'decision'])->name('chat.decision');

        // Optional admin-initiated claim
        Route::post('/claim/{item}', [ClaimController::class, 'initiate'])->name('admin.claim.initiate');
    });
});
