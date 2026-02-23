<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BebrasController extends Controller
{
    public function paprastasBebras()
    {
        return '<h2>Paprastasis Bebras</h2>';
    }
    public function bladeBebras()
    {
        return view('bebras.labas');
    }
    public function spalvotasBebras($bebroSpalva)
    {


        return view('bebras.spalvotas', ['bebroSpalva' => $bebroSpalva]);
    }
}

// padaryti sumatorių kuris suvedus suma/8/9 rodytų "8 + 9 = 17"
// reikia naujo kontrolerio, metodo, routo ir blade failo 