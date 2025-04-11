<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAutorizacoesPagamentosAddFieldEmpresaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('autorizacoes_pagamentos', function (Blueprint $table) {
            $table->unsignedBigInteger('id_empresa')->after('id_centro_custo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('autorizacoes_pagamentos', function (Blueprint $table) {
            $table->dropColumn('id_empresa');
        });
    }
}
