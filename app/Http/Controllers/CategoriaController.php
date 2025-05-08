<?php

namespace App\Http\Controllers;

use App\Models\Categoria; // Asegúrate de importar el modelo Category
use App\Models\Task; // Asegúrate de importar el modelo Task si lo estás utilizando
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoriaController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Obtiene todas las categorías de la base de datos
        $categories = Categoria::all(); 
        
        // Pasa las categorías a la vista "Tareas"
        return inertia('Tareas', [
            'categories' => $categories
        ]);
    }

    // Otros métodos del controlador...
}