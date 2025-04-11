<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterRequisicoesComprasAddFieldEmpresaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('requisicoes_compras', function (Blueprint $table) {
            $table->unsignedBigInteger('id_empresa')->after('id_solicitante');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('requisicoes_compras', function (Blueprint $table) {
            $table->dropColumn('id_empresa');
        });
    }
}
