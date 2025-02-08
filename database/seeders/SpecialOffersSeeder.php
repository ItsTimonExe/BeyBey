<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SpecialOffer;

class SpecialOffersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SpecialOffer::create([
            'title' => '50% Off hoodies',
            'description' => 'Discover the best deals on trendy fashion items.',
            'image' => 'image/p1.jpg' // Chemin de votre image
        ]);

        SpecialOffer::create([
            'title' => 'Buy One, Get One Free',
            'description' => 'Exclusive offer on stylish clothing and fashion essentials.',
            'image' => 'image/bg.jpg' // Chemin de votre image
        ]);

        SpecialOffer::create([
            'title' => 'Homme Essentials',
            'description' => 'Up to 40% off your favorite fashion and clothing collections.',
            'image' => 'image/p3.jpg' // Chemin de votre image
        ]);
        SpecialOffer::create([
            'title' => 'Homme Essentials',
            'description' => 'Up to 40% off your favorite fashion and clothing collections.',
            'image' => 'image/p3.jpg' // Chemin de votre image
        ]);
        SpecialOffer::create([
            'title' => 'Homme Essentials',
            'description' => 'Up to 40% off your favorite fashion and clothing collections.',
            'image' => 'image/p3.jpg' // Chemin de votre image
        ]);
    }
}
