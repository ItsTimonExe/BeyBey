<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // Import correct

class CategorySeeder extends Seeder
{
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        // Vider la table avant d'inserer de nouvelles données
        DB::table('categories')->truncate();

        $categories = [
            [
                'id' => 1,
                'name' => 'T-Shirt',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'name' => 'Hoodies',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'name' => 'Pants',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4,
                'name' => 'Accessories',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        // Insérer les données dans la table
        DB::table('categories')->insert($categories);
    }
}
