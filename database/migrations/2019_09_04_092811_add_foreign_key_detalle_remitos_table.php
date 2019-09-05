<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyDetalleRemitosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('detalle_remitos', function (Blueprint $table) {
        
            $table->bigInteger('remito_id')
                    ->unsigned()
                    ->after('id');
                    
            $table->foreign('remito_id')
                    ->references('id')
                    ->on('remitos');
        
            $table->bigInteger('producto_id')
                    ->unsigned()
                    ->after('remito_id');
                    
            $table->foreign('producto_id')
                    ->references('id')
                    ->on('productos');

            $table->bigInteger('medida_id')
                    ->unsigned()
                    ->after('id');
                    
            $table->foreign('medida_id')
                    ->references('id')
                    ->on('medidas');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('detalle_remitos', function (Blueprint $table) {

            $table->dropForeign(['remito_id']);
            $table->dropColumn('remito_id');

            $table->dropForeign(['producto_id']);
            $table->dropColumn('producto_id');

            $table->dropForeign(['medida_id']);
            $table->dropColumn('remitmedida_ido_id');


        });
    }
}
