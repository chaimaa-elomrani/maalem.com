<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Artisan;
use App\Models\Client;
use App\Models\Mediateur;
use App\Models\Post;
use App\Models\Reviews;
use App\Models\DeliveryRequest;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $faker = \Faker\Factory::create('fr_MA');

        // 1. Admin
        User::updateOrCreate(
            ['email' => 'admin@maalem.com'],
            [
                'name' => 'Admin Maalem',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'city' => 'Casablanca',
                'phone' => '0600000000'
            ]
        );

        // Assets
        $postImages = [
            'Artisan Shaping Clay into Beautiful Moroccan Pottery.jpeg',
            'Artisan Woman Weaving Traditional Moroccan Baskets.jpeg',
            'Broderie de Fez.jpeg',
            'HeinrichDinkelacker http___www_cuv.jpeg',
            'L’Artisanat Marocain _ Un Héritage de Savoir-Faire Authentique.jpeg',
            'Moroccan Argan oil.jpeg',
            'Pottery Painting, Morocco.jpeg',
            'Tapis Marocaine.jpeg',
            'Threads of tradition — Moroccan women weaving heritage by hand_”.jpeg',
            'Zapatería de la familia Mohedo_ Talabartería y taller de cuero, Montoro (Córdoba).jpeg',
            'artisanat au maroc - Page 7.jpeg',
            'artjpeg(1) (2)',
            'image 26.png', 'image 34.png', 'image 35.png', 'image 36.png', 'image 37.png', 
            'image 38.png', 'image 39.png', 'image 40.png', 'image 41.png', 'image 42.png',
            'jpeg(1)', 'jpeg(3)', 'jpeg(4)', 'jpeg(5)',
            'vintage shoe cobbler tools.jpeg',
            'Кожевенные красильни Марракеша.jpeg',
            'Разноцветье Марокко рядом.jpeg'
        ];

        $crafts = ['Pottery', 'Weaving', 'Carpentry', 'Leatherwork', 'Zellidj', 'Metalwork', 'Embroidery'];
        $cities = ['Casablanca', 'Marrakech', 'Fes', 'Tangier', 'Rabat', 'Agadir', 'Meknes'];
        
        $neighborhoods = [
            'Casablanca' => ['Gauthier', 'Maarif', 'Anfa', 'Ain Diab', 'Bourgogne'],
            'Marrakech' => ['Guéliz', 'Hivernage', 'Medina', 'Sidi Mimoun', 'Daudiate'],
            'Rabat' => ['Hay Riad', 'Agdal', 'Souissi', 'Océan', 'Hassan'],
            'Fes' => ['Ville Nouvelle', 'Batha', 'Narjiss', 'Fes el Bali'],
            'Tangier' => ['Malabata', 'Marchan', 'Iberia', 'California'],
            'Agadir' => ['Marina', 'Talborjt', 'Cité Essalam', 'Founty'],
            'Meknes' => ['Hamria', 'Mansour', 'Médina'],
        ];

        // 2. Mediators
        $mediators = [];
        for ($i = 1; $i <= 3; $i++) {
            $mUser = User::create([
                'name' => $faker->name(),
                'email' => "mediator$i@maalem.com",
                'password' => Hash::make('password'),
                'role' => 'mediateur',
                'city' => $cities[array_rand($cities)],
                'phone' => '06' . rand(10000000, 99999999)
            ]);
            $mediators[] = Mediateur::create(['user_id' => $mUser->id]);
        }

        // 3. Artisans
        $artisans = [];
        for ($i = 1; $i <= 12; $i++) {
            $city = $cities[array_rand($cities)];
            $hood = $neighborhoods[$city][array_rand($neighborhoods[$city])];
            
            $aUser = User::create([
                'name' => $faker->name(),
                'email' => "artisan$i@maalem.com",
                'password' => Hash::make('password'),
                'role' => 'artisan',
                'city' => $city,
                'phone' => '06' . rand(10000000, 99999999)
            ]);

            $artisan = Artisan::create([
                'user_id' => $aUser->id,
                'service' => $crafts[array_rand($crafts)],
                'workingArea' => $city,
                'experience' => rand(5, 25) . ' years',
                'workshopAdresse' => "N° " . rand(1,100) . " Rue " . $neighborhoods[$city][array_rand($neighborhoods[$city])] . ", " . $hood . ", " . $city,
                'status' => 'approved',
                'disponibility' => ['Mon', 'Tue', 'Wed', 'Thu', 'Fri'],
                'certifications' => ['Master Artisan Level', 'Championship of Crafts']
            ]);
            $artisans[] = $artisan;

            for ($j = 1; $j <= 3; $j++) {
                // Select 1 to 3 random images for each post
                $numImages = rand(1, 3);
                $selectedImages = (array) array_rand(array_flip($postImages), $numImages);

                Post::create([
                    'artisan_id' => $artisan->id,
                    'title'       => $crafts[array_rand($crafts)] . " " . $faker->word(),
                    'description' => "Traditional Moroccan work created with passion in our workshop in " . $city . ". Verified authentic craft.",
                    'images'      => array_values($selectedImages),
                    'category'    => $artisan->service,
                    'tags'        => ['Handmade', 'Morocco', $artisan->service, 'Authentic']
                ]);
            }
        }

        // 4. Clients
        for ($i = 1; $i <= 10; $i++) {
            $cUser = User::create([
                'name' => $faker->name(),
                'email' => "client$i@maalem.com",
                'password' => Hash::make('password'),
                'role' => 'client',
                'city' => $cities[array_rand($cities)],
                'phone' => '06' . rand(10000000, 99999999)
            ]);

            $client = Client::create(['user_id' => $cUser->id]);

            // Give some reviews to random artisans
            $targetArtisans = (array) array_rand($artisans, 3);
            foreach ($targetArtisans as $idx) {
                Reviews::create([
                    'artisan_id' => $artisans[$idx]->user_id, // Reviews use user_id
                    'client_id' => $cUser->id, // reviews use user_id
                    'note' => rand(4, 5),
                    'comment' => $faker->sentence(10)
                ]);
            }

            $targetArtisan = $artisans[array_rand($artisans)];
            $targetMediator = $mediators[array_rand($mediators)];
            
            DeliveryRequest::create([
                'client_id' => $client->id, // delivery_requests use clients.id
                'artisan_id' => $targetArtisan->id, // delivery_requests use artisans.id
                'mediateur_id' => $targetMediator->id,
                'description' => "Request for " . $targetArtisan->service . " handling in " . $cUser->city . ".",
                'status' => 'pending',
                'adresse' => $neighborhoods[$cUser->city][array_rand($neighborhoods[$cUser->city])] . ", " . $cUser->city
            ]);
        }
    }
}
