<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $users = json_decode(file_get_contents(storage_path('app/users.json')), true);

        foreach ($users as $user) {

            if (
                $user['email'] === $request->email &&
                Hash::check($request->password, $user['password'])
            ) {

                session(['user' => $user]);

                return redirect()->route('accounts.index')
                    ->with('success', 'Prisijungta');
            }
        }

        return back()->with('error', 'Neteisingi prisijungimo duomenys')->withInput();
    }

    public function logout()
    {
        session()->forget('user');

        return redirect('/login')->with('success', 'Atsijungta');
    }
}
