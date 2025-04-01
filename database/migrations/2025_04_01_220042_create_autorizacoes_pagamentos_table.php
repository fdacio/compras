<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAutorizacoesPagamentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('autorizacoes_pagamentos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_fovorecido');
            $table->unsignedBigInteger('id_municipio');
            $table->unsignedBigInteger('id_veiculo');
            $table->unsignedBigInteger('id_forma_pagamento');
            $table->date('data');
            $table->decimal('valor', 10, 2);
            $table->string('observacao', 500)->nullable();
            $table->string('banco', 60)->nullable();
            $table->string('agencia', 20)->nullable();
            $table->string('conta', 30)->nullable();
            $table->string('operacao', 30)->nullable();
            $table->string('chave_pix', 30)->nullable();
            $table->foreign('id_favorecido')->references('id')->on('favorecidos');
            $table->foreign('id_municipio')->references('id')->on('centros_custos');
            $table->foreign('id_veiculo')->references('id')->on('veiculos');
            $table->foreign('id_forma_pagamento')->references('id')->on('formas_pagamentos');

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
        Schema::dropIfExists('autorizacoes_pagamentos');
    }
}
