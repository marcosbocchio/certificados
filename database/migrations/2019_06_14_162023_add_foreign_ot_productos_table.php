<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignOtProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ot_productos', function (Blueprint $table) {

            $table->bigInteger('ot_id')
                   ->unsigned()
                   ->after('id');
                   
            $table->foreign('ot_id')
                   ->references('id')
                   ->on('ots');
            
            $table->bigInteger('producto_id')
                   ->unsigned()
                   ->after('ot_id');
                   
            $table->foreign('producto_id')
                   ->references('id')
                   ->on('productos');

            $table->bigInteger('medida_id')
                   ->unsigned()
                   ->after('producto_id');
                   
            $table->foreign('medida_id')
                   ->references('id')
                   ->on('medidas');
            
            $table->bigInteger('ot_referencia_id')
                   ->unsigned()
                   ->nullable()
                   ->after('cantidad');
                   
            $table->foreign('ot_referencia_id')
                   ->references('id')
                   ->on('ot_referencias');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ot_productos', function (Blueprint $table) {

            $table->dropForeign(['ot_id']);
            $table->dropColumn('ot_id');

            $table->dropForeign(['producto_id']);
            $table->dropColumn('producto_id');

            $table->dropForeign(['medida_id']);
            $table->dropColumn('medida_id');

            $table->dropForeign(['ot_referencia_id']);
            $table->dropColumn('ot_referencia_id');
        }); 
    }
}
