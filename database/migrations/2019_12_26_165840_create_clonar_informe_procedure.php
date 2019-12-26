<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClonarInformeProcedure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $procedure = "
        CREATE DEFINER=`root`@`localhost` PROCEDURE `ClonarInforme`(IN pInforme_id BIGINT(20),IN pUser_id BIGINT(20))
        BEGIN
        
        DECLARE nOt_id INT ;
        DECLARE sMetodo VARCHAR(5) ;
        DECLARE nInforme_id BIGINT(20);
        DECLARE dFecha DATETIME;
        DECLARE nMetodo_ensayo_id BIGINT(20);
        
        SET dFecha = DATE_FORMAT(NOW(),"%Y-%m-%d 00:00:00");
        SET nOt_id = (SELECT ot_id FROM informes WHERE informes.id = pInforme_id);
        SET nMetodo_ensayo_id =(SELECT metodo_ensayo_id FROM informes WHERE informes.id = pInforme_id);
        SET sMetodo = (SELECT metodo_ensayos.metodo 
                                  FROM informes  
                                  INNER JOIN metodo_ensayos ON metodo_ensayos.id = informes.metodo_ensayo_id 
                                  WHERE informes.id = pInforme_id);
                                  
        
        START TRANSACTION;
        
        /*  HAGO LA CLONACIÓN DE  LA TABLA INFORMES*/
        
        INSERT INTO informes(
            ot_id,
            procedimiento_informe_id,
            diametro_espesor_id,
            interno_equipo_id,
            metodo_ensayo_id,
            norma_evaluacion_id,
            norma_ensayo_id,
            tecnica_id,
            user_id,
            ejecutor_ensayo_id,
            material_id,
            fecha,
            numero,
            obra,
            prefijo,
            espesor_chapa,
            componente,
            procedimiento_soldadura,
            plano_isom,
            eps,
            pqr,
            observaciones,
            parte_id,
            firma
        
            )
            SELECT 
            ot_id,
            procedimiento_informe_id,
            diametro_espesor_id,
            interno_equipo_id,
            metodo_ensayo_id,
            norma_evaluacion_id,
            norma_ensayo_id,
            tecnica_id,
            pUser_id,
            ejecutor_ensayo_id,
            material_id,
            dFecha,
            (SELECT inf.numero +1 
            FROM informes as inf 
            INNER JOIN metodo_ensayos as me ON me.id = inf.metodo_ensayo_id 
            WHERE
            inf.ot_id = nOt_id AND
            me.id = nMetodo_ensayo_id
            ORDER BY inf.numero DESC  LIMIT 1),
            obra,
            prefijo,
            espesor_chapa,
            componente,
            procedimiento_soldadura,
            plano_isom,
            eps,
            pqr,
            observaciones,
            parte_id,
            firma
            FROM 
               informes
            WHERE
            informes.id = pInforme_id ;
            
            SET nInforme_id = LAST_INSERT_ID();
            
            /*  HAGO LA CLONACIÓN DE  LA TABLA INFORMES RI*/
        
            IF(sMetodo = 'RI') THEN
            
                    INSERT INTO informes_ri(
                     informe_id,
                     interno_fuente_id,
                     kv,
                     ma,
                     tipo_pelicula_id,
                     ici_id,
                     tecnicas_grafico_id,
                     gasoducto_sn,
                     foco,
                     pantalla,
                     pos_ant,
                     pos_pos,
                     lado,
                     distancia_fuente_pelicula,
                     actividad,
                     exposicion
                    )
                SELECT 
                     nInforme_id,
                     interno_fuente_id,
                     kv,
                     ma,
                     tipo_pelicula_id,
                     ici_id,
                     tecnicas_grafico_id,
                     gasoducto_sn,
                     foco,
                     pantalla,
                     pos_ant,
                     pos_pos,
                     lado,
                     distancia_fuente_pelicula,
                     actividad,
                     exposicion
                FROM 
                   informes_ri
                WHERE
                   informes_ri.informe_id = pInforme_id;
        
            END IF;
            
            /*  HAGO LA CLONACIÓN DE  LA TABLA INFORMES PM*/
        
            IF(sMetodo = 'PM') THEN
            
                    INSERT INTO informes_pm(
                        informe_id,
                        metodo_trabajo_pm_id,
                        voltaje,
                        amperaje,
                        vehiculo,
                        aditivo,
                        concentracion,
                        tipo_magnetizacion_id,
                        corriente_magnetizacion_id,
                        color_particula_id,
                        iluminacion_id,
                        desmagnetizacion_sn
        
                    )
                SELECT 
                        nInforme_id,
                        metodo_trabajo_pm_id,
                        voltaje,
                        amperaje,
                        vehiculo,
                        aditivo,
                        concentracion,
                        tipo_magnetizacion_id,
                        corriente_magnetizacion_id,
                        color_particula_id,
                        iluminacion_id,
                        desmagnetizacion_sn
                FROM 
                   informes_pm
                WHERE
                   informes_pm.informe_id = pInforme_id;
        
            END IF;
            
            /*  HAGO LA CLONACIÓN DE  LA TABLA INFORMES LP*/
        
            
            IF(sMetodo = 'LP') THEN
            
                    INSERT INTO informes_lp(
                        informe_id,
                        metodo_trabajo_lp_id,
                        tipo_penetrante,
                        penetrante_tipo_liquido_id,
                        penetrante_aplicacion_lp_id,
                        revelador_tipo_liquido_id,
                        revelador_aplicacion_lp_id,
                        removedor_tipo_liquido_id,
                        removedor_aplicacion_lp_id,
                        iluminacion_id,
                        tiempo_penetracion,
                        limpieza_previa,
                        limpieza_intermedia,
                        limpieza_final
        
                    )
                SELECT 
                    nInforme_id,
                    metodo_trabajo_lp_id,
                    tipo_penetrante,
                    penetrante_tipo_liquido_id,
                    penetrante_aplicacion_lp_id,
                    revelador_tipo_liquido_id,
                    revelador_aplicacion_lp_id,
                    removedor_tipo_liquido_id,
                    removedor_aplicacion_lp_id,
                    iluminacion_id,
                    tiempo_penetracion,
                    limpieza_previa,
                    limpieza_intermedia,
                    limpieza_final
        
                FROM 
                   informes_lp
                WHERE
                   informes_lp.informe_id = pInforme_id;
        
            END IF;
            
                /*  HAGO LA CLONACIÓN DE  LA TABLA INFORMES US*/
        
                IF(sMetodo = 'US') THEN
            
                    INSERT INTO informes_us(
                        informe_id,
                        estado_superficie_id,
                        encoder,
                        agente_acoplamiento
        
                    )
                SELECT 
                    nInforme_id,
                    estado_superficie_id,
                    encoder,
                    agente_acoplamiento
        
                FROM 
                   informes_us
                WHERE
                   informes_us.informe_id = pInforme_id;
                   
                END IF;
            
        COMMIT;
        
            END
                ";

        DB::unprepared("DROP procedure IF EXISTS getObraInforme");
        DB::unprepared($procedure);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clonar_informe_procedure');
    }
}
