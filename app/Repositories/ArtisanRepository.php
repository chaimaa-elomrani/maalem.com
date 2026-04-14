<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\Artisan;

class ArtisanRepository
{
    public function getPaginatedArtisans(array $filters = [], int $perPage = 12)
    {
        $query = User::where('role', 'artisan')
            ->with(['artisan', 'reviewsReceived'])
            ->withCount('posts')
            ->has('artisan');

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('name', 'ilike', "%{$search}%")
                  ->orWhere('city', 'ilike', "%{$search}%")
                  ->orWhereHas('artisan', fn($q) => $q->where('service', 'ilike', "%{$search}%")
                      ->orWhere('workingArea', 'ilike', "%{$search}%"));
            });
        }

        if (!empty($filters['city'])) {
            $query->where('city', $filters['city']);
        }

        return $query->paginate($perPage)->withQueryString();
    }

    public function getArtisanCities()
    {
        return User::where('role', 'artisan')
            ->whereNotNull('city')
            ->distinct()
            ->pluck('city');
    }

    public function findWithDetails(int $id)
    {
        return User::with(['artisan', 'posts', 'reviewsReceived.user'])->findOrFail($id);
    }

    public function updateOrCreateProfile(int $userId, array $data)
    {
        $user = User::findOrFail($userId);
        return $user->artisan()->updateOrCreate(
            ['user_id' => $userId],
            $data
        );
    }
}
