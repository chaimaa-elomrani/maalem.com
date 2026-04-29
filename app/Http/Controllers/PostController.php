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

    public function edit(Post $post)
    {
        $user = auth()->user();
        if (!$user->artisan || $post->artisan_id !== $user->artisan->id) {
            abort(403, 'Unauthorized');
        }

        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $user = auth()->user();
        if (!$user->artisan || $post->artisan_id !== $user->artisan->id) {
            abort(403, 'Unauthorized');
        }

        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'images'      => 'nullable|array',
            'images.*'    => 'image|mimes:jpeg,png,jpg,gif|max:5120',
            'category'    => 'required|string',
            'tags'        => 'nullable|string',
        ]);

        $this->postService->updatePost($post, $data);

        return redirect()->route('artisan.dashboard')->with('success', 'Your craft listing has been updated!');
    }

    public function destroy(Post $post)
    {
        $user = auth()->user();

        // Only the owning artisan can delete their post
        if (!$user->artisan || $post->artisan_id !== $user->artisan->id) {
            abort(403, 'Unauthorized');
        }

        $post->delete();

        return redirect()->route('artisan.dashboard')->with('success', 'Listing deleted successfully.');
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
