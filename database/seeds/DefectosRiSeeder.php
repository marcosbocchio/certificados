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
            'codigo'              =>'F',
            'descripcion'         =>'Fisura',   
            'planta_sn'           =>'1',
            'gasoducto_sn'        =>'1'    
        ]);

        DefectosRi::create([
            'codigo'              =>'FF',
            'descripcion'         =>'Falta de fusion',   
            'planta_sn'           =>'1',
            'gasoducto_sn'        =>'1'    
        ]);

        DefectosRi::create([
            'codigo'              =>'PF',
            'descripcion'         =>'Falta de Penetración',   
            'planta_sn'           =>'1',
            'gasoducto_sn'        =>'1'    
        ]);

        DefectosRi::create([
            'codigo'              =>'FPD',
            'descripcion'         =>'Falta de Penetración por Desalineación',   
            'planta_sn'           =>'1',
            'gasoducto_sn'        =>'1'    
        ]);

        DefectosRi::create([
            'codigo'              =>'FFP',
            'descripcion'         =>'Falta de Fusión por Pasadas',   
            'planta_sn'           =>'1',
            'gasoducto_sn'        =>'1'    
        ]);

        DefectosRi::create([
            'codigo'              =>'HL',
            'descripcion'         =>'Desalineación',   
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
            'codigo'              =>'Q',
            'descripcion'         =>'Quemaduras',   
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
            'codigo'              =>'CE',
            'descripcion'         =>'Concavidad Externa',   
            'planta_sn'           =>'1',
            'gasoducto_sn'        =>'1'    
        ]);

        DefectosRi::create([
            'codigo'              =>'SI',
            'descripcion'         =>'Socavado Interior',   
            'planta_sn'           =>'1',
            'gasoducto_sn'        =>'1'    
        ]);
        
        DefectosRi::create([
            'codigo'              =>'SE',
            'descripcion'         =>'Socavado Exterior',   
            'planta_sn'           =>'1',
            'gasoducto_sn'        =>'1'    
        ]);

        DefectosRi::create([
            'codigo'              =>'ME',
            'descripcion'         =>'Escoria Aislada',   
            'planta_sn'           =>'1',
            'gasoducto_sn'        =>'1'    
        ]);

        DefectosRi::create([
            'codigo'              =>'MEL',
            'descripcion'         =>'Socavado Lineal',   
            'planta_sn'           =>'1',
            'gasoducto_sn'        =>'1'    
        ]);
        
        DefectosRi::create([
            'codigo'              =>'P',
            'descripcion'         =>'Poros',   
            'planta_sn'           =>'1',
            'gasoducto_sn'        =>'1'    
        ]);

        DefectosRi::create([
            'codigo'              =>'NP',
            'descripcion'         =>'Nido de Poros',   
            'planta_sn'           =>'1',
            'gasoducto_sn'        =>'1'    
        ]);

        DefectosRi::create([
            'codigo'              =>'PV',
            'descripcion'         =>'Poro Vermicular',   
            'planta_sn'           =>'1',
            'gasoducto_sn'        =>'1'    
        ]);

        DefectosRi::create([
            'codigo'              =>'CH',
            'descripcion'         =>'Cordón Hueco',   
            'planta_sn'           =>'1',
            'gasoducto_sn'        =>'1'    
        ]);

        DefectosRi::create([
            'codigo'              =>'IT',
            'descripcion'         =>'Inclusión de Tungteno',   
            'planta_sn'           =>'1',
            'gasoducto_sn'        =>'1'    
        ]);

        DefectosRi::create([
            'codigo'              =>'SA',
            'descripcion'         =>'Salto de Arco',   
            'planta_sn'           =>'1',
            'gasoducto_sn'        =>'1'    
        ]);

        DefectosRi::create([
            'codigo'              =>'AD',
            'descripcion'         =>'Acumulación de Discontinuidades',   
            'planta_sn'           =>'1',
            'gasoducto_sn'        =>'1'    
        ]);

        DefectosRi::create([
            'codigo'              =>'DP',
            'descripcion'         =>'Defecto de Placa',   
            'planta_sn'           =>'1',
            'gasoducto_sn'        =>'1'    
        ]);

        DefectosRi::create([
            'codigo'              =>'RP',
            'descripcion'         =>'Repetir Placa',   
            'planta_sn'           =>'1',
            'gasoducto_sn'        =>'1'    
        ]);

        DefectosRi::create([
            'codigo'              =>'AP',
            'descripcion'         =>'Aprobado',   
            'planta_sn'           =>'1',
            'gasoducto_sn'        =>'1'    
        ]);

        DefectosRi::create([
            'codigo'              =>'RZ',
            'descripcion'         =>'Rechazado',   
            'planta_sn'           =>'1',
            'gasoducto_sn'        =>'1'    
        ]);
    }
}
