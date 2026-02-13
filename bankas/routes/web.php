<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\AuthController;
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

Route::get('/login', [\App\Http\Controllers\AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login']);
Route::post('/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('logout');


Route::post('/logout', function () {
    session()->forget('user');
    return redirect('/login');
})->name('logout');

Route::middleware('auth.json')->group(function () {

    Route::get('/', [AccountController::class, 'index'])->name('accounts.index');
    Route::get('/create', [AccountController::class, 'create'])->name('accounts.create');
    Route::post('/store', [AccountController::class, 'store'])->name('accounts.store');
    Route::post('/delete/{id}', [AccountController::class, 'destroy'])->name('accounts.delete');
    Route::get('/add/{id}', [AccountController::class, 'addForm'])->name('accounts.add.form');
    Route::post('/add/{id}', [AccountController::class, 'addMoney'])->name('accounts.add.money');
    Route::get('/withdraw/{id}', [AccountController::class, 'withdrawForm'])->name('accounts.withdraw.form');
    Route::post('/withdraw/{id}', [AccountController::class, 'withdrawMoney'])->name('accounts.withdraw.money');
    Route::delete('/accounts/{id}', [AccountController::class, 'destroy'])->name('accounts.destroy');
});
