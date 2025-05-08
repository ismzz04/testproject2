<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Categories;

class CategoryController extends Controller
{
    /**
     * Muestra la lista de todas las categorías.
     */
    public function index()
    {
        // Devuelve la vista 'ListCategories' con todas las categorías
        return Inertia::render('ListCategories', [
            'categories' => Categories::all()
        ]);
    }

    /**
     * Muestra el formulario para crear una nueva categoría.
     */
    public function create()
    {
        // Devuelve la vista de creación de categorías
        return Inertia::render('CreateCategories');
    }

    /**
     * Guarda una nueva categoría en la base de datos.
     */
    public function store(Request $request)
    {
        // Valida los datos recibidos del formulario
        $validate = $request->validate([
            'name' => 'required',
        ]);

        // Crea la categoría en la base de datos
        Categories::create($validate);

        // Redirige a la lista de categorías
        return redirect()->route('categories.index');
    }

    /**
     * Muestra los detalles de una categoría específica.
     */
    public function show(Categories $category)
    {
        // Devuelve la vista de creación pero pasando la categoría (esto puede ser un error, normalmente sería una vista de show)
        return Inertia::render('CreateCategories',[
            'category' => $category
        ]);
    }

    /**
     * Muestra el formulario para editar una categoría.
     */
    public function edit(Categories $category)
    {
        // Devuelve la vista de edición con la categoría a editar
        return Inertia::render('EditCategories', [
            'category' => $category
        ]);
    }

    /**
     * Actualiza una categoría en la base de datos.
     */
    public function update(Request $request, Categories $category)
    {
        // Valida los datos recibidos del formulario
        $validate = $request->validate([
            'name' => 'required|max:255',
        ]);

        // Actualiza la categoría en la base de datos
        $category->update($validate);
        // Redirige a la lista de categorías
        return redirect()->route('categories.index');
    }

    /**
     * Elimina una categoría de la base de datos.
     */
    public function destroy(Categories $category)
    {
        // Elimina la categoría
        $category->delete();
        // Redirige a la lista de categorías
        return redirect()->route('categories.index');
    }
}