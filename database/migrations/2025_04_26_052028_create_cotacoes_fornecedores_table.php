<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCotacoesFornecedoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cotacoes_fornecedores', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_cotacao');
            $table->unsignedBigInteger('id_fornecedor');
            $table->unsignedBigInteger('id_usuario_cadastrou')->nullable();
            $table->foreign('id_cotacao')->references('id')->on('cotacoes');
            $table->foreign('id_fornecedor')->references('id')->on('fornecedores');
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
        Schema::dropIfExists('cotacoes_fornecedores');
    }
}
