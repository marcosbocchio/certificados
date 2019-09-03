<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInformesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('informes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->datetime('fecha');
            $table->integer('numero');
            $table->string('prefijo',10)->nullable();  
            $table->decimal('espesor_chapa','6','2')->nullable();     
            $table->string('componente',20);
            $table->string('procedimiento_soldadura',20)->nullable();
            $table->string('plano_isom',10);
            $table->string('eps',30)->nullable();
            $table->string('pqr',30)->nullable();
            $table->string('observaciones',250)->nullable();
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
        Schema::dropIfExists('informes');
    }
}
