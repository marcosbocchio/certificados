<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsInformeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('informes', function (Blueprint $table) {

            $table->integer('kv')
                ->nullable()                             
                ->after('equipo_id');

            $table->integer('ma')
                 ->nullable()                       
                ->after('kv');          
           
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

           
            $table->dropColumn('kv');
            $table->dropColumn('ma');

        });
    }
}
