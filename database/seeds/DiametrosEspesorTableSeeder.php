<?php

use Illuminate\Database\Seeder;
use App\DiametrosEspesor;

class DiametrosEspesorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      /* Diametro 1/8 */

      DiametrosEspesor::create([
          'diametro'                         =>'1/8',         
          'espesor'                          =>'1.24',
          'cuadrante'                        =>'S10'
      ]);

      DiametrosEspesor::create([
          'diametro'                         =>'1/8',       
          'espesor'                          =>'1.73',
          'cuadrante'                        =>'40'
      ]);

      DiametrosEspesor::create([
          'diametro'                         =>'1/8',        
          'espesor'                          =>'2.41',
          'cuadrante'                        =>'80'
      ]);

      /* Diametro 1/4 */

      DiametrosEspesor::create([
          'diametro'                         =>'1/4',         
          'espesor'                          =>'1.65',
          'cuadrante'                        =>'S10'
      ]);

      DiametrosEspesor::create([
          'diametro'                         =>'1/4',        
          'espesor'                          =>'2.24',
          'cuadrante'                        =>'40'
      ]);

      DiametrosEspesor::create([
          'diametro'                         =>'1/4',       
          'espesor'                          =>'3.02',
          'cuadrante'                        =>'80'
      ]);

      /* Diametro 3/8 */

      DiametrosEspesor::create([
          'diametro'                         =>'3/8',         
          'espesor'                          =>'1.65',
          'cuadrante'                        =>'S10'
      ]);

      DiametrosEspesor::create([
          'diametro'                         =>'3/8',         
          'espesor'                          =>'2.31',
          'cuadrante'                        =>'40'
      ]);

      DiametrosEspesor::create([
          'diametro'                         =>'3/8',       
          'espesor'                          =>'3.20',
          'cuadrante'                        =>'80'
      ]);

      /* Diametro 1/2 */
      DiametrosEspesor::create([
          'diametro'                         =>'1/2',        
          'espesor'                          =>'1.65',
          'cuadrante'                        =>'S5'
      ]);

      DiametrosEspesor::create([
          'diametro'                         =>'1/2',        
          'espesor'                          =>'2.11',
          'cuadrante'                        =>'S10'
      ]);

      DiametrosEspesor::create([
          'diametro'                         =>'1/2',         
          'espesor'                          =>'2.77',
          'cuadrante'                        =>'40'
      ]);

      DiametrosEspesor::create([
          'diametro'                         =>'1/2',         
          'espesor'                          =>'3.73',
          'cuadrante'                        =>'80'
      ]);

      DiametrosEspesor::create([
          'diametro'                         =>'1/2',      
          'espesor'                          =>'4.78',
          'cuadrante'                        =>'160'
      ]);

      DiametrosEspesor::create([
          'diametro'                         =>'1/2',         
          'espesor'                          =>'7.47',
          'cuadrante'                        =>'XXS'
      ]);

     /* Diametro 3/4 */

     DiametrosEspesor::create([
          'diametro'                         =>'3/4',       
          'espesor'                          =>'1.65',
          'cuadrante'                        =>'S5'
      ]);

      DiametrosEspesor::create([
          'diametro'                         =>'3/4',       
          'espesor'                          =>'2.11',
          'cuadrante'                        =>'S10'
      ]);

      DiametrosEspesor::create([
          'diametro'                         =>'3/4',         
          'espesor'                          =>'2.85',
          'cuadrante'                        =>'40'
      ]);

      DiametrosEspesor::create([
          'diametro'                         =>'3/4',       
          'espesor'                          =>'3.91',
          'cuadrante'                        =>'80'
      ]);

      DiametrosEspesor::create([
          'diametro'                         =>'3/4',       
          'espesor'                          =>'5.56',
          'cuadrante'                        =>'160'
      ]);

      DiametrosEspesor::create([
          'diametro'                         =>'3/4',         
          'espesor'                          =>'7.82',
          'cuadrante'                        =>'XXS'
      ]);

      /* Diametro 1 */

      DiametrosEspesor::create([
          'diametro'                         =>'1',        
          'espesor'                          =>'1.65',
          'cuadrante'                        =>'S5'
      ]);

      DiametrosEspesor::create([
          'diametro'                         =>'1',         
          'espesor'                          =>'2.77',
          'cuadrante'                        =>'S10'
      ]);

      DiametrosEspesor::create([
          'diametro'                         =>'1',       
          'espesor'                          =>'3.38',
          'cuadrante'                        =>'40'
      ]);

      DiametrosEspesor::create([
          'diametro'                         =>'1',        
          'espesor'                          =>'4.45',
          'cuadrante'                        =>'80'
      ]);

      DiametrosEspesor::create([
          'diametro'                         =>'1',        
          'espesor'                          =>'6.35',
          'cuadrante'                        =>'160'
      ]);

      DiametrosEspesor::create([
          'diametro'                         =>'1',       
          'espesor'                          =>'9.09',
          'cuadrante'                        =>'XXS'
      ]);

      /* Diametro 1 1/4 */

      DiametrosEspesor::create([
          'diametro'                         =>'1 1/4',       
          'espesor'                          =>'1.65',
          'cuadrante'                        =>'S5'
      ]);

      DiametrosEspesor::create([
          'diametro'                         =>'1 1/4',      
          'espesor'                          =>'2.77',
          'cuadrante'                        =>'S10'
      ]);

      DiametrosEspesor::create([
          'diametro'                         =>'1 1/4',        
          'espesor'                          =>'3.56',
          'cuadrante'                        =>'40'
      ]);

      DiametrosEspesor::create([
          'diametro'                         =>'1 1/4',        
          'espesor'                          =>'4.85',
          'cuadrante'                        =>'80'
      ]);

      DiametrosEspesor::create([
          'diametro'                         =>'1 1/4',       
          'espesor'                          =>'6.35',
          'cuadrante'                        =>'160'
      ]);

      DiametrosEspesor::create([
          'diametro'                         =>'1 1/4',       
          'espesor'                          =>'9.70',
          'cuadrante'                        =>'XXS'
      ]);


      /* Diametro 1 1/2 */

      DiametrosEspesor::create([
          'diametro'                         =>'1 1/2',        
          'espesor'                          =>'1.65',
          'cuadrante'                        =>'S5'
      ]);

      DiametrosEspesor::create([
          'diametro'                         =>'1 1/2',       
          'espesor'                          =>'2.77',
          'cuadrante'                        =>'S10'
      ]);

      DiametrosEspesor::create([
          'diametro'                         =>'1 1/2',     
          'espesor'                          =>'3.66',
          'cuadrante'                        =>'40S'
      ]);

      DiametrosEspesor::create([
          'diametro'                         =>'1 1/2',      
          'espesor'                          =>'3.68',
          'cuadrante'                        =>'40'
      ]);

      DiametrosEspesor::create([
          'diametro'                         =>'1 1/2',       
          'espesor'                          =>'5.08',
          'cuadrante'                        =>'80'
      ]);

      DiametrosEspesor::create([
          'diametro'                         =>'1 1/2',         
          'espesor'                          =>'7.14',
          'cuadrante'                        =>'160'
      ]);

      DiametrosEspesor::create([
          'diametro'                         =>'1 1/2',        
          'espesor'                          =>'10.16',
          'cuadrante'                        =>'XXS'
      ]);


      /* Diametro 2 */

      DiametrosEspesor::create([
          'diametro'                         =>'2',         
          'espesor'                          =>'1.65',
          'cuadrante'                        =>'S5'
      ]);

      DiametrosEspesor::create([
          'diametro'                         =>'2',        
          'espesor'                          =>'2.77',
          'cuadrante'                        =>'S10'
      ]);

      DiametrosEspesor::create([
          'diametro'                         =>'2',      
          'espesor'                          =>'3.91',
          'cuadrante'                        =>'40'
      ]);

      DiametrosEspesor::create([
          'diametro'                         =>'2',      
          'espesor'                          =>'5.54',
          'cuadrante'                        =>'80'
      ]);

      DiametrosEspesor::create([
          'diametro'                         =>'2',       
          'espesor'                          =>'8.74',
          'cuadrante'                        =>'160'
      ]);

      DiametrosEspesor::create([
          'diametro'                         =>'2',     
          'espesor'                          =>'11.07',
          'cuadrante'                        =>'XXS'
      ]);

      /* Diametro 2 1/2 */

      DiametrosEspesor::create([
          'diametro'                         =>'2 1/2',      
          'espesor'                          =>'2.11',
          'cuadrante'                        =>'S5'
      ]);

      DiametrosEspesor::create([
          'diametro'                         =>'2 1/2',       
          'espesor'                          =>'3.05',
          'cuadrante'                        =>'S10'
      ]);

      DiametrosEspesor::create([
          'diametro'                         =>'2 1/2',        
          'espesor'                          =>'5.16',
          'cuadrante'                        =>'40'
      ]);

      DiametrosEspesor::create([
          'diametro'                         =>'2 1/2',       
          'espesor'                          =>'7.01',
          'cuadrante'                        =>'80'
      ]);

      DiametrosEspesor::create([
          'diametro'                         =>'2 1/2',      
          'espesor'                          =>'9.53',
          'cuadrante'                        =>'160'
      ]);

      DiametrosEspesor::create([
          'diametro'                         =>'2 1/2',     
          'espesor'                          =>'14.02',
          'cuadrante'                        =>'XXS'
      ]);

      /* Diametro 3 */
      DiametrosEspesor::create([
          'diametro'                         =>'3',      
          'espesor'                          =>'2.11',
          'cuadrante'                        =>'S5'
      ]);

      DiametrosEspesor::create([
          'diametro'                         =>'3',       
          'espesor'                          =>'3.05',
          'cuadrante'                        =>'S10'
      ]);

      DiametrosEspesor::create([
          'diametro'                         =>'3',      
          'espesor'                          =>'5.49',
          'cuadrante'                        =>'40'
      ]);

      DiametrosEspesor::create([
          'diametro'                         =>'3',     
          'espesor'                          =>'7.62',
          'cuadrante'                        =>'80'
      ]);

      DiametrosEspesor::create([
          'diametro'                         =>'3',      
          'espesor'                          =>'11.13',
          'cuadrante'                        =>'160'
      ]);

      DiametrosEspesor::create([
          'diametro'                         =>'3',     
          'espesor'                          =>'15.24',
          'cuadrante'                        =>'XXS'
      ]);

      /* Diametro 3 1/2 */

      DiametrosEspesor::create([
          'diametro'                         =>'3 1/2',
          'espesor'                          =>'2.11',
          'cuadrante'                        =>'S5'
      ]);

      DiametrosEspesor::create([
          'diametro'                         =>'3 1/2',     
          'espesor'                          =>'3.05',
          'cuadrante'                        =>'S10'
      ]);

      DiametrosEspesor::create([
          'diametro'                         =>'3 1/2',  
          'espesor'                          =>'5.74',
          'cuadrante'                        =>'40'
      ]);

      DiametrosEspesor::create([
          'diametro'                         =>'3 1/2',    
          'espesor'                          =>'8.08',
          'cuadrante'                        =>'80'
      ]);

      DiametrosEspesor::create([
          'diametro'                         =>'3 1/2',     
          'espesor'                          =>'16.15',
          'cuadrante'                        =>'XXS'
      ]);

      // CHAPA
      DiametrosEspesor::create([
        'diametro'                         =>'CHAPA',     
        'espesor'                          =>'0',
        'cuadrante'                        =>''
     ]);

     //VARIOS
     DiametrosEspesor::create([
        'diametro'                         =>'VARIOS',     
        'espesor'                          =>'0',
        'cuadrante'                        =>''
     ]);



    }
}
