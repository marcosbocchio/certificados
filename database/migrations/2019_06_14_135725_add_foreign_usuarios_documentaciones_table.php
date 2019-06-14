<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignUsuariosDocumentacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Usuario_documentaciones', function (Blueprint $table) {

            $table->bigInteger('user_id')
                   ->unsigned()
                   ->nullable()
                   ->after('id');
            $table->foreign('user_id')
                   ->references('id')
                   ->on('users');
            
            $table->bigInteger('documentaciones_id')
                   ->unsigned()
                   ->after('user_id');
            $table->foreign('documentaciones_id')
                   ->references('id')
                   ->on('documentaciones');

            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $table->dropForeign(['user_id']);
        $table->dropColumn('user_id');

        $table->dropForeign(['documentaciones_id']);
        $table->dropColumn('documentaciones_id');
    }
}
