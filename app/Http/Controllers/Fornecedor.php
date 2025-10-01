<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fornecedor as FornecedorModel;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class Fornecedor extends Controller{
    public function adicionar(Request $request){
        $validator= Validator::make($request->all(),[
            "name" => "required|max:255|unique:fornecedors",
        ],[
            "name.required" => "O nome do fornecedor é obrigatório!",
            "name.unique" => "O nome do fornecedor já existe!"
        ]);

        if($validator->fails()){
            return response($validator->errors(),401);
        }

        $fornecedor = FornecedorModel::create([
            "name" => $request->name,
            "user_id" => $request->user()->id
        ]);

        return response()->json([
            "message" => "Fornecedor cadastrado com sucesso!"
        ],200);

    }

    public function selectName(Request $request){
        return FornecedorModel::where("name","=",$request->name)->get();
    }

    public function selectAll(Request $request){
        if(!($request->notpgnt)){
            if($request->search){
                return FornecedorModel::with("created_by")->where("name","like","%{$request->search}%")->paginate(10);
            }else{
                return FornecedorModel::with("created_by")->paginate(10);
            }
        }else{
            if($request->search){
                return FornecedorModel::with("created_by")->where("name","like","%{$request->search}%")->get();
            }else{
                return FornecedorModel::with("created_by")->get();
            }
        }
            
    }

    public function edit(Request $request, $id){
        return FornecedorModel::find($id);
    }

    public function update(Request $request){
        $validator= Validator::make($request->all(),[
            "name" => "required|max:255|unique:fornecedors"
        ],
        [
            "name.required" => "O nome do fornecedor é obrigatório para atualizar!",
            "name.unique" => "O nome do fornecedor já existe!"
        ]);

        if($validator->fails()){
            return response($validator->errors(),409);
        }

        $fornecedor= FornecedorModel::find($request->id)->update([
            "name" => $request->name
        ]);
        
        return response()->json([
            "message" => "Fornecedor foi atualizado com sucesso!"
        ],200);
    }

}
