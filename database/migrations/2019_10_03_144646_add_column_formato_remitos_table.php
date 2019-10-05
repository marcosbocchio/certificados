<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnFormatoRemitosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('remitos', function (Blueprint $table) {
        
            $table->boolean('interno_sn')          
                    ->after('ot_id');               

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('remitos', function (Blueprint $table) {
          
            $table->dropColumn('interno_sn'); 
            
        });
    }
}
