<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Categories;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Categories::create([
            'name' => 'Deportivos',
        ]);

        Categories::create([
            'name' => 'Casuales',
        ]);

        Categories::create([
            'name' => 'Formales',
        ]);

        Categories::create([
            'name' => 'Botas',
        ]);

        Categories::create([
            'name' => 'Sandalias',
        ]);

        Categories::create([
            'name' => 'Zapatillas',
        ]);

        Categories::create([
            'name' => 'Mocasines',
        ]);

        Categories::create([
            'name' => 'Otros',
        ]);
    }
}