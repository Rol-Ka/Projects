<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StoryController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\DonationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

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
});

Route::middleware('auth')->group(function () {
    Route::get('/story/create', [StoryController::class, 'create'])->name('story.create');
    Route::post('/story', [StoryController::class, 'store'])->name('story.store');
});

Route::get('/', [StoryController::class, 'index'])->name('home');
Route::middleware('auth')->group(function () {
    Route::post('/like/{story}', [LikeController::class, 'toggle'])->name('like.toggle');
});
Route::middleware('auth')->group(function () {
    Route::post('/donate/{story}', [DonationController::class, 'donate'])->name('donate');
});

Route::get('/tags-json', function () {
    return \App\Models\Tag::orderBy('name')->pluck('name');
});

require __DIR__ . '/auth.php';
