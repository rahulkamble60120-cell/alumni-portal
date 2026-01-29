<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gallery;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    // 1. Show Gallery Page
    public function index()
    {
        // Get all photos, newest first
        $photos = Gallery::latest()->get();
        return view('admin.gallery.index', compact('photos'));
    }

    // 2. Upload Photo
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:2048', // Max 2MB
            'caption' => 'nullable|string|max:255'
        ]);

        // Save file to 'storage/app/public/gallery_uploads'
        $path = $request->file('image')->store('gallery_uploads', 'public');

        Gallery::create([
            'image_path' => $path,
            'caption' => $request->caption,
            'user_id' => Auth::id()
        ]);

        return back()->with('success', 'Photo uploaded successfully!');
    }

    // 3. Delete Photo
    public function destroy($id)
    {
        $photo = Gallery::findOrFail($id);

        // Delete the actual file from storage
        if (Storage::disk('public')->exists($photo->image_path)) {
            Storage::disk('public')->delete($photo->image_path);
        }

        $photo->delete();
        return back()->with('success', 'Photo deleted.');
    }
}