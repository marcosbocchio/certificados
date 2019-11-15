<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnContratistaIdTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ots', function (Blueprint $table) {
            
            $table->bigInteger('contratista_id')
                  ->unsigned()
                  ->after('logo_cliente_sn')
                  ->nullable();

            $table->foreign('contratista_id')
                ->references('id')
                ->on('contratistas');                 
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ots', function (Blueprint $table) {

            $table->dropForeign(['contratista_id']);
            $table->dropColumn('contratista_id');
       
        });
    }
}
