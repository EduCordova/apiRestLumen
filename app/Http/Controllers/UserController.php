<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
  function index(Request $request) {
    if($request->isJson())
    {
      $users = User::all();
      return response()->json($users,200);
    }
    return response()->json(['Error'=>'No Autorizado'],401); // 401 sin permisos
  }

  function createUser(Request $request)
  {
    if($request->isJson()){
      $this->validate($request,[
        'name'=> 'required',
        'email'=> 'required|email|unique:users',
      ]);
      $data = $request->json()->all();
      $user = User::create([
        'name' => $data['name'],
        'username' => $data['username'],
        'email' => $data['email'],
        'password' => Hash::make($data['password']),
        'api_token' => str_random(60)
      ]);
      return  response()->json($user,201);//201 creacion!!
    }
    return response()->json(['Error'=>'No Autorizado'],401);
  }
  
  function getToken(Request $request)
  {
    if ($request->isJson()) {
      try{
        $data = $request->json()->all();
        $user = User::where('username',$data['username'])->first();
        if($user && Hash::check($data['password'], $user->password))
        {
          return response()->json($user, 200);
        } else {
          return response()->json(['Error'=>'Sin Coincidencias'], 406);
        }
      }catch(ModelNotFoundException $e) {
        return response()->json(['Error'=>'No Content'], 406);
      }
    }
    return response()->json(['Error'=>'No Autorizado'],401); // 401 sin permisos
  }

  function deleteUser($id, Request $request) 
  {
    if($request->isJson()) 
    {
  
      // try {
      //   User::findOrFail($id)->delete();
      //   return response('Eliminado con Exito', 200);
      // }catch(ModelNotFoundException $e) {
      //   return response()->json(['Error'=> 'SIN DATOS'],406);
      // }
      $res = User::where('id',$id)->delete();
      if($res == 1) {
        return response()->json(['msg'=>'Eliminado con Exito'], 200);
      } else {
        return response()->json(['Error'=>'No se Encontro Coincidencias'],404);
      }
    }
    return response()->json(['Error'=>'No Autorizado'],401);
  }

  function updateUser($id, Request $request)
  {
    if($request->isJson())
    {
      $res = User::findOrFail($id);
      $res->update($request->all());
      return response()->json($res,200);
    }
    return response()->json(['Error'=>'No Autorizado'],401);
  }
}
