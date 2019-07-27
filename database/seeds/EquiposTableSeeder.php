<?php

use Illuminate\Database\Seeder;
use App\Equipos;
use App\MetodoEnsayos;

class EquiposTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    
    

    public function run()
    {
        $metodo = MetodoEnsayos::where('metodo','RI')->first();

        Equipos::create([
            'codigo'              =>'Sentinel 880 Delta',   
            'metodo_ensayo_id'    => $metodo->id,                
        ]);

        Equipos::create([
            'codigo'              =>'Exertus 120',
            'metodo_ensayo_id'    =>$metodo->id,                  
        ]);

        Equipos::create([
            'codigo'              =>'Sentinel scart',
            'metodo_ensayo_id'    =>$metodo->id,              
        ]);

        Equipos::create([
            'codigo'              =>'RX',
            'metodo_ensayo_id'    =>$metodo->id,              
        ]);

        $metodo = MetodoEnsayos::where('metodo','PM')->first();

        Equipos::create([
            'codigo'              =>'Fijo XX',
            'metodo_ensayo_id'    =>$metodo->id,              
        ]);

        Equipos::create([
            'codigo'              =>'Yugo YY',
            'metodo_ensayo_id'    =>$metodo->id,              
        ]);
    }
}
