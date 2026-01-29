<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AlumniController extends Controller
{
    public function index()
    {
        $alumni = Alumni::latest()->get();
        return view('admin.alumni.index', compact('alumni'));
    }

    public function approve($id)
    {
        // Explicitly search by user_id column
        $user = User::where('user_id', $id)->firstOrFail();
        $user->status = 'approved';
        $user->save();

        return back()->with('success', "Account for {$user->name} has been approved.");
    }

    public function reject($id)
    {
        $user = User::where('user_id', $id)->firstOrFail();
        $user->status = 'rejected';
        $user->save();

        return back()->with('success', "Account for {$user->name} has been rejected.");
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'graduation_year' => 'required|numeric',
        ]);

        Alumni::create([
            'name' => $request->name,
            'email' => $request->email,
            'graduation_year' => $request->graduation_year,
            'institution_id' => Auth::user()->institution_id,
            'password' => bcrypt('password'),
            'role' => 'student',
            'status' => 'approved',
        ]);

        return back()->with('success', 'Alumnus added successfully!');
    }
}