<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiciosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servicios', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('codigo',10);
            $table->string('descripcion',100)->nullable();
            $table->timestamps();
        });

        DB::statement("ALTER TABLE `servicios` comment 'aca se van a crear los serviciios identificando las unidades de medida.
        Seguramente lo tengamos en cuenta a la hora de armar el parte diario'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('servicios');
    }
}
