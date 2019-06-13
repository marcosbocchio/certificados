<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMedidasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Medidas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('codigo',10);
            $table->string('descripcion',100)->nullable();
            $table->timestamps();
        });
        DB::statement("ALTER TABLE `Medidas` comment 'aca van todas las medidas asociadas por unidad de medida:
        Ej: 7 x 21 cm
             9 x 21 cm
                 2     pulgada
             3 1/2  pulgada
                 1     litro
        '");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('medidas');
    }
}
