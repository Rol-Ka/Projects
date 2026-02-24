<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BijunasController extends Controller
{
    public function bijunas()
    {
        $skaicius = rand(1, 10);
        $geles = ['roze', 'tulpe', 'bijunas', 'narcizas', 'vazone', 'sode'];

        return view('bijunas.index', ['skaicius' => $skaicius, 'geles' => $geles]);
    }
}
