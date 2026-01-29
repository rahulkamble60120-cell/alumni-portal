<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Institution;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    // 1. Show the Registration Form
    public function showRegistrationForm($id)
    {
        $institution = Institution::findOrFail($id);
        return view('auth.register', compact('institution', 'id'));
    }

    // 2. Handle the Registration Logic
    public function register(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'graduation_year' => 'required|integer',
        ]);

        // Create the User with 'pending' status
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'institution_id' => $id,
            'role' => 'student', 
            'graduation_year' => $request->graduation_year,
            'status' => 'pending', // <--- IMPORTANT: Set to pending
        ]);

        // ❌ DELETED: Auth::login($user); 
        // We removed the auto-login line. 

        // ✅ REDIRECT: Send them to Login page instead of Dashboard
        return redirect('/login')->with('success', 'Account created! Please wait for Admin approval.');
    }
}