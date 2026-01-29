<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DepartmentController extends Controller
{
    public function index()
    {
        // Fetch all departments for this school
        $departments = Department::all();
        return view('admin.departments.index', compact('departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Department::create([
            'name' => $request->name,
            'institution_id' => Auth::user()->institution_id,
        ]);

        return back()->with('success', 'Department created successfully!');
    }

    public function destroy($id)
    {
        Department::findOrFail($id)->delete();
        return back()->with('success', 'Department deleted.');
    }
}