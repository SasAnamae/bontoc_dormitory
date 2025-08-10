<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            session()->flash('success', 'Welcome back, ' . Auth::user()->name . '!');

          if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
            } elseif (Auth::user()->role === 'student') {
                    return redirect()->route('student.dashboard');
            }

            Auth::logout();
            return redirect('/')->with('error', 'Unauthorized role.');
        }
        return back()->with('error', 'Invalid email or password.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'student', 
            'agreed_to_terms' => false,
        ]);
            return redirect()->route('register')->with('success', 'Registration successful! You can now log in.');
    }
}
