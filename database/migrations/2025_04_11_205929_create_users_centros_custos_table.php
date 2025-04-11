<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersCentrosCustosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_centros_custos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('id_user')->index();
            $table->unsignedBigInteger('id_centro_custo')->index();
            $table->foreign('id_user')->references('id')->on('users');
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
        Schema::dropIfExists('users_centros_custos');
    }
}
