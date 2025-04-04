<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterFavorecidosAddFieldsDadosBancariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('favorecidos', function (Blueprint $table) {
            $table->string('banco', 60)->nullable()->after('id_pessoa');
            $table->string('agencia', 20)->nullable()->after('banco');
            $table->string('conta', 30)->nullable()->after('agencia');
            $table->string('operacao', 30)->nullable()->after('conta');
            $table->string('chave_pix', 30)->nullable()->after('operacao');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('favorecidos', function (Blueprint $table) {
            $table->dropColumn('banco');
            $table->dropColumn('agencia');
            $table->dropColumn('conta');
            $table->dropColumn('operacao');
            $table->dropColumn('chave_pix');
        });
    }
}
