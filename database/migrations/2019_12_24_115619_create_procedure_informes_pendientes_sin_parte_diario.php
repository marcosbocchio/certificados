<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProcedureInformesPendientesSinParteDiario extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $procedure = "
                        CREATE DEFINER=`root`@`localhost` PROCEDURE `InformesPendientesSinParteDiario`(IN pOt_id BIGINT(10), IN pParte_id BIGINT(20))
                        (SELECT 
                        informes.id as id, 
                        informes.fecha as fecha,
                        0 as informe_sel,
                        CONCAT(metodo_ensayos.metodo,
                        LPAD(informes.numero, 3, "0")) as numero_formateado,
                        DATE_FORMAT(informes.fecha,"%d/%m/%Y")as fecha_formateada,
                        0 as importable_sn,
                        metodo_ensayos.id as metodo_ensayo_id,
                        metodo_ensayos.metodo as metodo
                        
                        FROM informes
                        
                        INNER JOIN metodo_ensayos ON metodo_ensayos.id = informes.metodo_ensayo_id
                        WHERE
                        (informes.parte_id = pParte_id or informes.parte_id is NULL ) AND
                        informes.ot_id =  pOt_id)
                        
                        UNION
                        
                        (SELECT 
                        informes_importados.id as id, 
                        informes_importados.fecha as fecha,
                        0 as informe_sel,
                        CONCAT(metodo_ensayos.metodo,
                        LPAD(informes_importados.numero, 3, "0")) as numero_formateado,
                        DATE_FORMAT(informes_importados.fecha,"%d/%m/%Y")as fecha_formateada,
                        1 as importable_sn,
                        metodo_ensayos.id as metodo_ensayo_id,
                        metodo_ensayos.metodo as metodo
                        
                        FROM informes_importados
                        
                        INNER JOIN metodo_ensayos ON metodo_ensayos.id = informes_importados.metodo_ensayo_id
                        WHERE
                        (informes_importados.parte_id = pParte_id or informes_importados.parte_id is NULL ) AND
                        informes_importados.ot_id =  pOt_id)
                        
                        ORDER BY fecha DESC
                ";

        DB::unprepared("DROP procedure IF EXISTS getObraInforme");
        DB::unprepared($procedure);
    }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('procedure_informes_pendientes_sin_parte_diario');
    }
}
