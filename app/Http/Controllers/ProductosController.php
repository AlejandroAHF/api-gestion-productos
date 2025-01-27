<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Productos;

class ProductosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Productos::all();
        return response()->json(['mensaje' => 'Listado de productos', 'data' => $user]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'descripcion' => 'nullable',//nullable porque es un campo opcional
            'precio' => 'required',
            'stock' => 'required',
            'categoria' => 'nullable',//nullable porque es un campo opcional
            'estado' => 'required'
        ]);

        $producto = new Productos();
        $producto->nombre = $request->nombre;
        $producto->descripcion = $request->descripcion;
        $producto->precio = $request->precio;
        $producto->stock = $request->stock;
        $producto->categoria = $request->categoria;
        $producto->estado = $request->estado;
        $producto->save();

        return response()->json(['mensaje' => 'Producto creado', 'data' => $producto],200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id_producto)
    {
        $request->validate([
            'nombre' => 'required',
            'descripcion' => 'required',
            'precio' => 'required',
            'stock' => 'required',
            'categoria' => 'required'
        ]);

        $producto = Productos::find($id_producto);

        if(!$producto){
            return response()->json(['mensaje' => 'Producto no encontrado'],404);
        }

        $producto->nombre = $request->nombre;
        $producto->descripcion = $request->descripcion;
        $producto->precio = $request->precio;
        $producto->stock = $request->stock;
        $producto->categoria = $request->categoria;
        $producto->save();

        return response()->json(['mensaje' => 'Producto actualizado', 'data' => $producto], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $producto = Productos::find($id);

        if(!$producto){
            return response()->json(['mensaje' => 'Producto no encontrado'],404);
        }

        $producto->estado = false;
        $producto->save();

        return response()->json(['mensaje' => 'Producto eliminado', 'data' => $producto], 200);
    }
}
