<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequisicoesComprasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requisicoes_compras', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_requisitante');
            $table->unsignedBigInteger('id_solicitante');
            $table->unsignedBigInteger('id_veiculo')->nullable();
            $table->date('data');
            $table->enum('tipo', ['PRODUTO', 'SERVICO']);
            $table->text('observacao')->nullable();
            $table->text('local_entrega')->nullable();
            $table->foreign('id_requisitante')->references('id')->on('centros_custos');
            $table->foreign('id_solicitante')->references('id')->on('solicitantes');
            $table->foreign('id_veiculo')->references('id')->on('veiculos');
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
        Schema::dropIfExists('requisicoes_compras');
    }
}
