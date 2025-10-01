<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Material;

class Entrada extends Model
{
    protected $fillable= [
        "material_id",
        "descricao",
        "quantidade",
        "total",
        "user_id"
    ];

    public function created_by(){
        return $this->BelongsTo(User::class,"user_id");
    }

    public function material(){
        return $this->BelongsTo(Material::class,"material_id");
    }
}
