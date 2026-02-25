<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BebrasController;
use App\Http\Controllers\Bebras2Controller;
use App\Http\Controllers\Suma2Controller;
use App\Http\Controllers\SumaController;
use App\Http\Controllers\BijunasController;
use App\Http\Controllers\FormController;

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

Route::get('/bebras', function () {
    return '<h1>Bebras</h1>';
});

Route::get('/barsukas', function () {
    return view('barsukas');
});

Route::get('/paprastas-bebras', [BebrasController::class, 'paprastasBebras']);
Route::get('/blade/bebras', [BebrasController::class, 'bladeBebras']);

Route::get('/spalvotas-bebras/{bebroSpalva}', [BebrasController::class, 'spalvotasBebras']);


// Sukurti Barsuko kontrolerį, sukurti barsuke kokį nors metodą, kuris ką nors rodo
// Surautinti to kontrolerio metodą route faile
// Patikrinti ar veikia
Route::get('/paprastas-bebras2', [Bebras2Controller::class, 'paprastasBebras2']);

// Route::get('/suma/{a}/{b}', [SumaController::class, 'suma']);
Route::get('/suma/8/9', [Suma2Controller::class, 'suma']);
Route::get('/bijunas', [BijunasController::class, 'bijunas']);


// GET forma
Route::get('/get', [FormController::class, 'showGetForm']);
Route::get('/get-result', [FormController::class, 'showSumFromGet'])->name('jono.resultatas');



// POST forma
Route::get('/post', [FormController::class, 'showPostForm']);
Route::post('/post-result', [FormController::class, 'makeSumFromPost'])->name('formos-apdorojimas'); // bus perduota bodyje, o ne query string'e, kaip GET atveju
Route::get('/post-result', [FormController::class, 'showSumFromPost'])->name('rezultato-rodymas'); // redirektas po POST formos apdorojimo, kad vartotojas nematytų duomenų perdavimo URL'e, kaip GET atveju




// padaryti sumatorių kuri yra POST forma.
// į formą suvedus 8 ir 9
// atsakyme rodytų "8 + 9 = 17"
// po post metodoto turi būti redirectas
// reikia naujo kontrolerio, metodų, routų ir bladų failų
 
// padaryti surinkėją kuris yra POST forma
// į formą suvedus skaičių 7
// rodytų 7
// dar kartą į formą suvedus skaičių 9
// rodytų 7 9
// dar kartą į formą suvedus skaičių 10
// rodytų 7 9 10
// reikia naujo kontrolerio, metodų, routų ir bladų failų
// dar galit pagalvoti apie mygtuką, kuris viską ištrina
