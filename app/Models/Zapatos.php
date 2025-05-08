<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Zapatos extends Model
{
    protected $fillable = [
        'name',
        'description',
        'number',
        'category_id',
        'photo'
    ];

    public function category()
    {
        return $this->belongsTo(Categories::class);
    }
}