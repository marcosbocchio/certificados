<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInformesRiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('informes_ri', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->boolean('gasoducto_sn');            
            $table->string('foco',10);
            $table->string('pantalla',2);
            $table->float('pos_ant')->nullable();
            $table->float('pos_pos')->nullable();
            $table->string('lado',7);
            $table->float('distancia_fuente_pelicula');           
            $table->string('actividad',30)->nullable();
            $table->integer('exposicion');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('informes_ri');
    }
}
