<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArtisanProfileController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'artisan')
            ->with(['artisan', 'reviewsReceived'])
            ->withCount('posts')
            ->has('artisan');

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'ilike', "%{$search}%")
                  ->orWhere('city', 'ilike', "%{$search}%")
                  ->orWhereHas('artisan', fn($q) => $q->where('service', 'ilike', "%{$search}%")
                      ->orWhere('workingArea', 'ilike', "%{$search}%"));
            });
        }

        if ($city = $request->input('city')) {
            $query->where('city', $city);
        }

        $artisans = $query->paginate(12)->withQueryString();

        $cities = User::where('role', 'artisan')
            ->whereNotNull('city')
            ->distinct()
            ->pluck('city');

        return view('artisans.index', compact('artisans', 'cities'));
    }

    public function show($id)
    {
        $user = User::with(['artisan', 'posts', 'reviewsReceived.user'])->findOrFail($id);

        if ($user->role !== 'artisan') {
            abort(404, 'Artisan not found');
        }

        $averageRating = $user->reviewsReceived->avg('rating') ?? 0;
        $reviewsCount  = $user->reviewsReceived->count();
        $ratingDistribution = $user->reviewsReceived->groupBy('rating')->map(fn($items) => $items->count());

        return view('artisan.profile', [
            'artisanUser'        => $user,
            'averageRating'      => round($averageRating, 1),
            'reviewsCount'       => $reviewsCount,
            'ratingDistribution' => $ratingDistribution,
        ]);
    }

    public function setupForm()
    {
        $user = Auth::user();

        if ($user->role !== 'artisan') {
            abort(403);
        }

        return view('artisan.setup', ['user' => $user]);
    }

    public function setupStore(Request $request)
    {
        $user = Auth::user();

        if ($user->role !== 'artisan') {
            abort(403);
        }

        $request->validate([
            'service'         => ['required', 'string', 'max:255'],
            'workingArea'     => ['required', 'string', 'max:255'],
            'experience'      => ['required', 'string'],
            'workshopAdresse' => ['required', 'string', 'max:255'],
            'disponibility'   => ['nullable', 'array'],
            'certifications'  => ['nullable', 'string'],
        ]);

        $certifications = array_filter(
            array_map('trim', explode(',', $request->certifications ?? ''))
        );

        $user->artisan()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'service'         => $request->service,
                'workingArea'     => $request->workingArea,
                'experience'      => $request->experience,
                'workshopAdresse' => $request->workshopAdresse,
                'disponibility'   => $request->disponibility ?? [],
                'certifications'  => array_values($certifications),
                'status'          => 'active',
            ]
        );

        return redirect()->route('artisan.dashboard');
    }

    public function dashboard()
    {
        $user = Auth::user();

        if ($user->role !== 'artisan') {
            abort(403, 'Unauthorized');
        }

        if (!$user->artisan || !$user->artisan->service) {
            return redirect()->route('artisan.setup');
        }

        $user->load(['artisan', 'posts', 'reviewsReceived.user']);

        return view('artisan.dashboard', ['artisanUser' => $user]);
    }
}
