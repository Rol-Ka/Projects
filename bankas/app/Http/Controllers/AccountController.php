<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAccountRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    private function generateIban()
    {
        return 'LT' . str_pad(rand(0, 999999999999999999), 18, '0', STR_PAD_LEFT);
    }
    public function index()
    {
        $accounts = json_decode(file_get_contents(storage_path('app/accounts.json')), true);

        usort($accounts, function ($a, $b) {
            return strcmp($a['surname'], $b['surname']);
        });

        // Bendras banko balansas
        $totalBalance = 0;

        foreach ($accounts as $a) {
            $totalBalance += $a['balance'];
        }

        return view('accounts.index', [
            'accounts' => $accounts,
            'totalBalance' => $totalBalance,
        ]);
    }

    public function create()
    {
        $iban = $this->generateIban();
        return view('accounts.create', compact('iban'));
    }

    public function store(StoreAccountRequest $request)
    {
        $accounts = json_decode(file_get_contents(storage_path('app/accounts.json')), true);

        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3',
            'surname' => 'required|min:3',
            'personal_code' => 'required|digits:11',
        ], [
            'name.required' => 'Įveskite vardą',
            'name.min' => 'Vardas turi būti bent 3 simboliai',

            'surname.required' => 'Įveskite pavardę',
            'surname.min' => 'Pavardė turi būti bent 3 simboliai',

            'personal_code.required' => 'Įveskite asmens kodą',
            'personal_code.digits' => 'Asmens kodas turi būti tiksliai 11 skaičių',
        ]);

        // Unikalus AK tikrinimas
        foreach ($accounts as $acc) {
            if ($acc['personal_code'] === $request->personal_code) {
                $validator->errors()->add('personal_code', 'Toks asmens kodas jau egzistuoja');
            }
        }

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $accounts[] = [
            'id' => uniqid(),
            'name' => $request->name,
            'surname' => $request->surname,
            'personal_code' => $request->personal_code,
            'iban' => $request->iban,
            'balance' => 0
        ];

        file_put_contents(storage_path('app/accounts.json'), json_encode($accounts, JSON_PRETTY_PRINT));

        return redirect()->route('accounts.index')
            ->with('success', 'Sąskaita sukurta!');
    }
    public function destroy($id)
    {
        $path = storage_path('app/accounts.json');
        $accounts = json_decode(file_get_contents($path), true);

        foreach ($accounts as $key => $acc) {

            if ($acc['id'] == $id) {

                // NEGALIMA trinti jei yra pinigų
                if ($acc['balance'] > 0) {
                    return back()->with('error', 'Negalima ištrinti — sąskaitoje yra lėšų');
                }

                unset($accounts[$key]);

                file_put_contents($path, json_encode(array_values($accounts), JSON_PRETTY_PRINT));

                return back()->with('success', 'Sąskaita ištrinta');
            }
        }

        return back()->with('error', 'Sąskaita nerasta');
    }
    public function addForm($id)
    {
        $accounts = json_decode(file_get_contents(storage_path('app/accounts.json')), true);

        foreach ($accounts as $acc) {
            if ($acc['id'] == $id) {
                return view('accounts.add', compact('acc'));
            }
        }

        return redirect()->route('accounts.index')->with('error', 'Sąskaita nerasta');
    }

    public function addMoney(Request $request, $id)
    {
        $amount = floatval($request->amount);

        if ($amount <= 0) {
            return back()->with('error', 'Įveskite teigiamą sumą')->withInput();
        }

        $path = storage_path('app/accounts.json');
        $accounts = json_decode(file_get_contents($path), true);

        foreach ($accounts as &$acc) {

            if ($acc['id'] == $id) {

                $acc['balance'] += $amount;

                file_put_contents($path, json_encode($accounts, JSON_PRETTY_PRINT));

                return redirect()->route('accounts.index')
                    ->with('success', 'Pinigai pridėti');
            }
        }

        return back()->with('error', 'Sąskaita nerasta');
    }

    public function withdrawForm($id)
    {
        $accounts = json_decode(file_get_contents(storage_path('app/accounts.json')), true);

        foreach ($accounts as $acc) {
            if ($acc['id'] == $id) {
                return view('accounts.withdraw', compact('acc'));
            }
        }

        return redirect()->route('accounts.index')->with('error', 'Sąskaita nerasta');
    }

    public function withdrawMoney(Request $request, $id)
    {
        $amount = floatval($request->amount);

        if ($amount <= 0) {
            return back()->with('error', 'Įveskite teigiamą sumą')->withInput();
        }

        $path = storage_path('app/accounts.json');
        $accounts = json_decode(file_get_contents($path), true);

        foreach ($accounts as &$acc) {

            if ($acc['id'] == $id) {

                // NEGALIMA minusas
                if ($amount > $acc['balance']) {
                    return back()->with('error', 'Nepakanka lėšų')->withInput();
                }

                $acc['balance'] -= $amount;

                file_put_contents($path, json_encode($accounts, JSON_PRETTY_PRINT));

                return redirect()->route('accounts.index')
                    ->with('success', 'Pinigai nuskaičiuoti');
            }
        }

        return back()->with('error', 'Sąskaita nerasta');
    }
}
