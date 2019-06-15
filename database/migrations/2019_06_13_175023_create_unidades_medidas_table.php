<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUnidadesMedidasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unidades_medidas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('codigo',10);
            $table->string('descripcion',100)->nullable();
            $table->timestamps();
        });

        DB::statement("ALTER TABLE `unidades_medidas` comment 'posibles unidades de medidas para cualquier producto : cm, pulgada, litro,hora,etc'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('unidades_medidas');
    }
}
