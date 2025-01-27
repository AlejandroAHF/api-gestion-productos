<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Productos extends Authenticatable implements JWTSubject
{
    protected $fillabble = ['nombre', 'descripcion', 'precio', 'stock', 'categoria', 'estado'];

    protected $hidden = ['created_at', 'updated_at'];

    public function Valoraciones()
    {
        return $this->hasMany(Valoraciones::class, 'id_producto');
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
