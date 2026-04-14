<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PostService;

class PostController extends Controller
{
    protected $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function index()
    {
        $posts = $this->postService->getFeed(12);
        return view('feed', compact('posts'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'images'      => 'required|array|min:1',
            'images.*'    => 'image|mimes:jpeg,png,jpg,gif|max:5120',
            'category'    => 'required|string',
            'tags'        => 'nullable|string',
        ]);

        $user = auth()->user();
        if (!$user->artisan) {
            return redirect()->back()->withErrors(['artisan' => 'Artisan profile not found.']);
        }

        $this->postService->storePost($data, $user->artisan->id);

        return redirect()->route('artisan.dashboard')->with('success', 'Your craft has been listed successfully!');
    }
}
