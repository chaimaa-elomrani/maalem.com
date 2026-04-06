<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function index(){
        $posts = Post::with('user')->latest()->paginate(12);
        return view('feed', compact('posts'));
    }

    public function create(){
        
        return view('posts.create'); 
    }

    public function store(Request $request){
        $request->validate([
            'title'=> 'required|string|max:255',
            'description'=> 'required|string',
            'images'=> 'required|array',
            'images.*'=> 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'category'=> 'required|string',
            'tags'=> 'required|array',
            'tags.*'=> 'string',
        ]);
        $post = Post::create([
            'title'=> $request->title,
            'description'=> $request->description,
            'images'=> $request->images,
            'category'=> $request->category,
            'tags'=> $request->tags,
        ]);

        return redirect()->route('feed')->with('success','');
    }
}
