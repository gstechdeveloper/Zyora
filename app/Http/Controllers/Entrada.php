<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Entrada as EntradaModel;
use App\Models\Material;
use Illuminate\Support\Facades\Validator;


class Entrada extends Controller
{
    public function adicionar(Request $request){
        $validator= Validator::make($request->all(),[
            "material_id" => "required|numeric",
            "quantidade" => "required|numeric",
            "total" => "required|numeric",
        ],[
            "name.required" => "O nome do fornecedor é obrigatório!",
            "name.unique" => "O nome do fornecedor já existe!",
            "quantidade.required" => "É necessário inserir a quantidade!"
        ]);

        if($validator->fails()){
            return response($validator->errors(),401);
        }

        $fornecedor = EntradaModel::create(["user_id" => $request->user()->id,... $request->all()]);

        $material = Material::find($request->material_id);

        if ($material) {
            $material->qtdatual = $material->qtdatual + $request->quantidade;
            $material->save();
        }

        return response()->json([
            "message" => "Entrada registrada com sucesso!"
        ],200);

    }

    public function edit(Request $request, $id){
        return EntradaModel::with("created_by")->with("material")->find($id);
    }

    public function selectAll(Request $request){
        $query = EntradaModel::with("created_by", "material");

        if($request->search){
            $search = $request->search;
             $query->whereHas('material', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                ->orWhere('lote', 'like', "%{$search}%");
            });
        }

        if(!($request->notpgnt)){
            return $query->paginate(10);
        }else{
            return $query->get();
        }
    }

    public function delete(Request $request){
        
        $entrada = EntradaModel::with("created_by","material")->find($request->entrada_id);
        
        if ($entrada && $entrada->material) {
            $material = $entrada->material;

            $material->qtdatual = $material->qtdatual - $entrada->quantidade;
            $material->save();

            $entrada->delete();
        }

        
    }
}
