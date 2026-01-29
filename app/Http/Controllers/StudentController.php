<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Event;
use App\Models\JobPost;       
use App\Models\JobApplication; 
use App\Models\News;          
use App\Models\Gallery;       // <--- NEW IMPORT ADDED HERE
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    // 1. Dashboard
    public function dashboard()
    {
        $user = Auth::user();

        // A. Get Upcoming Events
        $events = Event::whereDate('event_date', '>=', now())
                        ->orderBy('event_date', 'asc')
                        ->take(3)
                        ->get();

        // B. Get Recent Jobs
        $jobs = JobPost::where('status', 'active')
                       ->orderBy('created_at', 'desc')
                       ->take(3)
                       ->get();

        // C. Get News (Global + My Chapter + My Dept)
        $news_list = News::where(function($q) use ($user) {
                        $q->whereNull('chapter_id')->whereNull('department_id'); 
                    })
                    ->orWhere('chapter_id', $user->chapter_id)     
                    ->orWhere('department_id', $user->department_id) 
                    ->orderBy('created_at', 'desc')
                    ->take(5)
                    ->get();

        return view('student.dashboard', compact('user', 'events', 'jobs', 'news_list'));
    }

    // 2. Profile Update
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $request->validate(['name' => 'required']);
        
        $student = User::find($user->id); 
        $student->name = $request->name;
        $student->save();
        
        return back()->with('success', 'Profile updated successfully!');
    }

    // 3. Events List
    public function events()
    {
        $user = Auth::user();
        $events = Event::orderBy('event_date', 'asc')->get();
        return view('student.events', compact('events'));
    }

    // 4. Event RSVP
    public function toggleAttendance($eventId)
    {
        $user = Auth::user();
        if ($user->eventsAttending->contains($eventId)) {
            $user->eventsAttending()->detach($eventId);
            return back()->with('success', 'You have cancelled your registration.');
        } 
        $user->eventsAttending()->attach($eventId);
        return back()->with('success', 'You are now registered!');
    }

    // 5. Job List
    public function jobs()
    {
        $user = Auth::user();
        $jobs = JobPost::where('status', 'active')->get();
        return view('student.jobs', compact('jobs'));
    }

    // 6. Apply to Job
    public function applyJob($id)
    {
        $user = Auth::user();

        $exists = JobApplication::where('job_id', $id)
                                ->where('user_id', $user->id)
                                ->exists();

        if ($exists) {
            return back()->with('error', 'You have already applied.');
        }

        JobApplication::create([
            'job_id' => $id,
            'user_id' => $user->id,
            'status' => 'pending'
        ]);

        return back()->with('success', 'Application submitted!');
    }

    // 7. Student Gallery Page (NEW FUNCTION)
    public function gallery()
    {
        $user = Auth::user();

        // Fetch photos: Global OR My Chapter OR My Dept
        $photos = Gallery::where(function($q) use ($user) {
                        $q->whereNull('chapter_id')->whereNull('department_id'); // Global
                    })
                    ->orWhere('chapter_id', $user->chapter_id)     // My Chapter
                    ->orWhere('department_id', $user->department_id) // My Dept
                    ->orderBy('created_at', 'desc')
                    ->get();

        return view('student.gallery', compact('photos', 'user'));
    }
}