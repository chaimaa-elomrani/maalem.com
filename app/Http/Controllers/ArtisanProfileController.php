<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArtisanProfileController extends Controller
{


    public function show($id){
        $user = User::with(['artisan', 'posts', 'reviewsReceived.user'])->findOrFail($id);

        if($user->role !== 'artisan'){
            abort(404, 'Artisan not found'); 
        }

        $averageRating = $user->reviewsReceived->avg('rating') ?? 0;

        $reviewsCount = $user->reviewsReceived->count();
        $ratingDistribution = $user->reviewsReceived->groupBy('rating')->map(function ($items) {
            return $items->count();
        });

        return view('artisan.profile' , [
            'artisanUser' => $user, 
            'averageRating' => round($averageRating, 1),
            'reviewsCount' => $reviewsCount,
            'ratingDistribution' => $ratingDistribution
        ]);
    }

    public function dashboard(){
        $user = Auth::user();
        if($user->role !== 'artisan'){
            abort(403, 'Unauthorized access');
        }

        $user->load(['artisan', 'posts', 'reviewsReceived.user']); 
        return view('artisan.dashboard' , [
            'artisanUser' => $user, 
        ]); 
    }
}
