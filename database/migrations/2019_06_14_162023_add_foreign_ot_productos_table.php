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
        Schema::table('OT_productos', function (Blueprint $table) {

            $table->bigInteger('OT_id')
                   ->unsigned()
                   ->after('id');
                   
            $table->foreign('OT_id')
                   ->references('id')
                   ->on('ots');
            
            $table->bigInteger('producto_id')
                   ->unsigned()
                   ->after('OT_id');
                   
            $table->foreign('producto_id')
                   ->references('id')
                   ->on('productos');

            $table->bigInteger('medida_id')
                   ->unsigned()
                   ->after('producto_id');
                   
            $table->foreign('medida_id')
                   ->references('id')
                   ->on('medidas');
            
            $table->bigInteger('OT_referencia_id')
                   ->unsigned()
                   ->nullable()
                   ->after('cantidad');
                   
            $table->foreign('OT_referencia_id')
                   ->references('id')
                   ->on('OT_referencias');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('OT_productos', function (Blueprint $table) {

            $table->dropForeign(['OT_id']);
            $table->dropColumn('OT_id');

            $table->dropForeign(['producto_id']);
            $table->dropColumn('producto_id');

            $table->dropForeign(['medida_id']);
            $table->dropColumn('medida_id');

            $table->dropForeign(['OT_referencia_id']);
            $table->dropColumn('OT_referencia_id');
        }); 
    }
}
