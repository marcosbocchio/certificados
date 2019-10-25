<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeingInternoFuentesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('interno_fuentes', function (Blueprint $table) {

            $table->bigInteger('fuente_id')
                    ->unsigned()                  
                    ->after('id');
            
            $table->foreign('fuente_id')
                    ->references('id')
                    ->on('fuentes');
           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    
    public function down()
    {
        Schema::table('interno_fuentes', function (Blueprint $table) {
          
            $table->dropForeign(['fuente_id']);
            $table->dropColumn('fuente_id');        


        });
    }
}
