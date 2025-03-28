<?php

use App\Http\Controllers\ItemController;
use Illuminate\Support\Facades\Route;

// Ruta para mostrar formulario de búsqueda (GET)
Route::get('/items/buscar', [ItemController::class, 'buscar'])->name('items.buscar');

// Ruta para procesar búsqueda (POST)
Route::post('/items/buscar', [ItemController::class, 'search'])->name('items.search');

// El resource debe ir después de las rutas personalizadas
Route::resource('items', ItemController::class)->except(['buscar']);