<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterRequisicoesComprasAddUsuarioCadastrouAlterouTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('requisicoes_compras', function (Blueprint $table) {
            $table->unsignedBigInteger('id_usuario_cadastrou')->nullable()->after('urgente');
            $table->unsignedBigInteger('id_usuario_alterou')->nullable()->after('id_usuario_cadastrou');
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
            $table->dropColumn('id_usuario_cadastrou');
            $table->dropColumn('id_usuario_alterou');
        });
    }
}
