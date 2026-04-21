<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakeTipoPeliculaIdNullableInInformesRd extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('informes_rd', function (Blueprint $table) {
            $table->unsignedBigInteger('tipo_pelicula_id')->nullable()->change();
            $table->string('medida', 10)->nullable()->change();
            $table->string('pantalla', 2)->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('informes_rd', function (Blueprint $table) {
            $table->unsignedBigInteger('tipo_pelicula_id')->nullable(false)->change();
            $table->string('medida', 10)->nullable(false)->change();
            $table->string('pantalla', 2)->nullable(false)->change();
        });
    }
}
