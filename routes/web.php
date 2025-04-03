<?php

use App\Http\Controllers\ItemController;
use Illuminate\Support\Facades\Route;

// Ruta para mostrar formulario de búsqueda (GET)
Route::get('/items/buscar', [ItemController::class, 'buscar'])->name('items.buscar');

// Ruta para procesar búsqueda (POST)
Route::post('/items/buscar', [ItemController::class, 'search'])->name('items.search');

// El resource debe ir después de las rutas personalizadas
Route::resource('items', ItemController::class)->except(['buscar']);

Route::get('/produccion', [ItemController::class, 'produccionForm'])->name('produccion.form');
Route::post('/produccion/buscar', [ItemController::class, 'searchForProduction'])->name('produccion.buscar');
Route::post('/produccion/{id}/agregar', [ItemController::class, 'addProduction'])->name('produccion.agregar');
Route::get('/produccion/{id}/historial', [ItemController::class, 'verProduccion'])->name('produccion.historial');
Route::view('/lista', 'items.lista')->name('items.lista');

Route::get('/', [ItemController::class, 'index'])->name('inicio');