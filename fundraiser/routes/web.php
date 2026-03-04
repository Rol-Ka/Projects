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

Route::view('/', 'welcome')->name('home');

Route::get('/stories', [StoryController::class, 'index'])->name('stories.index');

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


Route::middleware('auth')->group(function () {
    Route::post('/like/{story}', [LikeController::class, 'toggle'])->name('like.toggle');
});
Route::middleware('auth')->group(function () {
    Route::post('/donate/{story}', [DonationController::class, 'donate'])->name('donate');
});

Route::get('/tags-json', function () {
    return \App\Models\Tag::orderBy('name')->pluck('name');
});

Route::get('/story/{story}', [StoryController::class, 'show'])->name('story.show');

Route::get('/start-fundraiser', function () {

    if (auth()->check()) {
        return redirect()->route('story.create');
    }

    session(['start_fundraiser' => true]);

    return view('auth.start');
})->name('fundraiser.start');

Route::middleware(['auth'])->group(function () {

    Route::get('/admin/stories', [\App\Http\Controllers\AdminController::class, 'index'])
        ->name('admin.stories');

    Route::post('/admin/stories/{story}/approve', [\App\Http\Controllers\AdminController::class, 'approve'])
        ->name('admin.stories.approve');

    Route::delete('/admin/stories/{story}', [\App\Http\Controllers\AdminController::class, 'destroy'])
        ->name('admin.stories.destroy');

    Route::get('/story/{story}/edit', [StoryController::class, 'edit'])
        ->name('story.edit');

    Route::put('/story/{story}', [StoryController::class, 'update'])
        ->name('story.update');
});







require __DIR__ . '/auth.php';
