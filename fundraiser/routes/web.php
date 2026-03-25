<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StoryController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminTagController;
use App\Http\Controllers\StoryEditController;

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

// Route::view('/', 'welcome')->name('home');
Route::get('/', [HomeController::class, 'index'])->name('home');

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


Route::post('/like/{story}', [LikeController::class, 'toggle']);


Route::post('/donate/{story}', [DonationController::class, 'donate'])->name('donate');


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
    Route::get('/admin/stories/{story}', [AdminController::class, 'show'])
        ->name('admin.stories.show');

    Route::get('/admin/stories/{story}/edit', [AdminController::class, 'edit'])
        ->name('admin.stories.edit');

    Route::put('/admin/stories/{story}', [AdminController::class, 'update'])
        ->name('admin.stories.update');

    Route::delete('/admin/images/{image}', [AdminController::class, 'deleteImage'])
        ->name('admin.image.delete');


    Route::get('/admin', [AdminController::class, 'dashboard'])
        ->name('admin.dashboard');

    Route::get('/admin/stories', [AdminController::class, 'index'])
        ->name('admin.stories');

    Route::post('/admin/stories/{story}/approve', [AdminController::class, 'approve'])
        ->name('admin.stories.approve');

    Route::delete('/admin/stories/{story}', [AdminController::class, 'destroy'])
        ->name('admin.stories.destroy');

    Route::delete('/admin/stories/{story}/tags/{tag}', [AdminController::class, 'detachTag'])
        ->name('admin.tag.detach');

    Route::get('/admin/tags', [AdminTagController::class, 'index'])
        ->name('admin.tags');

    Route::post('/admin/tags', [AdminTagController::class, 'store'])
        ->name('admin.tags.store');

    Route::put('/admin/tags/{tag}', [AdminTagController::class, 'update'])
        ->name('admin.tags.update');

    Route::delete('/admin/tags/{tag}', [AdminTagController::class, 'destroy'])
        ->name('admin.tags.destroy');


    Route::get('/story/{story}/edit', [StoryController::class, 'edit'])
        ->name('story.edit');

    Route::put('/story/{story}', [StoryEditController::class, 'update'])
        ->name('story.update');

    Route::delete('/story/{story}', [StoryController::class, 'destroy'])->name('story.destroy');
});












require __DIR__ . '/auth.php';
