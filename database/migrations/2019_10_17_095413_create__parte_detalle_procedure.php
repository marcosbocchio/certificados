<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParteDetalleProcedure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $procedure = "                       
                        CREATE PROCEDURE `ParteDetalle`(IN `id` BIGINT,IN `estado` VARCHAR(10) )
                        SELECT 
                        parte_detalles.parte_id,
                        parte_detalles.informe_id,
                        metodo_ensayos.metodo,
                        medidas.codigo as cm,
                        CONCAT(metodo_ensayos.metodo,LPAD(informes.numero, 3, '0')) as numero_formateado,
                        CASE 
                        WHEN estado = 'original'  THEN parte_detalles.costura_original
                        ELSE parte_detalles.costura_final
                        END As costura,
                        CASE 
                        WHEN estado = 'original'  THEN parte_detalles.pulgadas_original
                        ELSE parte_detalles.pulgadas_final
                        END As pulgadas,
                        CASE 
                        WHEN estado = 'original'  THEN parte_detalles.placas_original
                        ELSE parte_detalles.placas_final
                        END As placas,
                        CASE 
                        WHEN estado = 'original'  THEN parte_detalles.pieza_original
                        ELSE parte_detalles.pieza_final
                        END As pieza,
                        CASE 
                        WHEN estado = 'original'  THEN parte_detalles.nro_original
                        ELSE parte_detalles.nro_final
                        END As nro,
                        parte_detalles.metros_lineales

                        FROM
                        parte_detalles
                        left join medidas ON medidas.id = parte_detalles.cm
                        inner join informes ON informes.id = parte_detalles.informe_id
                        inner join metodo_ensayos ON metodo_ensayos.id = informes.metodo_ensayo_id
                        WHERE
                        parte_detalles.parte_id =id
                ";

        DB::unprepared("DROP procedure IF EXISTS ParteDetalle");
        DB::unprepared($procedure);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      
    }
}
