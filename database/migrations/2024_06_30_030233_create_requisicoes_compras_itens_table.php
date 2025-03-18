<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequisicoesComprasItensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requisicoes_compras_itens', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('item');
            $table->string('descricao', 200);
            $table->string('unidade', 20);
            $table->integer('quantidade_solicitada');
            $table->integer('quantidade_a_cotar');
            $table->unsignedBigInteger('id_requisicao');
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
        Schema::dropIfExists('requisicoes_compras_itens');
    }
}
