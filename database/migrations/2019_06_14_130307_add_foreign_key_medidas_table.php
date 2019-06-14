<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyMedidasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Medidas', function (Blueprint $table) {
            $table->bigInteger('unidades_medida_id')
                   ->unsigned();
            $table->foreign('unidades_medida_id')
                   ->references('id')
                   ->on('unidades_medidas');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Medidas', function (Blueprint $table) {
            $table->dropForeign(['unidades_medida_id']);
            $table->dropColumn('unidades_medida_id');
      });
    }
}
