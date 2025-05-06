<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCotacoesFornecedoresVencedoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cotacoes_fornecedores_vencedores', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_fornecedor');
            $table->unsignedBigInteger('id_cotacao');
            $table->foreign('id_fornecedor')->references('id')->on('fornecedores');
            $table->foreign('id_cotacao')->references('id')->on('cotacoes');
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
        Schema::dropIfExists('cotacoes_fornecedores_vencedores');
    }
}
