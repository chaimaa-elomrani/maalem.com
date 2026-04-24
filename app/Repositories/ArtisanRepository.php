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
            ->withCount(['posts', 'reviewsReceived'])
            ->withAvg('reviewsReceived', 'note')
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

        if (!empty($filters['experience'])) {
            $experience = $filters['experience'];
            $query->whereHas('artisan', function($q) use ($experience) {
                // Approximate mapping for search in text field
                if ($experience === 'master') $q->where('experience', 'ilike', '%15+%');
                elseif ($experience === 'senior') $q->where('experience', 'ilike', '%8%');
                elseif ($experience === 'mid') $q->where('experience', 'ilike', '%3%');
                elseif ($experience === 'emerging') $q->where('experience', 'ilike', '%3%');
                else $q->where('experience', 'ilike', "%{$experience}%");
            });
        }

        if (!empty($filters['min_rating'])) {
            $query->having('reviews_received_avg_note', '>=', (float)$filters['min_rating']);
        }

        if (!empty($filters['availability'])) {
            $query->whereHas('artisan', fn($q) => $q->where('status', 'active'));
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
        return User::with(['artisan', 'posts.comments.user', 'reviewsReceived.user'])->findOrFail($id);
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
