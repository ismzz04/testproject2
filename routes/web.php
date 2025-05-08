<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\ZapatosController;
use App\Http\Controllers\CategoryController;
use App\Models\Zapatos;
use App\Models\Categories;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'zapatos' => Zapatos::with('category')->get(),
        'categories' => Categories::all(),
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('zapatos', ZapatosController::class);   
// ->middleware(['auth']);
Route::resource('categories', CategoryController::class);

require __DIR__.'/auth.php';