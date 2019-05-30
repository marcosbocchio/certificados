<?php

use Illuminate\Database\Seeder;
use App\EspesorTubo;

class EspesorTubosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      // diametro 1/8
      EspesorTubo::create([
          'diametro'                         =>'1/8',
          'distancia_fuente_peliculas'       =>'10.3',
          'espesor'                          =>'1.24',
      ]);

      EspesorTubo::create([
          'diametro'                         =>'1/8',
          'distancia_fuente_peliculas'       =>'10.3',
          'espesor'                          =>'1.73',
      ]);

      EspesorTubo::create([
          'diametro'                         =>'1/8',
          'distancia_fuente_peliculas'       =>'10.3',
          'espesor'                          =>'2.41',
      ]);

      // diametro 1/4
      EspesorTubo::create([
          'diametro'                         =>'1/4',
          'distancia_fuente_peliculas'       =>'13.7',
          'espesor'                          =>'1.65',
      ]);

      EspesorTubo::create([
          'diametro'                         =>'1/4',
          'distancia_fuente_peliculas'       =>'13.7',
          'espesor'                          =>'2.24',
      ]);

      EspesorTubo::create([
          'diametro'                         =>'1/4',
          'distancia_fuente_peliculas'       =>'13.7',
          'espesor'                          =>'3.02',
      ]);

      // diametro 3/8
      EspesorTubo::create([
          'diametro'                         =>'3/8',
          'distancia_fuente_peliculas'       =>'17.1',
          'espesor'                          =>'1.65',
      ]);

      EspesorTubo::create([
          'diametro'                         =>'3/8',
          'distancia_fuente_peliculas'       =>'17.1',
          'espesor'                          =>'2.31',
      ]);

      EspesorTubo::create([
          'diametro'                         =>'3/8',
          'distancia_fuente_peliculas'       =>'17.1',
          'espesor'                          =>'3.02',
      ]);

      //diametro 1/2
      EspesorTubo::create([
          'diametro'                         =>'1/8',
          'distancia_fuente_peliculas'       =>'21.3',
          'espesor'                          =>'1.65',
      ]);

      EspesorTubo::create([
          'diametro'                         =>'1/8',
          'distancia_fuente_peliculas'       =>'21.3',
          'espesor'                          =>'2.11',
      ]);

      EspesorTubo::create([
          'diametro'                         =>'1/8',
          'distancia_fuente_peliculas'       =>'21.3',
          'espesor'                          =>'2.77',
      ]);

      EspesorTubo::create([
          'diametro'                         =>'1/8',
          'distancia_fuente_peliculas'       =>'21.3',
          'espesor'                          =>'3.73',
      ]);

      EspesorTubo::create([
          'diametro'                         =>'1/8',
          'distancia_fuente_peliculas'       =>'21.3',
          'espesor'                          =>'4.78',
      ]);

      EspesorTubo::create([
          'diametro'                         =>'1/8',
          'distancia_fuente_peliculas'       =>'21.3',
          'espesor'                          =>'7.47',
      ]);





    }
}
