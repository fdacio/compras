<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterVeiculosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('veiculos', function (Blueprint $table) {
            $table->dropColumn('tipo');
            $table->unsignedBigInteger('id_tipo_veiculo')->after('id_centro_custo');
            $table->foreign('id_tipo_veiculo')->references('id')->on('tipos_veiculos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('veiculos', function (Blueprint $table) {
            $table->dropColumn(['id_tipo_veiculo']);
            $table->string('tipo', 30)->after('id_centro_custo');
        });
    }
}
