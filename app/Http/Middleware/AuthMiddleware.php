<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        //de esta manera hacemos la proteccion de rutas
        try{
            //verificamos si el token es correcto
            $user = JWTAuth::parseToken()->authenticate();
        }catch(Exception $e){

            //verificamos si el token es valido
            if($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                return response()->json(['messae'=>'token is invalid'],401);
            //verificamos si el token ya expiro
            }else if($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                return response()->json(['messae'=>'token is expired'],401);
            }else{
                return response()->json(['messae'=>'authorized token not found'],401);
            }

            return response()->json(['message'=>'Unauthorized'],401);
        }
        return $next($request);
    }
}
