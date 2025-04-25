<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterRequiscoesComprasAddFieldSituacaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('requisicoes_compras', function (Blueprint $table) {
            $table->enum('situacao', ['PENDENTE', 'EM COTACAO', 'COTADADA', 'AUTORIZADO', 'CANCELADO'])->default('PENDENTE')->after('tipo');
            $table->unsignedBigInteger('id_usuario_autorizacao')->nullable()->after('situacao');
            $table->date('data_autorizacao')->nullable()->after('id_usuario_autorizacao');
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
            $table->dropColumn('situacao');
            $table->dropColumn('id_usuario_autorizacao');
            $table->dropColumn('data_autorizacao');
        });
    }
}
