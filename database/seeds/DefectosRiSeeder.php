<?php

use Illuminate\Database\Seeder;
use App\DefectosRi;
class DefectosRiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DefectosRi::create([
            'codigo'              =>'FF',
            'descripcion'         =>'Falta de fusion',   
            'planta_sn'           =>'1',
            'gasoducto_sn'        =>'1'    
        ]);

        DefectosRi::create([
            'codigo'              =>'HL',
            'descripcion'         =>'desalineación',   
            'planta_sn'           =>'1',
            'gasoducto_sn'        =>'1'    
        ]);

        DefectosRi::create([
            'codigo'              =>'PE',
            'descripcion'         =>'Penetración Excesiva',   
            'planta_sn'           =>'1',
            'gasoducto_sn'        =>'1'    
        ]);

        DefectosRi::create([
            'codigo'              =>'CI',
            'descripcion'         =>'Concavidad Interna',   
            'planta_sn'           =>'1',
            'gasoducto_sn'        =>'1'    
        ]);

        DefectosRi::create([
            'codigo'              =>'SA',
            'descripcion'         =>'Salto de Arco',   
            'planta_sn'           =>'1',
            'gasoducto_sn'        =>'1'    
        ]);
    }
}
