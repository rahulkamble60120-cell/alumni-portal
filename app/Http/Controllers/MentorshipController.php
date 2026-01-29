<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\MentorshipRequest;
use Illuminate\Support\Facades\Auth;

class MentorshipController extends Controller
{
    // 1. For Students: Show list of Alumni (Potential Mentors)
    public function index()
    {
        // Fetch all users who are 'alumni'
        // We assume 'role' is 'alumni'. If you don't use roles, remove the ->where() part.
        $mentors = User::where('role', 'alumni')->orderBy('name')->get();
        return view('student.mentors.index', compact('mentors'));
    }

    // 2. For Students: Send a Request
    public function store(Request $request)
    {
        $request->validate([
            'mentor_id' => 'required|exists:users,id',
            'message' => 'required|string|max:500',
        ]);

        // Check if already requested
        $exists = MentorshipRequest::where('student_id', Auth::id())
                                   ->where('mentor_id', $request->mentor_id)
                                   ->exists();
        
        if ($exists) {
            return back()->with('error', 'You have already contacted this mentor.');
        }

        MentorshipRequest::create([
            'student_id' => Auth::id(),
            'mentor_id' => $request->mentor_id,
            'message' => $request->message,
            'status' => 'pending'
        ]);

        return back()->with('success', 'Request sent successfully!');
    }

    // 3. For Alumni: View Requests sent to me
    public function myRequests()
    {
        $user = Auth::user();
        // Get requests where I am the mentor
        $requests = MentorshipRequest::where('mentor_id', $user->id)
                                     ->with('student') // Load student info
                                     ->orderBy('created_at', 'desc')
                                     ->get();

        return view('alumni.requests', compact('requests'));
    }

    // 4. For Alumni: Accept/Decline
    public function updateStatus($id, $status)
    {
        $request = MentorshipRequest::findOrFail($id);
        
        // Security check: Only the mentor can update
        if ($request->mentor_id != Auth::id()) {
            abort(403);
        }

        $request->status = $status;
        $request->save();

        return back()->with('success', 'Request updated to ' . $status);
    }
}