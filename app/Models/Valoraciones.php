<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Valoraciones extends Authenticatable implements JWTSubject
{
    protected $table = 'valoraciones';

    protected $fillable = ['id_producto', 'calificacion', 'comentario'];

    protected $hidden = ['created_at', 'updated_at'];

    public function Productos()
    {
        return $this->belongsTo(Productos::class, 'id_producto');
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
