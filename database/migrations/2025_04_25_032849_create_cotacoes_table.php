<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCotacoesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cotacoes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_requisicao');
            $table->date('data');
            $table->unsignedBigInteger('id_usuario_cadastrou')->nullable();
            $table->unsignedBigInteger('id_usuario_alterou')->nullable();
            $table->foreign('id_requisicao')->references('id')->on('requisicoes_compras');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cotacoes');
    }
}
