<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    // 1. List Events
    public function index()
    {
        $user = Auth::user();
        $query = Event::query();

        // Security Filter
        if ($user->role == 'chapter_admin') {
            $query->where('chapter_id', $user->chapter_id);
        }
        if ($user->role == 'department_admin') {
            $query->where('department_id', $user->department_id);
        }

        $events = $query->orderBy('event_date', 'asc')->get();

        // ✅ Points to resources/views/admin/events/index.blade.php
        return view('admin.events.index', compact('events'));
    }

    // 2. Store New Event
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'event_date' => 'required|date',
            'description' => 'required',
            'type' => 'required',
            'location' => 'required'
        ]);

        $user = Auth::user();

        $event = new Event();
        $event->title = $request->title;
        $event->event_date = $request->event_date;
        $event->description = $request->description;
        $event->location = $request->location;
        $event->type = $request->type;
        $event->institution_id = 1;

        if ($user->role == 'chapter_admin') {
            $event->chapter_id = $user->chapter_id;
        } elseif ($user->role == 'department_admin') {
            $event->department_id = $user->department_id;
        }

        $event->save();

        return back()->with('success', 'Event created successfully!');
    }
}