<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SkaiciusController extends Controller
{
    public function forma2Skaiciai()
    {
        return view('skaiciai.du');
    }

    public function formos2SkaiciaiApdorojimas(Request $req)
    {

        $validated = $req->validate(
            [
                'skaicius1' => 'required|integer|min:0|max:99',
                'skaicius2' => 'required|integer|min:0|max:99',
            ],
            [
                'skaicius1.required' => 'Pirmas skaičius yra privalomas',
                'skaicius1.integer' => 'Pirmas skaičius turi būti sveikasis skaičius',
                'skaicius1.min' => 'Pirmas skaičius turi būti ne mažesnis nei 0',
                'skaicius1.max' => 'Pirmas skaičius turi būti ne didesnis nei 99',
                'skaicius2.required' => 'Antras skaičius yra privalomas',
                'skaicius2.integer' => 'Antras skaičius turi būti sveikasis skaičius',
                'skaicius2.min' => 'Antras skaičius turi būti ne mažesnis nei 0',
                'skaicius2.max' => 'Antras skaičius turi būti ne didesnis nei 99',
            ]
        );

        // jeigu validacija nepraeina - grąžinama atgal


        $sk1 = $req->input('skaicius1');
        $sk2 = $req->input('skaicius2');

        $rez = $sk1 + $sk2;

        return redirect()->route('rodymas-2')
            ->with(['rez' => $rez, 'sk1' => $sk1, 'sk2' => $sk2]);
    }

    public function formos2SkaiciaiRezultatas()
    {
        $rezultatas = session('rez', '');
        $skaicius1 = session('sk1', '');
        $skaicius2 = session('sk2', '');

        return view('skaiciai.du_rezultatas', [
            'rezultatas' => $rezultatas,
            'skaicius1' => $skaicius1,
            'skaicius2' => $skaicius2
        ]);
    }
}
