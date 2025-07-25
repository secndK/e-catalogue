<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('pages.Auth.login');
    }


    public function login(Request $request)
    {
        $request->validate([
            'mat_ag' => 'required|string|max:255',
            'password' => 'required|string',
        ]);

        $user = DB::connection('mysql')
            ->selectOne('SELECT * FROM users WHERE mat_ag = ? LIMIT 1', [$request->mat_ag]);

        if (!$user) {
            return back()->withInput()->with('error', 'Matricule incorrect.');
        }

        if (!Hash::check($request->password, $user->password)) {
            return back()->withInput()->with('error', 'Mot de passe incorrect.');
        }

        // Vérification du rôle admin
        if ($user->role !== 'admin') {
            return back()->withInput()->with('error', 'Accès réservé aux administrateurs.');
        }

        Auth::loginUsingId($user->id);
        $request->session()->regenerate();

        return redirect()->route('catalogue'); // Redirection vers le dashboard admin
    }


    public function guestAccess()
    {

        session(['user_type' => 'guest']);

        return redirect()->route('catalogue');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
