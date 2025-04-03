<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAutorizacoesPagamentosItensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('autorizacoes_pagamentos_itens', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('item');
            $table->string('descricao', 200);
            $table->string('unidade', 20);
            $table->integer('quantidade');
            $table->unsignedBigInteger('id_autorizacao');
            $table->foreign('id_autorizacao')->references('id')->on('autorizacoes_pagamentos');
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
        Schema::dropIfExists('autorizacoes_pagamentos_itens');
    }
}
