<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ArtisanService;
use Illuminate\Support\Facades\Auth;

class ArtisanProfileController extends Controller
{
    protected $artisanService;

    public function __construct(ArtisanService $artisanService)
    {
        $this->artisanService = $artisanService;
    }

    public function index(Request $request)
    {
        $filters = $request->only(['search', 'city']);
        $artisans = $this->artisanService->getArtisans($filters);
        $cities = $this->artisanService->getCities();

        return view('artisans.index', compact('artisans', 'cities'));
    }

    public function show($id)
    {
        $profile = $this->artisanService->getArtisanProfile($id);

        if (!$profile) {
            abort(404, 'Artisan not found');
        }

        return view('artisan.profile', $profile);
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
        $data = $request->validate([
            'service'         => ['required', 'string', 'max:255'],
            'workingArea'     => ['required', 'string', 'max:255'],
            'experience'      => ['required', 'string'],
            'workshopAdresse' => ['required', 'string', 'max:255'],
            'disponibility'   => ['nullable', 'array'],
            'certifications'  => ['nullable', 'string'],
        ]);

        $this->artisanService->setupProfile(Auth::user(), $data);

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
