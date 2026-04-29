<?php

namespace App\Http\Controllers;

use App\Models\Reviews;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Store a newly created review in storage.
     */
    public function store(Request $request, User $artisanUser)
    {
        $request->validate([
            'note' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $currentUser = Auth::user();

        // Check if current user is a client (or at least, isn't reviewing themselves)
        if ($currentUser->role !== 'client') {
            return back()->with('error', 'Only clients can leave reviews.');
        }

        if ($currentUser->id === $artisanUser->id) {
            return back()->with('error', 'You cannot review yourself.');
        }

        // Optional: restrict to one review per artisan
        $existingReview = Reviews::where('client_id', $currentUser->id)
            ->where('artisan_id', $artisanUser->id)
            ->first();

        if ($existingReview) {
            return back()->with('error', 'You have already reviewed this artisan.');
        }

        Reviews::create([
            'client_id' => $currentUser->id,
            'artisan_id' => $artisanUser->id,
            'note' => $request->note,
            'comment' => $request->comment,
        ]);

        $artisanUser->notify(new \App\Notifications\ReviewReceived($currentUser->name, $request->note, $artisanUser->id));

        return back()->with('success', 'Review submitted successfully!');
    }
}
