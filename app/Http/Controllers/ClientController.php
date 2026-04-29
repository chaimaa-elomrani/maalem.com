<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    /**
     * Display the client dashboard.
     */
    public function dashboard()
    {
        $user = Auth::user();

        if ($user->role === 'artisan') {
            return redirect()->route('artisan.dashboard');
        } elseif ($user->role === 'mediateur') {
            return redirect()->route('mediateur.dashboard');
        }
        
        // Fetch liked posts for the dashboard - mapped to "Saved Artisans" in the new layout
        $likedPosts = Post::whereHas('likes', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->with(['artisan.user'])->latest()->limit(8)->get();

        $deliveryRequests = $user->client 
            ? $user->client->deliveryRequests()->with(['artisan.user', 'mediateur.user'])->latest()->get()
            : collect();

        $placeholderImages = [
          'Artisan Woman Weaving Traditional Moroccan Baskets.jpeg',
          'Broderie de Fez.jpeg',
          'L’Artisanat Marocain _ Un Héritage de Savoir-Faire Authentique.jpeg',
          'Pottery Painting, Morocco.jpeg',
          'Tapis Marocaine.jpeg',
          'artisanat au maroc - Page 7.jpeg',
          'image 26.png', 'image 34.png', 'image 35.png', 'image 36.png', 'image 37.png', 
          'image 38.png', 'image 39.png', 'image 40.png', 'image 41.png', 'image 42.png',
          'jpeg(1)',
          'Кожевенные красильни Марракеша.jpeg',
          'Разноцветье Марокко рядом.jpeg'
        ];

        return view('client.dashboard', compact('user', 'likedPosts', 'deliveryRequests', 'placeholderImages'));
    }
}
