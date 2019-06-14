<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Productos', function (Blueprint $table) {

            $table->bigInteger('unidades_medida_id')
                   ->unsigned()
                   ->after('descripcion');
                   
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
        Schema::table('Productos', function (Blueprint $table) {

            $table->dropForeign(['unidades_medida_id']);
            $table->dropColumn('unidades_medida_id');

        });
    }
}
