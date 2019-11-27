<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyInformesUsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('informes_us', function (Blueprint $table) {
            
            $table->bigInteger('informe_id')
                  ->unsigned()
                  ->after('id');

            $table->foreign('informe_id')
                ->references('id')
                ->on('informes');

            $table->bigInteger('estado_superficie_id')
                    ->unsigned()
                    ->after('informe_id');

            $table->foreign('estado_superficie_id')
                  ->references('id')
                  ->on('estados_superficies');  
                  
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('informes_us', function (Blueprint $table) { 

            $table->dropForeign(['informe_id']);
            $table->dropColumn('informe_id');
            
            $table->dropForeign(['estado_superficie_id']);
            $table->dropColumn('estado_superficie_id');

        });
    }
}
