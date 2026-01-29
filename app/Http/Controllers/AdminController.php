<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Department;
use App\Models\Chapter;
use App\Models\Event;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function dashboard() 
    {
        // Fetch counts for the stat cards
        $total_alumni = User::where('role', 'student')->count();
        $total_events = Event::count();
        $total_jobs = Job::count();
        $pending_approvals = User::where('status', 'pending')->count();

        // Fetch the actual users for the pending table
        $pendingUsers = User::where('status', 'pending')->latest()->get();

        return view('admin.dashboard', compact(
            'total_alumni', 
            'total_events', 
            'total_jobs', 
            'pending_approvals',
            'pendingUsers'
        ));
    }

    public function staff()
    {
        $staff = User::whereIn('role', ['department_admin', 'chapter_admin'])->get();
        $departments = Department::all(); 
        $chapters = Chapter::all();
        return view('admin.staff.index', compact('staff', 'departments', 'chapters'));
    }

    public function createStaff(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'required',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'department_id' => $request->department_id,
            'chapter_id' => $request->chapter_id,
            'institution_id' => auth()->user()->institution_id,
            'status' => 'approved',
            'password' => Hash::make('password123'),
        ]);

        return back()->with('success', 'Admin role assigned successfully!');
    }

    public function removeStaff($id)
    {
        User::where('user_id', $id)->delete();
        return back()->with('success', 'Staff member removed.');
    }
}