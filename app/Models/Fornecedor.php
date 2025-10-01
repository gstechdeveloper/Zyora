<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;

class Fornecedor extends Model
{
    protected $fillable= ["name","user_id"];
    
    public function created_by(){
        return $this->BelongsTo(User::class,"user_id");
    }
}
