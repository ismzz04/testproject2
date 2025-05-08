<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $fillable = ['title'];
    public function task(){
        return $this->hasMany(task::class);
    }
}