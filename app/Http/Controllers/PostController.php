<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PostService;
use App\Models\Post;

class PostController extends Controller
{
    protected $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function index(Request $request)
    {
        $filters = $request->only(['search', 'category']);
        $posts = $this->postService->getFeed($filters, 12);
        
        if ($request->expectsJson()) {
            return response()->json($posts);
        }
        
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

    public function toggleLike(Post $post)
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }
        
        $like = $post->likes()->where('user_id', $user->id)->first();
        
        if ($like) {
            $like->delete();
            $isLiked = false;
        } else {
            $post->likes()->create(['user_id' => $user->id]);
            $isLiked = true;
        }
        
        return response()->json([
            'isLiked' => $isLiked,
            'likesCount' => $post->likes()->count()
        ]);
    }
}
