<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Documentaciones', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('tipo',1)
            ->comment('I = Institucional
            P = Procedimientos propios de ENOD
            U = Usuario');
            $table->string('titulo',45)->comment('Es como se va a ver en en sistema');
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
        Schema::dropIfExists('documentaciones');
    }
}
