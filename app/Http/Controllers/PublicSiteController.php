<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Institution;
use App\Models\Event;
use App\Models\Job;     // Changed from JobPost to Job
use App\Models\News;    

class PublicSiteController extends Controller
{
    public function index($id)
    {
        // 1. Find the college
        $institution = Institution::findOrFail($id);

        // 2. Find upcoming events for this specific school
        $events = Event::where('institution_id', $id)
                       ->orderBy('event_date', 'asc')
                       ->take(3)
                       ->get();

        // 3. Find latest jobs (Using the correct 'Job' model)
        // Ensure your AdminController is saving jobs with the correct institution_id
        $jobs = Job::where('institution_id', $id)
                   ->orderBy('created_at', 'desc')
                   ->take(3)
                   ->get();

        // 4. Find Latest Stories
        // Note: You can also filter news by institution_id if you added that column
        $news_list = News::orderBy('created_at', 'desc')
                         ->take(3)
                         ->get();

        // 5. Send everything to the view
        return view('institution_home', compact('institution', 'events', 'jobs', 'news_list'));
    }
}