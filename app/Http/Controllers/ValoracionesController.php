<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Valoraciones;
use App\Models\Productos;

class ValoracionesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productoMejorValorado = Productos::select('productos.*') // Selecciona todas las columnas de productos
            ->withAvg('valoraciones', 'calificacion') // Calcula el promedio de calificaciones
            ->orderByDesc('valoraciones_avg_calificacion') // Usa el alias generado por withAvg
            ->first();

        if (!$productoMejorValorado) {
            return response()->json(['mensaje' => 'No hay productos con valoraciones'], 404);
        }

        return response()->json([
            'mensaje' => 'Producto con mejor valoración',
            'data' => $productoMejorValorado
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_producto' => 'required',
            'calificacion' => 'required',
            'comentario' => 'required'
        ]);

        $valoraciones = new Valoraciones();
        $valoraciones->id_producto = (int) $request->id_producto;
        $valoraciones->calificacion = (int) $request->calificacion;
        $valoraciones->comentario = $request->comentario;
        $valoraciones->save();

        return response()->json(['mensaje' => 'Valoración creada', 'data' => $valoraciones], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $producto = Productos::with('valoraciones')->find($id);

        if (!$producto) {
            return response()->json(['mensaje' => 'Producto no encontrado'], 404);
        }

        $valoraciones = [
            'producto' => [
                'nombre' => $producto->nombre,
                'precio' => $producto->precio,
                'categoria' => $producto->categoria,
                'valoraciones' => $producto->valoraciones->map(function ($valoracion) {
                    return [
                        'calificacion' => $valoracion->calificacion,
                        'comentario' => $valoracion->comentario,
                    ];
                }),
            ],
        ];

        return response()->json(['mensaje' => 'Valoraciones del producto', 'data' => $valoraciones], 200);
    }
}
