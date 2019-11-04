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
        Schema::create('documentaciones', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('tipo',['INSTITUCIONAL','PROCEDIMIENTO','USUARIO','OT','PROCEDIMIENTO GENERAL'])
                    ->comment('I = Institucional
                    P = Procedimientos 
                    U = Usuario');
            $table->string('titulo',45)->comment('Es como se va a ver en en sistema');
            $table->string('descripcion')->nullable();
            $table->string('path');
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
