<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterRequiscoesComprasAddFieldUrgenteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('requisicoes_compras', function (Blueprint $table) {
            $table->boolean('urgente')->default(false)->after('local_entrega');
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
            $table->dropColumn('urgente');
        });
    }
}
