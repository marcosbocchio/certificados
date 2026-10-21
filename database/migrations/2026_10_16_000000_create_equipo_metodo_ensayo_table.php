<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEquipoMetodoEnsayoTable extends Migration
{
    /**
     * Run the migrations.
     * Es idempotente: si la tabla ya se creó a mano en la base, no hace nada.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('equipo_metodo_ensayo')) {
            return;
        }

        Schema::create('equipo_metodo_ensayo', function (Blueprint $table) {
            $table->bigInteger('equipo_id')->unsigned();
            $table->bigInteger('metodo_ensayo_id')->unsigned();

            $table->primary(['equipo_id', 'metodo_ensayo_id']);
            $table->index('metodo_ensayo_id', 'idx_eme_metodo');

            $table->foreign('equipo_id', 'fk_eme_equipo')
                  ->references('id')->on('equipos')
                  ->onDelete('cascade');
            $table->foreign('metodo_ensayo_id', 'fk_eme_metodo')
                  ->references('id')->on('metodo_ensayos');
        });

        // Carga inicial: un registro por equipo con su método actual
        DB::statement('INSERT INTO equipo_metodo_ensayo (equipo_id, metodo_ensayo_id)
                       SELECT id, metodo_ensayo_id FROM equipos WHERE metodo_ensayo_id IS NOT NULL');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('equipo_metodo_ensayo');
    }
}
