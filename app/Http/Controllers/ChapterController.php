<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chapter;

class ChapterController extends Controller
{
    // Show list of chapters
    public function index()
    {
        // Get all chapters from the database
        $chapters = Chapter::all();
        return view('admin.chapters.index', compact('chapters'));
    }

    // Save a new chapter
    public function store(Request $request)
    {
        // Validate input
        $request->validate([
            'name' => 'required|string|max:255',
            'city' => 'nullable|string|max:255',
        ]);

        // Create the chapter
        Chapter::create([
            'institution_id' => 1, // Hardcoded for now (Super Admin Context)
            'name' => $request->name,
            'city' => $request->city,
        ]);

        return back()->with('success', 'Chapter created successfully!');
    }

    // Delete a chapter
    public function destroy($id)
    {
        Chapter::destroy($id);
        return back()->with('success', 'Chapter deleted.');
    }
}