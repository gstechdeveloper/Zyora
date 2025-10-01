<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;
use App\Models\Fornecedor;

class Material extends Model
{
    protected $fillable= [
        "name",
        "vencimento",
        "descricao",
        "ventrada",
        "vsaida",
        "qtdmin",
        "qtmedia",
        "qtmax",
        "lote",
        "user_id",
        "fornecedor_id"
    ];

    public function created_by(){
        return $this->BelongsTo(User::class,"user_id");
    }

    public function fornecedor(){
        return $this->BelongsTo(Fornecedor::class,"fornecedor_id");
    }
    
}
