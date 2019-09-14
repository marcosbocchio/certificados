<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInformesriProcedures extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $procedure = "
                        CREATE PROCEDURE `InformeRiPlantaJuntaPosicion`(IN `id` BIGINT )
                        SELECT
                        
                        juntas.codigo as junta,
                        posicion.codigo as posicion,
                        posicion.descripcion as observacion,
                        posicion.aceptable_sn as aceptable_sn,
                        posicion.id as posicion_id,
                        pasadas_posicion.numero as numero,
                        (SELECT	 soldadores.codigo FROM soldadores WHERE soldadores.id = pasadas_posicion.soldadorz_id) AS soldadorz,
                        (SELECT soldadores.codigo FROM soldadores WHERE soldadores.id = pasadas_posicion.soldadorl_id) AS soldadorl,
                        (SELECT soldadores.codigo FROM soldadores WHERE soldadores.id = pasadas_posicion.soldadorp_id) AS soldadorp
                        FROM juntas 
                        INNER JOIN posicion ON 
                        posicion.junta_id = juntas.id 
                        INNER JOIN pasadas_posicion ON
                        pasadas_posicion.posicion_id = posicion.id
                        WHERE juntas.informe_ri_id=id
                        ORDER BY posicion.id   
                ";

        DB::unprepared("DROP procedure IF EXISTS InformeRiPlantaJuntaPosicion");
        DB::unprepared($procedure);

        $procedure = "
                        CREATE PROCEDURE `InformeRiPlantaDefectosPasadaPosicion`(IN `id` BIGINT )
                        SELECT 
                        
                        posicion.id as posicion_id,
                        defectos_ri.codigo as codigo,
                        defectos_posicion.posicion as posicion
                        
                        FROM
                        informes_ri 
                        INNER JOIN juntas on
                        juntas.informe_ri_id = informes_ri.id
                        INNER JOIN posicion ON 
                        posicion.junta_id = juntas.id                      
                        INNER JOIN defectos_posicion ON
                        defectos_posicion.posicion_id = posicion.id
                        INNER JOIN defectos_ri ON
                        defectos_posicion.defecto_ri_id = defectos_ri.id
                        WHERE 
                        informes_ri.id=id 
                ";

        DB::unprepared("DROP procedure IF EXISTS InformeRiPlantaDefectosPasadaPosicion");
        DB::unprepared($procedure);

        $procedure = "
                        CREATE PROCEDURE `InformeRiGasoductoJuntaPosicion`(IN `id` BIGINT )
                        SELECT

                        juntas.id,
                        juntas.codigo as junta,
                        juntas.km,
                        tipo_soldaduras.codigo as tipo_soldadura,
                        posicion.codigo,     
                        posicion.aceptable_sn as aceptable_sn,                  
                        posicion.id as posicion_id
                        FROM juntas 
                        INNER JOIN tipo_soldaduras ON
                        tipo_soldaduras.id = juntas.tipo_soldadura_id
                        INNER JOIN posicion ON
                        posicion.junta_id = juntas.id
                        WHERE juntas.informe_ri_id=id
                        
                        ORDER BY posicion.id
                ";

        DB::unprepared("DROP procedure IF EXISTS InformeRiGasoductoJuntaPosicion");
        DB::unprepared($procedure);

        $procedure = "
                        CREATE PROCEDURE `InformeRiGasoductoPasadasPosicion`(IN `id` BIGINT )
                        SELECT   

                        posicion.id as posicion_id,
                        pasadas_posicion.numero,                       
                        (SELECT	 soldadores.codigo FROM soldadores WHERE soldadores.id = pasadas_posicion.soldadorz_id) AS soldadorz,
                        (SELECT soldadores.codigo FROM soldadores WHERE soldadores.id = pasadas_posicion.soldadorl_id) AS soldadorl,
                        (SELECT soldadores.codigo FROM soldadores WHERE soldadores.id = pasadas_posicion.soldadorp_id) AS soldadorp,
                        pasadas_posicion.id as pasada_posicion_id
                        
                        FROM
                        informes_ri 
                        INNER JOIN juntas on
                        juntas.informe_ri_id = informes_ri.id
                        INNER JOIN posicion ON 
                        posicion.junta_id = juntas.id 
                        INNER JOIN pasadas_posicion ON
                        pasadas_posicion.posicion_id  = posicion.id
                        WHERE 
                        informes_ri.id=id
                ";

        DB::unprepared("DROP procedure IF EXISTS InformeRiGasoductoPasadasPosicion");
        DB::unprepared($procedure);

        $procedure = "
                        CREATE PROCEDURE `InformeRiGasoductoDefectosPasadasPosicion`(IN `id` BIGINT )
                        SELECT  
                        
                        posicion.id as posicion_id,
                        defectos_ri.codigo as codigo,
                        defectos_posicion.posicion as posicion

                        FROM
                        informes_ri 
                        INNER JOIN juntas on
                        juntas.informe_ri_id = informes_ri.id
                        INNER JOIN posicion ON 
                        posicion.junta_id = juntas.id                      
                        INNER JOIN defectos_posicion ON
                        defectos_posicion.posicion_id = posicion.id
                        INNER JOIN defectos_ri ON
                        defectos_posicion.defecto_ri_id = defectos_ri.id
                        WHERE 
                        informes_ri.id=id 
                ";

        DB::unprepared("DROP procedure IF EXISTS InformeRiGasoductoDefectosPasadasPosicion");
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
