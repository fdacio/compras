<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVeiculosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('veiculos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_frota');
            $table->unsignedBigInteger('id_empresa');
            $table->unsignedBigInteger('id_centro_custo');
            $table->string('tipo', 30);
            $table->string('marca', 30);
            $table->string('modelo', 30);
            $table->string('placa', 10);
            $table->string('uf', 2);
            $table->string('cor', 20);
            $table->string('ano', 4);
            $table->string('renavan', 20)->nullable();
            $table->foreign('id_frota')->references('id')->on('frotas');
            $table->foreign('id_empresa')->references('id')->on('empresas');
            $table->foreign('id_centro_custo')->references('id')->on('centros_custos');
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
        Schema::dropIfExists('veiculo');
    }
}
