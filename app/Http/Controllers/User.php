<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User as UserModel;


class User extends Controller
{
    //
    public function register(Request $request){
        $validator= Validator::make($request->all(),[
            "name" => "required|max:255|unique:users", 
            "email" => "required|max:255", 
            "password" => "required|max:255"
        ]);

        if($validator->fails()){
            return $validator->errors();
        }

        $user= UserModel::create([
            "name" => $request->name,
            "email" => $request->email,
            "user_type" => $request->user_type,
            "password" => Hash::make($request->password)
        ]);

        $token = $user->createToken("zyzy");

        return response([
            "user" => $user,
            "token"=> $token->plainTextToken
            
        ], 201);
    }
    public function logout(Request $request)
    {
        // Apaga o token atual do usuário
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logout realizado com sucesso'
        ]);
    }

    public function login(Request $request){
        $validator= Validator::make($request->all(),[
            "name" => "required|max:255", 
            "password" => "required|max:255"
        ],[
            "name.required" => "Nome de usuário é obrigatório!", 
            "password.required" => "A senha é obrigatória!", 
        ]);

        if($validator->fails()){
            return response($validator->errors(),401);
        }

        $user= UserModel::where("name","=",$request->name)->first();

        if(!$user || !Hash::check($request->password,$user->password)){
            return response()->json([
            "message" => "Usuário ou senha inválidos!"
            ],401);
        }

        $token = $user->createToken("zyzy");

        return response([
            "user"  => $user,
            "token" => $token->plainTextToken
            ], 200);
        }
}
