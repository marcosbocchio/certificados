<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyCertificadoProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('certificado_productos', function (Blueprint $table) {
            
            $table->bigInteger('certificado_id')
                  ->unsigned()
                  ->after('id');

            $table->foreign('certificado_id')
                ->references('id')
                ->on('certificados');

            $table->bigInteger('parte_id')
                ->unsigned()
                ->after('certificado_id');

            $table->foreign('parte_id')
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
        Schema::table('certificado_servicios', function (Blueprint $table) {

            $table->dropForeign(['certificado_id']);
            $table->dropColumn('certificado_id');

            $table->dropForeign(['parte_id']);
            $table->dropColumn('parte_id');

        });
    }
}
