<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


class CreateProvinciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('provincias', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('provincia');
            $table->bigInteger('pais_id')->unsigned();
            $table->boolean('fav')->default(false);
            $table->timestamps();
            $table->foreign('pais_id')->references('id')->on('paises');
        });

        DB::statement("INSERT INTO `provincias` (`id`, `provincia`,`pais_id`) VALUES
                    (1, 'Buenos Aires',1),
                    (2, 'Buenos Aires-GBA',1),
                    (3, 'Capital Federal',1),
                    (4, 'Catamarca',1),
                    (5, 'Chaco',1),
                    (6, 'Chubut',1),
                    (7, 'Córdoba',1),
                    (8, 'Corrientes',1),
                    (9, 'Entre Ríos',1),
                    (10, 'Formosa',1),
                    (11, 'Jujuy',1),
                    (12, 'La Pampa',1),
                    (13, 'La Rioja',1),
                    (14, 'Mendoza',1),
                    (15, 'Misiones',1),
                    (16, 'Neuquén',1),
                    (17, 'Río Negro',1),
                    (18, 'Salta',1),
                    (19, 'San Juan',1),
                    (20, 'San Luis',1),
                    (21, 'Santa Cruz',1),
                    (22, 'Santa Fe',1),
                    (23, 'Santiago del Estero',1),
                    (24, 'Tierra del Fuego',1),
                    (25, 'Tucumán',1)
                    ON DUPLICATE KEY UPDATE provincia = VALUES(provincia), pais_id = VALUES(pais_id);
                ");

          
            
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('provincias');
    }
}
