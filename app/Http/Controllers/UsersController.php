<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class UsersController extends Controller
{
    public function registro(Request $request)
    {
        //validamos el recibimento de los datos de el parametro
        $request->validate([
            'name'=>'required',
            'email'=>'required|email|unique:users,email',
            'password'=>'required'
        ]);

        //verificamos si el email existe en la base de datos
        $user = User::where('email',$request->email)->exists();//al hacer esta consulta devuelve un valor booleano

        if($user){
            return response()->json(['mensaje'=>'el correo electtronico ya existe'],400);
        }

        //crear un nuevo usuario
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();
        return response()->json(["mensaje"=>"usuario creado",'data'=>$user]);
    }

    public function login(Request $request){
        //Obtener credenciales
        $credentials = $request->only('email','password');

        //Verificar credenciales
        $user = User::where('email',$credentials['email'])->first();
        if(!$user){
            return response()->json(['message'=>'correo invalido'],401);
        }

        //Verificar password
        if(!password_verify($credentials['password'],$user->password)){
            return response()->json(['message'=>'contraña invalida'],401);
        }

        //generar un token
        $token = JWTAuth::fromUser($user);

        return response()->json(["message"=>"login",'data'=>'token: '.$token]);
    }
}
