<?php

namespace App\Services;

use App\Repositories\ArtisanRepository;
use App\Models\User;

class ArtisanService
{
    protected $artisanRepository;

    public function __construct(ArtisanRepository $artisanRepository)
    {
        $this->artisanRepository = $artisanRepository;
    }

    public function getArtisans(array $filters = [], int $perPage = 12)
    {
        return $this->artisanRepository->getPaginatedArtisans($filters, $perPage);
    }

    public function getCities()
    {
        return $this->artisanRepository->getArtisanCities();
    }

    public function getArtisanProfile(int $id)
    {
        $user = $this->artisanRepository->findWithDetails($id);
        
        if ($user->role !== 'artisan') {
            return null;
        }

        $reviews = $user->reviewsReceived;
        
        return [
            'artisanUser'        => $user,
            'averageRating'      => round($reviews->avg('note') ?? 0, 1),
            'reviewsCount'       => $reviews->count(),
            'ratingDistribution' => $reviews->groupBy('note')->map->count(),
        ];
    }

    public function setupProfile(User $user, array $data)
    {
        $certifications = array_filter(
            array_map('trim', explode(',', $data['certifications'] ?? ''))
        );

        return $this->artisanRepository->updateOrCreateProfile($user->id, [
            'service'         => $data['service'],
            'workingArea'     => $data['workingArea'],
            'experience'      => $data['experience'],
            'workshopAdresse' => $data['workshopAdresse'],
            'disponibility'   => $data['disponibility'] ?? [],
            'certifications'  => array_values($certifications),
            'status'          => 'active',
        ]);
    }
}
