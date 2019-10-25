<?php

use Illuminate\Database\Seeder;
use App\MetodosTrabajoLp;
class MetodosTrabajoLpTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MetodosTrabajoLp::create([
            'tipo'         =>'TIPO I',
            'metodo'       =>'METODO A',                         
        ]);

        MetodosTrabajoLp::create([
            'tipo'         =>'TIPO I',
            'metodo'       =>'METODO B',                         
        ]);

        MetodosTrabajoLp::create([
            'tipo'         =>'TIPO I',
            'metodo'       =>'METODO C',                         
        ]);

        MetodosTrabajoLp::create([
            'tipo'         =>'TIPO I',
            'metodo'       =>'METODO D',                         
        ]);

        MetodosTrabajoLp::create([
            'tipo'         =>'TIPO II',
            'metodo'       =>'METODO A',                         
        ]);

        MetodosTrabajoLp::create([
            'tipo'         =>'TIPO II',
            'metodo'       =>'METODO C',                         
        ]);

    }
}
