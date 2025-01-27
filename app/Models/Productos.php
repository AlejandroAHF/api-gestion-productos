<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Productos extends Authenticatable
{
    protected $fillabble = ['nombre', 'descripcion', 'precio', 'stock', 'categoria', 'estado'];

    protected $hidden = ['created_at', 'updated_at'];

    public function Valoraciones()
    {
        return $this->hasMany(Valoraciones::class, 'id_producto');
    }
}
