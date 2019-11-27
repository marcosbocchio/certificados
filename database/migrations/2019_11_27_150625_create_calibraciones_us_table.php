<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCalibracionesUsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calibraciones_us', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('zapata',20);
            $table->integer('frecuencia');
            $table->string('angulo_apertura',10);
            $table->string('rango',10);
            $table->string('posicion',10);
            $table->char('curva_elevacion',3);
            $table->char('block_calibracion',2);
            $table->integer('block_sensibilidad');
            $table->char('tipo_reflector',1);
            $table->float('reflector_referencia');
            $table->integer('ganancia_referencia');
            $table->integer('nivel_registro');
            $table->integer('correccion_transferencia');
            $table->integer('adicional_barrido');
            $table->integer('amplificacion_total');
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
        Schema::dropIfExists('calibraciones_us');
    }
}
