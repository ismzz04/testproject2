<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Zapatos;
use App\Models\Categories;

class ZapatosSeeder extends Seeder
{
    public function run(): void
    {
        // Asegurarse de que existan categorías primero
        $categories = Categories::all();
        
        if ($categories->isEmpty()) {
            $this->call(CategorySeeder::class);
            $categories = Categories::all();
        }

        // Array de zapatos de ejemplo
        $zapatos = [
            [
                'name' => 'Nike Air Max',
                'description' => 'Zapatillas deportivas con tecnología Air Max',
                'number' => '42',
                'category_id' => $categories->where('name', 'Deportivos')->first()->id,
                'photo' => 'zapatos/nike-air-max.jpg'
            ],
            [
                'name' => 'Adidas Superstar',
                'description' => 'Zapatillas clásicas de cuero',
                'number' => '41',
                'category_id' => $categories->where('name', 'Deportivos')->first()->id,
                'photo' => 'zapatos/adidas-superstar.jpg'
            ],
            [
                'name' => 'Vans Old Skool',
                'description' => 'Zapatillas casuales de skate',
                'number' => '40',
                'category_id' => $categories->where('name', 'Casuales')->first()->id,
                'photo' => 'zapatos/vans-old-skool.jpg'
            ],
            [
                'name' => 'Converse Chuck Taylor',
                'description' => 'Zapatillas casuales de lona',
                'number' => '39',
                'category_id' => $categories->where('name', 'Casuales')->first()->id,
                'photo' => 'zapatos/converse-chuck.jpg'
            ],
            [
                'name' => 'Oxford Clásico',
                'description' => 'Zapatos formales de cuero',
                'number' => '43',
                'category_id' => $categories->where('name', 'Formales')->first()->id,
                'photo' => 'zapatos/oxford-classic.jpg'
            ],
            [
                'name' => 'Derby Elegante',
                'description' => 'Zapatos formales estilo derby',
                'number' => '42',
                'category_id' => $categories->where('name', 'Formales')->first()->id,
                'photo' => 'zapatos/derby-elegante.jpg'
            ],
        ];

        // Crear los zapatos
        foreach ($zapatos as $zapato) {
            Zapatos::create($zapato);
        }
    }
}