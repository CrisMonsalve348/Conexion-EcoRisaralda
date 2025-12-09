<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\preferenceController;
use App\Http\Controllers\TuristicPlaceController;
use Illuminate\Support\Facades\Route;
//Laravel default web routes file
Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


//preferences routes


Route::get('/preferencias', [preferenceController::class, 'mostrardatosdepreferencias'])
    ->middleware(['auth', 'verified'])
    ->name('preferencias');
Route::post('/preferencias', [preferenceController::class, 'validarpreferencias'])
    ->middleware(['auth', 'verified'])
    ->name('preferencias');

//crear sitio ecoturistico
Route::get('/Crear_sitio', [TuristicPlaceController::class, 'crear'])
    ->middleware(['auth', 'verified'])
    ->name('crear_sitio');

Route::post('/Crear_sitio', [TuristicPlaceController::class, 'validarsitio'])
    ->middleware(['auth', 'verified'])
    ->name('guardar_sitio');

require __DIR__.'/auth.php';
