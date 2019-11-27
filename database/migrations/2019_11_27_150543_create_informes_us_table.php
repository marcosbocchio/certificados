<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInformesUsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('informes_us', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->string('encoder',15);
            $table->string('agente_acoplamiento',10);
            $table->string('path1_calibracion')->nullable();
            $table->string('path2_calibracion')->nullable();
            $table->string('path3_calibracion')->nullable();
            $table->string('path4_calibracion')->nullable();
            $table->string('path1_indicacion')->nullable();
            $table->string('path2_indicacion')->nullable();
            $table->string('path3_indicacion')->nullable();
            $table->string('path4_indicacion')->nullable();
        
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
        Schema::dropIfExists('informes_us');
    }
}
