<?php

use Illuminate\Database\Seeder;
use App\TecnicasGraficos;

class TecnicasGraficoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TecnicasGraficos::create([                 
            'tecnica_id'   =>'1',
            'path'  =>'img/tecnicas/captura1.jpg'           
        ]);

        TecnicasGraficos::create([                 
            'tecnica_id'   =>'1',
            'path'  =>'img/tecnicas/captura2.jpg'           
        ]);

        TecnicasGraficos::create([                 
            'tecnica_id'   =>'1',
            'path'  =>'img/tecnicas/captura3.jpg'           
        ]);

        TecnicasGraficos::create([                 
            'tecnica_id'   =>'2',
            'path'  =>'img/tecnicas/captura4.jpg'           
        ]);

        TecnicasGraficos::create([                 
            'tecnica_id'   =>'2',
            'path'  =>'img/tecnicas/captura5.jpg'           
        ]);

        TecnicasGraficos::create([                 
            'tecnica_id'   =>'3',
            'path'  =>'img/tecnicas/captura6.jpg'           
        ]);

        TecnicasGraficos::create([                 
            'tecnica_id'   =>'3',
            'path'  =>'img/tecnicas/captura7.jpg'           
        ]);
    }
}
