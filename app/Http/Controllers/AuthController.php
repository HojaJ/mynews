<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }
    
    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required',
            'password' => 'required',
        ]);
        
        $user = User::where('login', $request->login)->first();
        
        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'login' => 'Неверные учетные данные',
            ]);
        }

        session([
            'user_id' => $user->id,
            'user_login' => $user->login,
            'user_role' => $user->role,
        ]);
        
        return redirect()->route('news.index');
    }
    
    public function showRegistrationForm()
    {
        return view('auth.register');
    }
    
    public function register(Request $request)
    {
        $request->validate([
            'login' => 'required|string|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);


        $user = User::create([
            'login' => $request->login,
            'password' => Hash::make($request->password),
            'role' => 'user',
        ]);
        
        session([
            'user_id' => $user->id,
            'user_login' => $user->login,
            'user_role' => $user->role,
        ]);
        
        return redirect()->route('news.index');
    }
    
    public function logout()
    {
        auth()->logout();
        session()->forget(['user_id', 'user_login', 'user_role']);
        return redirect()->route('news.index');
    }
}
