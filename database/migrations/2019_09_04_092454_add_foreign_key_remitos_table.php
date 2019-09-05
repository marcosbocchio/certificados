<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyRemitosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       
        Schema::table('remitos', function (Blueprint $table) {
        
            $table->bigInteger('ot_id')
                    ->unsigned()
                    ->after('id');
                    
            $table->foreign('ot_id')
                    ->references('id')
                    ->on('ots');

           $table->bigInteger('user_id')
                    ->unsigned()
                    ->after('destino');
                    
            $table->foreign('user_id')
                    ->references('id')
                    ->on('users');

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

            $table->dropForeign(['ot_id']);
            $table->dropColumn('ot_id');

            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');


        });
    }
}
