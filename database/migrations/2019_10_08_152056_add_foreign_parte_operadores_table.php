<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignParteOperadoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('parte_operadores', function (Blueprint $table) {

            $table->bigInteger('parte_id')
                    ->unsigned()
                    ->after('id');
            
            $table->foreign('parte_id')
                    ->references('id')
                    ->on('partes');
    
            $table->bigInteger('user_id')
                    ->unsigned()
                    ->after('parte_id');
            
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
        Schema::table('parte_operadores', function (Blueprint $table) {

            $table->dropForeign(['parte_id']);
            $table->dropColumn('parte_id');

            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');     


        });
    }
}
