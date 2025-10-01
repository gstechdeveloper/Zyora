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
        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->date("vencimento");
            $table->string("descricao")->nullable()->default("Sem descrição");
            $table->float("ventrada");
            $table->float("vsaida");
            $table->integer("qtdatual")->default(0);
            $table->integer("qtdmin");
            $table->integer("qtmedia");
            $table->integer("qtmax");
            $table->string("lote");
            $table->unsignedBigInteger("user_id");
            $table->unsignedBigInteger("fornecedor_id");
            $table->foreign("user_id")->references("id")->on("users");
            $table->foreign("fornecedor_id")->references("id")->on("fornecedors");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materials');
    }
};
