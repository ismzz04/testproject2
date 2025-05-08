<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Categoria;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


        Categoria::create([
            'title' => 'prioridad baja',
        ]);

        Categoria::create([
            'title' => 'prioridad media',
        ]);

        Categoria::create([
            'title' => 'Urgente',
        ]);

        Categoria::create([
            'title' => 'Super Urgente',
        ]);

    }
}