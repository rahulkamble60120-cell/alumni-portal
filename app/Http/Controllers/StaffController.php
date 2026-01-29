<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Department;
use App\Models\Chapter;

class StaffController extends Controller
{
    // 1. List all "Staff" (Dept Admins & Chapter Admins)
    public function index()
    {
        // Find anyone who is NOT a student and NOT a super admin
        $staff = User::whereIn('role', ['department_admin', 'chapter_admin'])->get();
        
        // We also need lists of Depts/Chapters for the "Add New" dropdowns
        $departments = Department::all();
        $chapters = Chapter::all();

        return view('admin.staff.index', compact('staff', 'departments', 'chapters'));
    }

    // 2. Create a NEW Admin (or promote an existing user by Email)
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'role' => 'required', // department_admin OR chapter_admin
            // If role is dept_admin, department_id is required. If chapter_admin, chapter_id is required.
        ]);

        // Check if user already exists
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            // Create new user if they don't exist
            $user = new User();
            $user->email = $request->email;
            $user->password = bcrypt('password123'); // Default password
            $user->institution_id = 1;
            $user->status = 'approved';
        }

        // Update details
        $user->name = $request->name;
        $user->role = $request->role;

        // Assign the specific Department or Chapter
        if ($request->role == 'department_admin') {
            $user->department_id = $request->department_id;
            $user->chapter_id = null; // Clear chapter if any
        } elseif ($request->role == 'chapter_admin') {
            $user->chapter_id = $request->chapter_id;
            $user->department_id = null; // Clear dept if any
        }

        $user->save();

        return back()->with('success', 'Admin assigned successfully! Password is "password123"');
    }

    // 3. Remove Admin Rights (Demote to Alumni)
    public function destroy($id)
    {
        $user = User::find($id);
        $user->role = 'alumnus'; // Demote back to normal user
        $user->department_id = null;
        $user->chapter_id = null;
        $user->save();

        return back()->with('success', 'User removed from Staff.');
    }
}