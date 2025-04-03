<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreteAutorizacoesPagamentosDocumentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('autorizacoes_pagamentos_documentos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nome', 60);
            $table->string('arquivo', 255);
            $table->unsignedBigInteger('id_autorizacao_pagamento');
            $table->foreign('id_id_autorizacao_pagamento')->references('id')->on('autorizacoes_pagamentos');
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
        Schema::dropIfExists('autorizacoes_pagamentos_documentos');
    }
}
