<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePessoasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pessoas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_municipio');
            $table->enum('tipo_pessoa', ['PF', 'PJ']);
            $table->string('logradouro', 100);
            $table->string('numero', 10);
            $table->string('complemento', 80)->nullable();
            $table->string('bairro', 60);
            $table->string('cep', 10);
            $table->string('telefone', 14);
            $table->string('celular', 14);
            $table->string('email', 100);
            $table->foreign('id_municipio')->references('id')->on('municipios');
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
        Schema::dropIfExists('pessoas');
    }
}
