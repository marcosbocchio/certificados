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
      /* Diametro 1/8 */

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

      /* Diametro 1/4 */

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

      /* Diametro 3/8 */

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

      /* Diametro 1/2 */
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

     /* Diametro 3/4 */

     EspesorTubo::create([
          'diametro'                         =>'3/4',
          'distancia_fuente_peliculas'       =>'26.7',
          'espesor'                          =>'1.65',
      ]);

      EspesorTubo::create([
          'diametro'                         =>'3/4',
          'distancia_fuente_peliculas'       =>'26.7',
          'espesor'                          =>'2.11',
      ]);

      EspesorTubo::create([
          'diametro'                         =>'3/4',
          'distancia_fuente_peliculas'       =>'26.7',
          'espesor'                          =>'2.85',
      ]);

      EspesorTubo::create([
          'diametro'                         =>'3/4',
          'distancia_fuente_peliculas'       =>'26.7',
          'espesor'                          =>'3.91',
      ]);

      EspesorTubo::create([
          'diametro'                         =>'3/4',
          'distancia_fuente_peliculas'       =>'26.7',
          'espesor'                          =>'5.56',
      ]);

      EspesorTubo::create([
          'diametro'                         =>'3/4',
          'distancia_fuente_peliculas'       =>'26.7',
          'espesor'                          =>'7.82',
      ]);

      /* Diametro 1 */

      EspesorTubo::create([
          'diametro'                         =>'1',
          'distancia_fuente_peliculas'       =>'33.4',
          'espesor'                          =>'1.65',
      ]);

      EspesorTubo::create([
          'diametro'                         =>'1',
          'distancia_fuente_peliculas'       =>'33.4',
          'espesor'                          =>'2.77',
      ]);

      EspesorTubo::create([
          'diametro'                         =>'1',
          'distancia_fuente_peliculas'       =>'33.4',
          'espesor'                          =>'3.38',
      ]);

      EspesorTubo::create([
          'diametro'                         =>'1',
          'distancia_fuente_peliculas'       =>'33.4',
          'espesor'                          =>'4.45',
      ]);

      EspesorTubo::create([
          'diametro'                         =>'1',
          'distancia_fuente_peliculas'       =>'33.4',
          'espesor'                          =>'6.35',
      ]);

      EspesorTubo::create([
          'diametro'                         =>'1',
          'distancia_fuente_peliculas'       =>'33.4',
          'espesor'                          =>'9.09',
      ]);

      /* Diametro 1 1/4 */

      EspesorTubo::create([
          'diametro'                         =>'1 1/4',
          'distancia_fuente_peliculas'       =>'42.2',
          'espesor'                          =>'1.65',
      ]);

      EspesorTubo::create([
          'diametro'                         =>'1 1/4',
          'distancia_fuente_peliculas'       =>'42.2',
          'espesor'                          =>'2.77',
      ]);

      EspesorTubo::create([
          'diametro'                         =>'1 1/4',
          'distancia_fuente_peliculas'       =>'42.2',
          'espesor'                          =>'3.56',
      ]);

      EspesorTubo::create([
          'diametro'                         =>'1 1/4',
          'distancia_fuente_peliculas'       =>'42.2',
          'espesor'                          =>'4.85',
      ]);

      EspesorTubo::create([
          'diametro'                         =>'1 1/4',
          'distancia_fuente_peliculas'       =>'42.2',
          'espesor'                          =>'6.35',
      ]);

      EspesorTubo::create([
          'diametro'                         =>'1 1/4',
          'distancia_fuente_peliculas'       =>'42.2',
          'espesor'                          =>'9.70',
      ]);


      /* Diametro 1 1/2 */

      EspesorTubo::create([
          'diametro'                         =>'1 1/2',
          'distancia_fuente_peliculas'       =>'48.3',
          'espesor'                          =>'1.65',
      ]);

      EspesorTubo::create([
          'diametro'                         =>'1 1/2',
          'distancia_fuente_peliculas'       =>'48.3',
          'espesor'                          =>'2.77',
      ]);

      EspesorTubo::create([
          'diametro'                         =>'1 1/2',
          'distancia_fuente_peliculas'       =>'48.3',
          'espesor'                          =>'3.66',
      ]);

      EspesorTubo::create([
          'diametro'                         =>'1 1/2',
          'distancia_fuente_peliculas'       =>'48.3',
          'espesor'                          =>'3.68',
      ]);

      EspesorTubo::create([
          'diametro'                         =>'1 1/2',
          'distancia_fuente_peliculas'       =>'48.3',
          'espesor'                          =>'5.08',
      ]);

      EspesorTubo::create([
          'diametro'                         =>'1 1/2',
          'distancia_fuente_peliculas'       =>'48.3',
          'espesor'                          =>'7.14',
      ]);

      EspesorTubo::create([
          'diametro'                         =>'1 1/2',
          'distancia_fuente_peliculas'       =>'48.3',
          'espesor'                          =>'10.16',
      ]);


      /* Diametro 2 */

      EspesorTubo::create([
          'diametro'                         =>'2',
          'distancia_fuente_peliculas'       =>'60.3',
          'espesor'                          =>'1.65',
      ]);

      EspesorTubo::create([
          'diametro'                         =>'2',
          'distancia_fuente_peliculas'       =>'60.3',
          'espesor'                          =>'2.77',
      ]);

      EspesorTubo::create([
          'diametro'                         =>'2',
          'distancia_fuente_peliculas'       =>'60.3',
          'espesor'                          =>'3.91',
      ]);

      EspesorTubo::create([
          'diametro'                         =>'2',
          'distancia_fuente_peliculas'       =>'60.3',
          'espesor'                          =>'5.54',
      ]);

      EspesorTubo::create([
          'diametro'                         =>'2',
          'distancia_fuente_peliculas'       =>'60.3',
          'espesor'                          =>'8.74',
      ]);

      EspesorTubo::create([
          'diametro'                         =>'2',
          'distancia_fuente_peliculas'       =>'60.3',
          'espesor'                          =>'11.07',
      ]);

      /* Diametro 2 1/2 */

      EspesorTubo::create([
          'diametro'                         =>'2 1/2',
          'distancia_fuente_peliculas'       =>'73',
          'espesor'                          =>'2.11',
      ]);

      EspesorTubo::create([
          'diametro'                         =>'2 1/2',
          'distancia_fuente_peliculas'       =>'73',
          'espesor'                          =>'3.05',
      ]);

      EspesorTubo::create([
          'diametro'                         =>'2 1/2',
          'distancia_fuente_peliculas'       =>'73',
          'espesor'                          =>'5.16',
      ]);

      EspesorTubo::create([
          'diametro'                         =>'2 1/2',
          'distancia_fuente_peliculas'       =>'73',
          'espesor'                          =>'7.01',
      ]);

      EspesorTubo::create([
          'diametro'                         =>'2 1/2',
          'distancia_fuente_peliculas'       =>'73',
          'espesor'                          =>'9.53',
      ]);

      EspesorTubo::create([
          'diametro'                         =>'2 1/2',
          'distancia_fuente_peliculas'       =>'73',
          'espesor'                          =>'14.02',
      ]);

      /* Diametro 3 */
      EspesorTubo::create([
          'diametro'                         =>'3',
          'distancia_fuente_peliculas'       =>'88.9',
          'espesor'                          =>'2.11',
      ]);

      EspesorTubo::create([
          'diametro'                         =>'3',
          'distancia_fuente_peliculas'       =>'88.9',
          'espesor'                          =>'3.05',
      ]);

      EspesorTubo::create([
          'diametro'                         =>'3',
          'distancia_fuente_peliculas'       =>'88.9',
          'espesor'                          =>'5.49',
      ]);

      EspesorTubo::create([
          'diametro'                         =>'3',
          'distancia_fuente_peliculas'       =>'88.9',
          'espesor'                          =>'7.62',
      ]);

      EspesorTubo::create([
          'diametro'                         =>'3',
          'distancia_fuente_peliculas'       =>'88.9',
          'espesor'                          =>'11.13',
      ]);

      EspesorTubo::create([
          'diametro'                         =>'3',
          'distancia_fuente_peliculas'       =>'88.9',
          'espesor'                          =>'15.24',
      ]);

      /* Diametro 3 1/2 */

      EspesorTubo::create([
          'diametro'                         =>'3 1/2',
          'distancia_fuente_peliculas'       =>'101.6',
          'espesor'                          =>'2.11',
      ]);

      EspesorTubo::create([
          'diametro'                         =>'3 1/2',
          'distancia_fuente_peliculas'       =>'101.6',
          'espesor'                          =>'3.05',
      ]);

      EspesorTubo::create([
          'diametro'                         =>'3 1/2',
          'distancia_fuente_peliculas'       =>'101.6',
          'espesor'                          =>'5.74',
      ]);

      EspesorTubo::create([
          'diametro'                         =>'3 1/2',
          'distancia_fuente_peliculas'       =>'101.6',
          'espesor'                          =>'8.08',
      ]);

      EspesorTubo::create([
          'diametro'                         =>'3 1/2',
          'distancia_fuente_peliculas'       =>'101.6',
          'espesor'                          =>'16.15',
      ]);



    }
}
