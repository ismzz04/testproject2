<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    protected $table = 'categories';

    protected $fillable = [
        'name',
    ];

    // Añadir la relación con Zapatos
    public function zapatos()
    {
        return $this->hasMany(Zapatos::class, 'category_id');
    }

    // Método para eliminar la categoría y sus zapatos asociados
    public function delete()
    {
        // Primero eliminar todos los zapatos asociados
        $this->zapatos()->delete();
        
        // Luego eliminar la categoría
        return parent::delete();
    }
}