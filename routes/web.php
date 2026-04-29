<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ArtisanProfileController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return view('welcome');
})->name('home');



Route::get('/dashboard', [ClientController::class, 'dashboard'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('posts/create', [PostController::class, 'store'])->name('posts.store');
    Route::get('posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::get('posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::patch('posts/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');

    Route::get('/artisan/setup', [ArtisanProfileController::class, 'setupForm'])->name('artisan.setup');
    Route::post('/artisan/setup', [ArtisanProfileController::class, 'setupStore'])->name('artisan.setup.store');
    Route::get('/artisan-dashboard', [ArtisanProfileController::class, 'dashboard'])->name('artisan.dashboard');

    Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::post('/posts/{post}/like', [PostController::class, 'toggleLike'])->name('posts.like');

    // Delivery & Mediation
    Route::post('/deliveries', [DeliveryController::class, 'store'])->name('deliveries.store');
    Route::get('/mediateur/dashboard', [DeliveryController::class, 'mediatorDashboard'])->name('mediateur.dashboard');
    Route::post('/deliveries/{deliveryRequest}/accept', [DeliveryController::class, 'accept'])->name('deliveries.accept');
    Route::patch('/deliveries/{deliveryRequest}/status', [DeliveryController::class, 'updateStatus'])->name('deliveries.update-status');

    // Reviews
    Route::post('/artisans/{artisanUser}/reviews', [ReviewController::class, 'store'])->name('reviews.store');

    // Notifications
    Route::get('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');

    // Admin Routes
    Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/users', [AdminController::class, 'users'])->name('users');
        Route::get('/validation', [AdminController::class, 'pendingApprovals'])->name('validation');
        Route::get('/deliveries', [AdminController::class, 'deliveries'])->name('deliveries');
        Route::post('/artisans/{artisan}/approve', [AdminController::class, 'approveArtisan'])->name('artisans.approve');
        Route::post('/artisans/{artisan}/reject', [AdminController::class, 'rejectArtisan'])->name('artisans.reject');
    });
});

Route::get('/artisans', [ArtisanProfileController::class, 'index'])->name('artisans.index');
Route::get('/artisan/{id}', [ArtisanProfileController::class, 'show'])->name('artisan.profile');

Route::get('/feed', [PostController::class, 'index'])->name('feed');

require __DIR__.'/auth.php';

