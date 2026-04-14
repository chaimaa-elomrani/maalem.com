<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ArtisanProfileController;



Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('posts/create', [PostController::class, 'store'])->name('posts.store');
    Route::get('posts/create', [PostController::class, 'create'])->name('posts.create');

    Route::get('/artisan/setup', [ArtisanProfileController::class, 'setupForm'])->name('artisan.setup');
    Route::post('/artisan/setup', [ArtisanProfileController::class, 'setupStore'])->name('artisan.setup.store');
    Route::get('/artisan-dashboard', [ArtisanProfileController::class, 'dashboard'])->name('artisan.dashboard');
});

Route::get('/artisans', [ArtisanProfileController::class, 'index'])->name('artisans.index');
Route::get('/artisan/{id}', [ArtisanProfileController::class, 'show'])->name('artisan.profile');

Route::get('/feed', [PostController::class, 'index'])->name('feed');

require __DIR__.'/auth.php';

