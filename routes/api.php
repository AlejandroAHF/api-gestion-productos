<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductosController;
use App\Http\Controllers\ValoracionesController;

Route::apiResource('productos',ProductosController::class);

Route::apiResource('valoraciones',ValoracionesController::class);