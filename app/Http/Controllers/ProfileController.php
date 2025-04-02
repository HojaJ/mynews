<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        if (!session('user_id')) {
            return redirect()->route('login');
        }
        
        $user = User::find(session('user_id'));
        return view('profile.index', compact('user'));
    }
    
    public function showChangePasswordForm()
    {
        return view('profile.change_password');
    }
    
    public function changePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);
        
        $user = User::find(session('user_id'));
        $user->password = Hash::make($request->password);
        $user->save();
        
        return redirect()->route('profile')->with('success', 'Пароль успешно изменен');
    }
}
