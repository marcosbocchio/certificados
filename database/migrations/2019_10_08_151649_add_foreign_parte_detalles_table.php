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
                    ->after('parte_id');
            
            $table->foreign('informe_id')
                    ->references('id')
                    ->on('informes');

            $table->bigInteger('cm')
                    ->unsigned()
                    ->nullable()
                    ->after('placas_final');
            
            $table->foreign('cm')
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
        Schema::table('parte_detalles', function (Blueprint $table) {

            $table->dropForeign(['parte_id']);
            $table->dropColumn('parte_id');

            $table->dropForeign(['informe_id']);
            $table->dropColumn('informe_id');  
            
            $table->dropForeign(['cm']);
            $table->dropColumn('cm'); 


        });
    }
}
