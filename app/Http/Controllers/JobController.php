<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;
use Illuminate\Support\Facades\Auth;

class JobController extends Controller
{
    // List all jobs
    public function index()
    {
        $jobs = Job::latest()->get();
        return view('admin.jobs.index', compact('jobs'));
    }

    // Store a new job
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'type' => 'required',
            'description' => 'required'
        ]);

        Job::create([
            'title' => $request->title,
            'company' => $request->company,
            'location' => $request->location,
            'type' => $request->type,
            'description' => $request->description,
            'user_id' => Auth::id(),
            'institution_id' => Auth::user()->institution_id // Essential for public site
        ]);

        return back()->with('success', 'Job posted successfully!');
    }

    // Delete a job
    public function destroy($id)
    {
        // This will now look for the 'id' column correctly
        $job = Job::findOrFail($id);
        $job->delete();

        return back()->with('success', 'Job deleted successfully.');
    }
}