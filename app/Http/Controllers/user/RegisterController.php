<?php

namespace App\Http\Controllers\user;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
class RegisterController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.auth');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'role' => 'client',
        ]);

        \Log::info('User registered', ['user_id' => $user->id, 'email' => $user->email]);

        auth()->login($user);

        return redirect()->route('listings.index')->with('success', 'Registration successful!');
    }
}