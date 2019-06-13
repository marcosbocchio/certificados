<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTipoPeliculasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Tipo_peliculas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('fabricante',10);
            $table->string('codigo',10);
            $table->string('descripcion',100)->nullable();
            $table->timestamps();
        });
        DB::statement("ALTER TABLE `Tipo_peliculas` comment 'SIN ABM

        AGFA D3
        AGFA D4
        AGFA D5
        AGFA D7
        KODAK AT100
        KODAK AA400
        KODAT OTRA
        FOMADUK R1
        FOMADUK R2'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tipo_peliculas');
    }
}
