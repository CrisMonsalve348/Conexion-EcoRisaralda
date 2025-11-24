<?php

use App\Http\Controllers\ProfileController;
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
Route::get('/preferencias', function (){
    return view('preferencias');
})->middleware(['auth', 'verified'])->name('preferencias');
require __DIR__.'/auth.php';
