<?php

use Illuminate\Database\Seeder;
use App\EstadosSuperficies;

class EstadosSuperficiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        EstadosSuperficies::create([

            'codigo'              =>'ARENADO',            
             
        ]);

        EstadosSuperficies::create([
            
            'codigo'              =>'MECANIZADO',            
             
        ]);

        EstadosSuperficies::create([
            
            'codigo'              =>'CEPILLADO',            
             
        ]);

        EstadosSuperficies::create([
            
            'codigo'              =>'RUGOSO',            
             
        ]);
    }
}
