<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignParteDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('parte_detalles', function (Blueprint $table) {

            $table->bigInteger('parte_id')
                    ->unsigned()
                    ->after('id');
            
            $table->foreign('parte_id')
                    ->references('id')
                    ->on('partes');
    
            $table->bigInteger('informe_id')
                    ->unsigned()
                    -_nullable()
                    ->after('parte_id');
            
            $table->foreign('informe_id')
                    ->references('id')
                    ->on('informes');

           $table->bigInteger('informe_importado_id')
                    ->unsigned()
                    -_nullable()
                    ->after('informe_id');
            
            $table->foreign('informe_importado_id')
                    ->references('id')
                    ->on('informes_importados');

            $table->bigInteger('ot_servicio_id')
                    ->unsigned()
                    -_nullable()
                    ->after('informe_importado_id');
            
            $table->foreign('ot_servicio_id')
                    ->references('id')
                    ->on('ot_servicios');

           });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('parte_detalles', function (Blueprint $table) {

            $table->dropForeign(['parte_id']);
            $table->dropColumn('parte_id');

            $table->dropForeign(['informe_id']);
            $table->dropColumn('informe_id');
            
            $table->dropForeign(['ot_servicio_id']);
            $table->dropColumn('ot_servicio_id');

            $table->dropForeign(['informe_importado_id']);
            $table->dropColumn('informe_importado_id'); 

        });
    }
}
