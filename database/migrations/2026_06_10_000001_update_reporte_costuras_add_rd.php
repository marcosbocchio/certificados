<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class UpdateReporteCosturasAddRd extends Migration
{
    /**
     * Agrega los informes RD (Radiografía Digital) al SP ReporteCosturas
     * mediante UNION ALL con las tablas juntas_rd / posicion_rd / pasadas_junta_rd.
     */
    public function up()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS ReporteCosturas');
        DB::unprepared("
CREATE PROCEDURE `ReporteCosturas`(`pOt_id` BIGINT(20), `pPk` VARCHAR(10), `pPlano` VARCHAR(30), `pCostura` VARCHAR(10), `pRechazados` TINYINT(1), `pReparaciones` TINYINT(1), `pSoldador_id` BIGINT(20), `pObra` VARCHAR(20), `pComponente` VARCHAR(40))
BEGIN
SELECT
i.id as informe_id,
CASE WHEN i.km IS NULL THEN
    iv.numero_formateado
ELSE
    concat(concat(i.km,concat('-',iv.tipo_soldadura_codigo)),concat('-',iv.numero_formateado))
END as nro_informe_formateado,
iv.tipo_soldadura_codigo,
i.numero as numero_informe,
DATE_FORMAT(i.fecha,'%d/%m/%Y') as fecha_formateada,
i.fecha,
i.km as km,
j.codigo as codigo_junta,
i.linea,
i.plano_isom,
i.hoja,
IF((SELECT COUNT(*) FROM posicion WHERE posicion.junta_id = j.id AND posicion.aceptable_sn = 0)=0,1,0) as aprobado_sn
FROM
ots as o
inner join informes as i on i.ot_id = o.id
inner join informes_view iv on iv.id = i.id AND iv.importable_sn = 0
inner join informes_ri ir on ir.informe_id = i.id
inner join juntas as j on j.informe_ri_id = ir.id
inner join pasadas_junta as pj on pj.junta_id = j.id
WHERE
o.id=pOt_id AND
(pPk = '' or i.km = pPk) AND
(pPlano = '' OR i.plano_isom LIKE CONCAT('%', pPlano, '%')) AND
(pCostura = '' or j.codigo LIKE concat('%',pCostura,'%')) AND
(pReparaciones = 0 or (RIGHT(j.codigo,1) = 'R')) AND
(pSoldador_id = 0 or pj.soldadorz_id = pSoldador_id or pj.soldadorl_id = pSoldador_id or pj.soldadorp_id = pSoldador_id) AND
(pObra = '' or i.obra = pObra) AND
(pComponente = '' or i.componente = pComponente)
group by informe_id,nro_informe_formateado,tipo_soldadura_codigo,plano_isom,numero_informe,fecha,fecha_formateada,km,codigo_junta,aprobado_sn
having aprobado_sn = 0 or pRechazados = 0

UNION ALL

SELECT
i.id as informe_id,
CASE WHEN i.km IS NULL THEN
    iv.numero_formateado
ELSE
    concat(concat(i.km,concat('-',iv.tipo_soldadura_codigo)),concat('-',iv.numero_formateado))
END as nro_informe_formateado,
iv.tipo_soldadura_codigo,
i.numero as numero_informe,
DATE_FORMAT(i.fecha,'%d/%m/%Y') as fecha_formateada,
i.fecha,
i.km as km,
j.codigo as codigo_junta,
i.linea,
i.plano_isom,
i.hoja,
IF((SELECT COUNT(*) FROM posicion_rd WHERE posicion_rd.junta_id = j.id AND posicion_rd.aceptable_sn = 0)=0,1,0) as aprobado_sn
FROM
ots as o
inner join informes as i on i.ot_id = o.id
inner join informes_view iv on iv.id = i.id AND iv.importable_sn = 0
inner join informes_rd ird on ird.informe_id = i.id
inner join juntas_rd as j on j.informe_rd_id = ird.id
inner join pasadas_junta_rd as pj on pj.junta_id = j.id
WHERE
o.id=pOt_id AND
(pPk = '' or i.km = pPk) AND
(pPlano = '' OR i.plano_isom LIKE CONCAT('%', pPlano, '%')) AND
(pCostura = '' or j.codigo LIKE concat('%',pCostura,'%')) AND
(pReparaciones = 0 or (RIGHT(j.codigo,1) = 'R')) AND
(pSoldador_id = 0 or pj.soldadorz_id = pSoldador_id or pj.soldadorl_id = pSoldador_id or pj.soldadorp_id = pSoldador_id) AND
(pObra = '' or i.obra = pObra) AND
(pComponente = '' or i.componente = pComponente)
group by informe_id,nro_informe_formateado,tipo_soldadura_codigo,plano_isom,numero_informe,fecha,fecha_formateada,km,codigo_junta,aprobado_sn
having aprobado_sn = 0 or pRechazados = 0

ORDER BY fecha desc, codigo_junta desc;
END
        ");
    }

    /**
     * Restaura la versión original (solo RI).
     */
    public function down()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS ReporteCosturas');
        DB::unprepared("
CREATE PROCEDURE `ReporteCosturas`(`pOt_id` BIGINT(20), `pPk` VARCHAR(10), `pPlano` VARCHAR(30), `pCostura` VARCHAR(10), `pRechazados` TINYINT(1), `pReparaciones` TINYINT(1), `pSoldador_id` BIGINT(20), `pObra` VARCHAR(20), `pComponente` VARCHAR(40))
BEGIN
SELECT
i.id as informe_id,
CASE WHEN i.km IS NULL THEN
    iv.numero_formateado
ELSE
    concat(concat(i.km,concat('-',iv.tipo_soldadura_codigo)),concat('-',iv.numero_formateado))
END as nro_informe_formateado,
iv.tipo_soldadura_codigo,
i.numero as numero_informe,
DATE_FORMAT(i.fecha,'%d/%m/%Y') as fecha_formateada,
i.fecha,
i.km as km,
j.codigo as codigo_junta,
i.linea,
i.plano_isom,
i.hoja,
IF((SELECT COUNT(*) FROM posicion WHERE posicion.junta_id = j.id AND posicion.aceptable_sn = 0)=0,1,0) as aprobado_sn
FROM
ots as o
inner join informes as i on i.ot_id = o.id
inner join informes_view iv on iv.id = i.id AND iv.importable_sn = 0
inner join informes_ri ir on ir.informe_id = i.id
inner join juntas as j on j.informe_ri_id = ir.id
inner join pasadas_junta as pj on pj.junta_id = j.id
WHERE
o.id=pOt_id AND
(pPk = '' or i.km = pPk) AND
(pPlano = '' OR i.plano_isom LIKE CONCAT('%', pPlano, '%')) AND
(pCostura = '' or j.codigo LIKE concat('%',pCostura,'%')) AND
(pReparaciones = 0 or (RIGHT(j.codigo,1) = 'R')) AND
(pSoldador_id = 0 or pj.soldadorz_id = pSoldador_id or pj.soldadorl_id = pSoldador_id or pj.soldadorp_id = pSoldador_id) AND
(pObra = '' or i.obra = pObra) AND
(pComponente = '' or i.componente = pComponente)
group by informe_id,nro_informe_formateado,tipo_soldadura_codigo,plano_isom,numero_informe,fecha,fecha_formateada,km,codigo_junta,aprobado_sn
having aprobado_sn = 0 or pRechazados = 0
order by fecha desc,codigo_junta desc;
END
        ");
    }
}
