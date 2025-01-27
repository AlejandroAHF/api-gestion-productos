<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductosController;
use App\Http\Controllers\ValoracionesController;
use App\Http\Controllers\UsersController;
use App\Http\Middleware\AuthMiddleware;

Route::apiResource('productos',ProductosController::class)->middleware(AuthMiddleware::class);

Route::apiResource('valoraciones',ValoracionesController::class)->middleware(AuthMiddleware::class);

Route::post('registro',[UsersController::class,'registro']);
Route::post('login',[UsersController::class,'login']);