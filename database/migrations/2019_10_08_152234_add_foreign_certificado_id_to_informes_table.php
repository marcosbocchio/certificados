<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignCertificadoIdToInformesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('informes', function (Blueprint $table) {

            $table->bigInteger('parte_id')
                    ->unsigned()
                    ->nullable()
                    ->after('observaciones');
            
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
        Schema::table('informes', function (Blueprint $table) {

            $table->dropForeign(['parte_id']);
            $table->dropColumn('parte_id');

        });
    }
}
