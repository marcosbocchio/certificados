<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


class CreatePaisesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paises', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('pais');
            $table->timestamps();
        });

        DB::statement("Insert into `paises` (`id`,`pais`) values (1,'Argentina')
                ON DUPLICATE KEY UPDATE pais = VALUES(pais)
                ;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paises');
    }
}