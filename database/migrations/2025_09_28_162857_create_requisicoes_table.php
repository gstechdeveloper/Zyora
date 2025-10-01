<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('requisicoes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("material_id")->nullable();
            $table->unsignedBigInteger("coletor_id");
            $table->string("material_req");
            $table->string("descricao")->nullable();
            $table->integer("quantidade");
            $table->integer("quantidade_liberada");
            $table->string("status");
            $table->unsignedBigInteger("aprovado_por")->nullable();
            $table->boolean("confirm_retirada");
            $table->boolean("confirm_recebimento");
            $table->foreign("material_id")->references("id")->on("materials")->nullOnDelete();
            $table->foreign("coletor_id")->references("id")->on("users")->nullOnDelete();
            $table->foreign("aprovado_por")->references("id")->on("users")->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('requisicoes');
    }
};
