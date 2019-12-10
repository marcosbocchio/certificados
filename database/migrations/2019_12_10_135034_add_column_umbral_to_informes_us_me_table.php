<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnUmbralToInformesUsMeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('informes_us_me', function (Blueprint $table) {

            $table->float('umbral')
                   ->nullable()
                   ->after('elemento');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('informes_us_me', function (Blueprint $table) {

            $table->dropForeign(['umbral']);      
                  
        });
    }
}
