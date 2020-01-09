<?php

use Illuminate\Database\Seeder;
use App\EstadosOperadorRx;

class EstadosOperadorRxSeederTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        EstadosOperadorRx::create([
            'codigo'              =>'OK',
            'descripcion'         =>'OK',   

        ]);

        EstadosOperadorRx::create([
            'codigo'              =>'BAJA',
            'descripcion'         =>'BAJA',   

        ]);

        EstadosOperadorRx::create([
            'codigo'              =>'NV',
            'descripcion'         =>'NO VINCULADO',   

        ]);

        EstadosOperadorRx::create([
            'codigo'              =>'PER',
            'descripcion'         =>'PERDIDO',   

        ]);

        EstadosOperadorRx::create([
            'codigo'              =>'DET',
            'descripcion'         =>'DETERIORADO',   

        ]);
    }
}
