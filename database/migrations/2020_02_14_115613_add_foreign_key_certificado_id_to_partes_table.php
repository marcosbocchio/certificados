<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyCertificadoIdToPartesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('partes', function (Blueprint $table) {
           
            $table->bigInteger('certificado_id')
                    ->unsigned()
                    ->nullable()
                    ->after('observaciones');
            
            $table->foreign('certificado_id')
                    ->references('id')
                    ->on('partes');    

          
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('partes', function (Blueprint $table) {

            $table->dropForeign(['certificado_id']);
            $table->dropColumn('certificado_id');

        });
    }
}
