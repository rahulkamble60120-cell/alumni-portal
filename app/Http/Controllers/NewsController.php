<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News; // Ensure you have a News model
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    // 1. Show News Page
    public function index()
    {
        // Fetch all news, latest first
        $news = News::orderBy('created_at', 'desc')->get();
        
        // Return the view located at resources/views/admin/news/index.blade.php
        return view('admin.news.index', compact('news'));
    }

    // 2. Store News
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'image' => 'nullable|image|max:2048' // Optional image
        ]);

        $news = new News();
        $news->title = $request->title;
        $news->content = $request->content;
        $news->category = $request->category ?? 'general';
        $news->user_id = Auth::id(); // Author

        // Handle Image Upload
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('news_images', 'public');
            $news->image_path = $path;
        }

        $news->save();

        return back()->with('success', 'News article published!');
    }

    // 3. Delete News
    public function destroy($id)
    {
        $news = News::findOrFail($id);
        $news->delete();
        return back()->with('success', 'Article deleted.');
    }
}