<?php

namespace App\Http\Controllers;
use App\Models\Requisicao as RequisicaoModel;
use App\Models\Material;

use Illuminate\Http\Request;

class Requisicao extends Controller
{
    public function add(Request $request){
        $validator= $request->validate([
            "material_req" => "required|max:255",
            "quantidade" => "required|numeric"
        ],[
            "material_req.required" => "O campo material é obrigatório",
            "quantidade.required" => "O campo quantidade é obrigatório",
            "quantidade.numeric" => "O campo quantidade deve ser um número"
        ]);

        
        $requisicao= RequisicaoModel::create([
            "material_id" => null,
            "coletor_id" => $request->user()->id,
            "material_req" => $request->material_req,
            "descricao" => $request->descricao,
            "quantidade" => $request->quantidade,
            "quantidade_liberada" => $request->quantidade_liberada,
            "status" => "Aberta", 
            "aprovado_por" => null,
            "confirm_retirada" => false,
            "confirm_recebimento" => false
        ]);

        return response()->json([
            "message" => "Requisição criada com sucesso!"
        ],200);
        
    }

    public function myRequests(Request $request){
        $id= $request->user()->id;

        if($request->search){
            return RequisicaoModel::with("approver")->where("coletor_id","=",$id)->where("material_req","like","%{$request->search}%")->paginate(10);
        }else{
            return RequisicaoModel::with("approver")->where("coletor_id","=",$id)->paginate(10);
        }
    }

    public function selectAll(Request $request){
        $requisicao= RequisicaoModel::with(["approver","created_by"]);

        if($request->fstatus != ""){
            $requisicao= $requisicao->where("status","=",$request->fstatus);
        }

        return $requisicao->paginate(10);
    }

    public function edit(Request $request, $id){
        return RequisicaoModel::with("created_by")->with("material")->find($id);
    }

    public function update(Request $request){
        if($request->material_id){
            RequisicaoModel::find($request->id)->update([
                "material_id" => $request->material_id
            ]);
        }
        if($request->status){
            RequisicaoModel::find($request->id)->update([
                "status" => $request->status
            ]);
        }
        if($request->aprovado_por){
            RequisicaoModel::find($request->id)->update([
                "aprovado_por" => $request->aprovado_por 
            ]);
        }
        if($request->confirm_retirada){
            $requisicao= RequisicaoModel::find($request->id);

            $material= $requisicao->material;

            $material->qtdatual -= $requisicao->quantidade_liberada;

            $material->save();

            $requisicao->update([
                "confirm_retirada" => $request->confirm_retirada 
            ]);
        }

        if($request->confirm_recebimento){
            RequisicaoModel::find($request->id)->update([
                "confirm_recebimento" => $request->confirm_recebimento
            ]);
        }

        if($request->quantidade_liberada){
            RequisicaoModel::find($request->id)->update([
                "quantidade_liberada" => $request->quantidade_liberada
            ]);
        }
    }

}