<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Material;

class Requisicao extends Model
{
    protected $table= "requisicoes";
    //
    protected $fillable= [
        "material_id",
        "material_req",
        "coletor_id",
        "descricao",
        "quantidade",
        "quantidade_liberada",
        "status",
        "aprovado_por",
        "confirm_retirada",
        "confirm_recebimento"
    ];

    public function created_by(){
        return $this->BelongsTo(User::class,"coletor_id");
    }
    public function material(){
        return $this->BelongsTo(Material::class,"material_id");
    }
    public function approver(){
        return $this->BelongsTo(User::class,"aprovado_por");
    }
}
