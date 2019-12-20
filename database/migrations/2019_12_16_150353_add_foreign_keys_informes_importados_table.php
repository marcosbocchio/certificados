<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeysInformesImportadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('informes_importados', function (Blueprint $table) {

            $table->bigInteger('ot_id')
                   ->unsigned()
                   ->after('id');
                   
            $table->foreign('ot_id')
                   ->references('id')
                   ->on('ots');

            $table->bigInteger('parte_id')
                   ->unsigned()
                   ->after('ot_id');
                   
            $table->foreign('parte_id')
                   ->references('id')
                   ->on('partes');

            $table->bigInteger('metodo_ensayo_id')
                   ->unsigned()
                   ->after('parte_id');
                  
            $table->foreign('metodo_ensayo_id')
                  ->references('id')
                  ->on('metodo_ensayos');

            $table->bigInteger('user_id')
                  ->unsigned()
                  ->after('metodo_ensayo_id');
                  
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users');

            $table->bigInteger('ejecutor_ensayo_id')
                  ->unsigned()
                  ->after('user_id');
                  
            $table->foreign('ejecutor_ensayo_id')
                  ->references('id')
                  ->on('ot_operarios');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('informes_importados', function (Blueprint $table) { 

            $table->dropForeign(['ot_id']);
            $table->dropColumn('ot_id');

            $table->dropForeign(['metodo_ensayo_id']);
            $table->dropColumn('metodo_ensayo_id');

            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');

            $table->dropForeign(['ejecutor_ensayo_id']);
            $table->dropColumn('ejecutor_ensayo_id');

            $table->dropForeign(['parte_id']);
            $table->dropColumn('parte_id');

        });
    }
}
