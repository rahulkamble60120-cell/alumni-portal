<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DirectoryController extends Controller
{
    public function index(Request $request)
    {
        // 1. UPDATED: Find ANYONE who is approved, just exclude the Super Admin
        // This fixes the issue where "Rahul k" was hidden if his role wasn't exactly "student"
        $query = User::where('status', 'approved')
                     ->where('role', '!=', 'super_admin');

        // 2. If user searched for a Name or Company...
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%$search%")
                  ->orWhere('current_company', 'LIKE', "%$search%")
                  ->orWhere('current_position', 'LIKE', "%$search%");
            });
        }

        // 3. If user filtered by Graduation Year...
        if ($request->filled('grad_year')) {
            $query->where('graduation_year', $request->grad_year);
        }

        // 4. Get the results
        $alumni = $query->orderBy('name')->get();

        // 5. UPDATED: Get years from everyone (not just "students")
        $years = User::where('status', 'approved')
                     ->where('role', '!=', 'super_admin')
                     ->distinct()
                     ->orderBy('graduation_year', 'desc')
                     ->pluck('graduation_year');

        return view('directory.index', compact('alumni', 'years'));
    }
}