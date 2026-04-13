<?php
use App\Models\User;
use App\Models\Artisan;
use App\Models\Post;
use App\Models\Reviews;
use Illuminate\Support\Facades\Hash;

$user = User::firstOrCreate(
    ['email' => 'artisan@maalem.com'],
    [
        'name' => 'Fatima Al-Rouissi',
        'password' => Hash::make('password'),
        'phone' => '0612345678',
        'city' => 'Fès',
        'role' => 'artisan'
    ]
);

$artisan = Artisan::firstOrCreate(
    ['user_id' => $user->id],
    [
        'workingArea' => 'Pottery',
        'service' => 'Ceramic Master',
        'disponibility' => json_encode(['Mon - Fri, 9am - 6pm']),
        'experience' => 'Over 15 years of experience in traditional Moroccan pottery. I create handcrafted ceramic pieces that blend centuries-old techniques with contemporary design.',
        'certifications' => json_encode(['Traditional Pottery', 'Zellige Tiles', 'Hand-painting']),
        'workshopAdresse' => 'Fès el-Bali Medina',
        'status' => 'active',
        'noteMoyenne' => 4.9
    ]
);

if($user->posts()->count() == 0) {
    for($i = 1; $i <= 5; $i++) {
        Post::create([
            'artisan_id' => $user->id,
            'title' => 'Handpainted Product ' . $i,
            'description' => 'Beautiful authentic Moroccan item.',
            'category' => 'Ceramics',
            'images' => json_encode(['image 34.png'])
        ]);
    }
}

if($user->reviewsReceived()->count() == 0) {
    // We need a dummy user for the review
    $reviewer = User::firstOrCreate(
        ['email' => 'buyer@maalem.com'],
        ['name' => 'Sarah Johnson', 'password' => Hash::make('password'), 'city' => 'Casablanca', 'role' => 'client']
    );

    Reviews::create([
        'artisan_id' => $user->id,
        'user_id' => $reviewer->id,
        'rating' => 5,
        'comment' => 'Absolutely beautiful handcrafted work. The quality exceeded my expectations.'
    ]);
    Reviews::create([
        'artisan_id' => $user->id,
        'user_id' => $reviewer->id,
        'rating' => 4,
        'comment' => 'Great work, fast shipping.'
    ]);
}

echo "Seeding completed successfully! Test profile loaded with ID: " . $user->id . "\n";
