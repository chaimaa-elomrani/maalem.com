<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function index(){
        $posts = Post::with('artisan.user')->latest()->paginate(12);
        return view('feed', compact('posts'));
    }

    public function create(){
        
        return view('posts.create'); 
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'images'      => 'required|array|min:1',
            'images.*'    => 'image|mimes:jpeg,png,jpg,gif|max:5120',
            'category'    => 'required|string',
            'tags'        => 'nullable|string',
        ]);

        $user = auth()->user();
        if (!$user->artisan) {
            return redirect()->back()->withErrors(['artisan' => 'User profile not found.']);
        }

        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('posts', 'public');
                $imagePaths[] = $path;
            }
        }

        $tagsArray = [];
        if ($request->tags) {
            $tagsArray = array_map('trim', explode(',', $request->tags));
        }

        Post::create([
            'artisan_id'  => $user->artisan->id,
            'title'       => $request->title,
            'description' => $request->description,
            'images'      => $imagePaths,
            'category'    => $request->category,
            'tags'        => $tagsArray,
        ]);

        return redirect()->route('artisan.dashboard')->with('success', 'Your craft has been listed successfully!');
    }
}
