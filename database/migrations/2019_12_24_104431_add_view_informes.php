<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddViewInformes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("                        
                        CREATE ALGORITHM = UNDEFINED 
                        DEFINER = `root`@`localhost` 
                        SQL SECURITY DEFINER
                    VIEW `informes_view` AS
                        SELECT 
                            `informes`.`numero` AS `numero`,
                            `informes`.`obra` AS `obra`,
                            `informes`.`ot_id` AS `ot_id`,
                            DATE_FORMAT(`informes`.`fecha`, '%d/%m/%Y') AS `fecha`,
                            `informes`.`id` AS `id`,
                            `metodo_ensayos`.`metodo` AS `metodo`,
                            `users`.`name` AS `name`,
                            (CONCAT(`metodo_ensayos`.`metodo`,
                                    CONVERT( LPAD(`informes`.`numero`, 3, '0') USING UTF8MB4)) COLLATE utf8mb4_general_ci) AS `numero_formateado`,
                            `informes`.`prefijo` AS `prefijo`,
                            NULL AS `path`,
                            `metodo_ensayos`.`importable_sn` AS `importable_sn`,
                            `informes`.`firma` AS `firma`
                        FROM
                            ((`informes`
                            JOIN `users` ON ((`users`.`id` = `informes`.`user_id`)))
                            JOIN `metodo_ensayos` ON ((`metodo_ensayos`.`id` = `informes`.`metodo_ensayo_id`))) 
                        UNION SELECT 
                            `informes_importados`.`numero` AS `numero`,
                            `informes_importados`.`obra` AS `obra`,
                            `informes_importados`.`ot_id` AS `ot_id`,
                            DATE_FORMAT(`informes_importados`.`fecha`,
                                    '%d/%m/%Y') AS `fecha`,
                            `informes_importados`.`id` AS `id`,
                            `metodo_ensayos`.`metodo` AS `metodo`,
                            `users`.`name` AS `name`,
                            (CONCAT(`metodo_ensayos`.`metodo`,
                                    CONVERT( LPAD(`informes_importados`.`numero`, 3, '0') USING UTF8MB4)) COLLATE utf8mb4_general_ci) AS `numero_formateado`,
                            `informes_importados`.`prefijo` AS `prefijo`,
                            `informes_importados`.`path` AS `path`,
                            `metodo_ensayos`.`importable_sn` AS `importable_sn`,
                            0 AS `firma`
                        FROM
                            ((`informes_importados`
                            JOIN `users` ON ((`users`.`id` = `informes_importados`.`user_id`)))
                            JOIN `metodo_ensayos` ON ((`metodo_ensayos`.`id` = `informes_importados`.`metodo_ensayo_id`)))
                ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement(" DROP VIEW informes_view ");
    }
}
