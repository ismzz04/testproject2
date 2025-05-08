<?php

namespace App\Http\Controllers;

use App\Models\Zapatos;
use App\Models\Categories;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        return Inertia::render('Welcome', [
            'zapatos' => Zapatos::with('category')->get(),
            'categories' => Categories::all(),
        ]);
    }
}