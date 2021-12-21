<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
class loginController extends Controller

{
    //
    public function login(Request $request){
        $login =   $request->validate([
             'email'=>'required|string',
            'password'=>'required|string'
        ]);
        // return $request;
     if(!Auth::attempt($login)){
        return response(['message'=>'Invalid Login Credentials']);
     }
       $id_user = auth()->user()->id;
      $role = DB::table('personal_access_tokens')
      ->select(['token'])
         ->where('tokenable_id', $id_user)
         ->first();
 

     $client = DB::table('personal_access_tokens')
     ->select(['token'])
        ->where('tokenable_id', $id_user)
        ->first();

     $rol= DB::select("SELECT  rol FROM roleusers inner join roles on roles.id= roleusers.id_rol where roleusers.id_user='$id_user'");
     
     $newUser =auth()->user();
     $accessToken = $newUser->createToken('authToken')->accessToken;
     return response(['user'=> Auth::user(), 'access_token'=> $client,'rol'=>$rol]);
    }

    public function crear_usuario(Request $request){
        $nidentification = $request->input('nidentification');
        $names = $request->input('names');
        $last_name = $request->input('last_name');
        $telefono = $request->input('telefono');
        $email = $request->input('email');
        $password = $request->input('password');    
        //verificamos si existe
        $existe = DB::table('users')
        ->select(['identification'])
           ->where('identification', $nidentification)
           ->first(); 

           $existe_correo = DB::table('users')
           ->select(['email'])
              ->where('email', $email)
              ->first(); 
           
        if($existe!='' || $existe_correo !=''){
            return  response(['message'=>'El usuario ya existe, intenta con otra identificación o correo']);
            exit;
           }           
        
         DB::table('users')->insert(['name'=>$names,'email'=>$email,'password'=>Hash::make($password),'phone_number'=>$telefono,'identification'=>$nidentification,'last_name'=>$last_name]);
          $id_registrado = DB::table('users')
         ->select(['id'])
            ->where('identification', $nidentification)
            ->first();
         $id_registrado= $id_registrado->id;
          DB::table('roleusers')->insert(['id_rol'=>2,'id_user'=>$id_registrado]);
      
            return  response(['message'=>'Guardado con éxito']);
       
        
    }
}
