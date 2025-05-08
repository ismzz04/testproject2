<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class task extends Model
{
    protected $fillable = ['title', 'description','image','categoria_id'];

    public function Categoria(){
        return $this->belongsTo(Categoria::class);
    }
    

}