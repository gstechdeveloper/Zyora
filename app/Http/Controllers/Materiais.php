<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Material as MateriaisModel;
use Illuminate\Validation\Rule;

class Materiais extends Controller
{
    public function adicionar(Request $request){
        $validator= $request->validate([
            "name" => [
                "required",
                "max:255",
                Rule::unique("materials")->where(fn ($q) => 
                 $q->where("lote", $request->lote)
                ),
            ],
            "vencimento" => "required|date",
            "descricao" => "nullable|string|max:255",
            "ventrada" => "required|numeric",
            "vsaida" => "required|numeric",
            "qtdmin" => "required|numeric",
            "qtmedia" => "required|numeric",
            "qtmax" => "required|numeric",
            "lote" => "required|string|max:255",
            "fornecedor_id" => "required|numeric"
        ],[
            "name.unique"   => "Já existe um material com este nome e lote.",
            "name.required" => "O nome do material é obrigatório!",
            "vencimento.required" => "O vencimento é obrigatório!",
            "ventrada.required" => "Deve ser inserido um valor de entrada!",
            "vsaida.required" => "Deve ser inserido um valor de saida!",
            "qtdmin.required" => "Inserir a quantidade mínima!",
            "qtmedia.required" => "Inserir a quantidade média!",
            "qtmax.required" => "Inserir a quantidade máxima!",
            "lote.required" => "Inserir o lote do material",
            "numeric" => "Deve ser inserido números não letras!"
        ]);

        $material = MateriaisModel::create(["user_id" => $request->user()->id,...$request->all()]);

        return response()->json([
            "message" => "Material cadastrado com sucesso!"
        ],200);

    }

    public function edit(Request $request, $id){
        return MateriaisModel::with("created_by")->with("fornecedor")->find($id);
    }

    public function update(Request $request){
        $validator= $request->validate([
            "name" => "required|max:255|unique:materials,name" . $request->id,
            "vencimento" => "required|date",
            "descricao" => "nullable|string|max:255",
            "ventrada" => "required|numeric",
            "vsaida" => "required|numeric",
            "qtdmin" => "required|numeric",
            "qtmedia" => "required|numeric",
            "qtmax" => "required|numeric",
            "lote" => "required|string|max:255",
            "fornecedor_id" => "required|numeric"
        ],[
            "name.required" => "O nome do material é obrigatório!",
            "name.unique" => "O nome do fornecedor já existe!",
            "vencimento.required" => "O vencimento é obrigatório!",
            "ventrada.required" => "Deve ser inserido um valor de entrada!",
            "vsaida.required" => "Deve ser inserido um valor de saida!",
            "qtdmin.required" => "Inserir a quantidade mínima!",
            "qtmedia.required" => "Inserir a quantidade média!",
            "qtmax.required" => "Inserir a quantidade máxima!",
            "lote.required" => "Inserir o lote do equipamento!",
            "numeric" => "Deve ser inserido números não letras!"

        ]);


        $fornecedor= MateriaisModel::find($request->id)->update($request->all());
        
        return response()->json([
            "message" => "Material foi atualizado com sucesso!"
        ],200);
    }

    public function selectAll(Request $request){
        if(!($request->notpgnt)){
            if($request->search){
                return MateriaisModel::with("created_by")->with("fornecedor")->where("name","like","%{$request->search}%")->paginate(10);
            }else{
                return MateriaisModel::with("created_by")->with("fornecedor")->paginate(10);
            }
        }else{
            if($request->search){
                return MateriaisModel::with("created_by")->with("fornecedor")->where("name","like","%{$request->search}%")->get();
            }else{
                return MateriaisModel::with("created_by")->with("fornecedor")->get();
            }
        }
            
    }

    public function select(Request $request){
        if($request->name && $request->lote){
            return MateriaisModel::where("name","like","%{$request->name}%")->where("lote","like","%{$request->lote}%")->get();
        }else if($request->name){
            return MateriaisModel::where("name","like","%{$request->name}%")->get();
        }else if($request->lote){
            return MateriaisModel::where("lote","like","%{$request->lote}%")->get();
        }
    }
}
