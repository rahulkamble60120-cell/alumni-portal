<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // 1. Show Login Form
    public function showLogin()
    {
        return view('auth.login');
    }

    // 2. Handle Login Logic
    public function login(Request $request)
    {
        // Validate inputs
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Attempt to log in
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            // 🛑 SECURITY CHECK: Kick them out if pending
            if (Auth::user()->status === 'pending') {
                Auth::logout(); // Logout immediately
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                
                return back()->withErrors([
                    'email' => 'Your account is pending Admin approval.',
                ]);
            }

            // Redirect based on role
            $role = Auth::user()->role;
            
            // Admins go to Admin Dashboard
            if ($role === 'admin' || $role === 'super_admin') {
                return redirect('/admin/dashboard');
            } 
            
            // Students/Alumni go to Student Dashboard
            return redirect('/student/dashboard');
        }

        // Login Failed
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    // 3. Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}