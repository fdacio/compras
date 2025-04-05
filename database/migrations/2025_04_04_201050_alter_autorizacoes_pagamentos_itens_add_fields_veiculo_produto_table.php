<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAutorizacoesPagamentosItensAddFieldsVeiculoProdutoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('autorizacoes_pagamentos_itens', function (Blueprint $table) {
            $table->unsignedBigInteger('id_veiculo')->nullable()->after('id_autorizacao');
            $table->unsignedBigInteger('id_produto')->nullable()->after('id_veiculo');
            $table->foreign('id_veiculo')->references('id')->on('veiculos');
            $table->foreign('id_produto')->references('id')->on('produtos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('autorizacoes_pagamentos_itens', function (Blueprint $table) {
            $table->dropForeign(['id_veiculo']);
            $table->dropForeign(['id_produto']);
            $table->dropColumn('id_veiculo');
            $table->dropColumn('id_produto');
        });
    }
}
