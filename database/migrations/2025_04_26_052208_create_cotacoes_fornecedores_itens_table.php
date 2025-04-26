<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCotacoesFornecedoresItensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cotacoes_fornecedores_itens', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_cotacao_fornecedor');
            $table->integer('item');
            $table->string('descricao', 200);
            $table->string('unidade', 20);
            $table->integer('quantidade_solicitada');
            $table->integer('quantidade_cotada');
            $table->integer('quantidade_atendida');
            $table->decimal('valor_unitario', 10, 2)->default(0);   
            $table->decimal('valor_total', 10, 2)->default(0);                
            $table->foreign('id_cotacao_fornecedor')->references('id')->on('cotacoes_fornecedores');
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
        Schema::dropIfExists('cotacoes_fornecedores_itens');
    }
}
