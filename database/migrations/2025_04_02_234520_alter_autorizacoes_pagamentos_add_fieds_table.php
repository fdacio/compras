<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAutorizacoesPagamentosAddFiedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('autorizacoes_pagamentos', function (Blueprint $table) {
            $table->unsignedBigInteger('id_usuario_autorizacao')->nullable()->after('chassi');
            $table->date('data_autorizacao')->nullable()->after('id_usuario_autorizacao');
            $table->boolean('paga')->default(false)->after('data_autorizacao');
            $table->date('data_pagamento')->nullable()->after('paga');
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
            $table->dropColumn('id_usuario_autorizacao');
            $table->dropColumn('data_autorizacao');
            $table->dropColumn('paga');
            $table->dropColumn('data_pagamento');
        });
    }
}
