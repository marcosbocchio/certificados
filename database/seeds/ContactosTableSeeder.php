<?php

use Illuminate\Database\Seeder;
use App\Contactos;

class ContactosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Contactos::create([

            'cliente_id'   =>'1',
            'nombre'       =>'contacto 1 cliente 1',  
            'cargo'        =>'Tecnico Nivel III',
            'tel'          =>'5555-5555',
            'email'        =>'contacto1cliente1@mail.com' 
        ]);

        Contactos::create([

            'cliente_id'    =>'1',
            'nombre'       =>'contacto 2 cliente 1',  
            'cargo'        =>'Tecnico Nivel III',
            'tel'          =>'5555-5555',
            'email'        =>'contacto2cliente1@mail.com' 
        ]);

        Contactos::create([

            'cliente_id'   =>'1',
            'nombre'       =>'contacto 3 cliente 1',  
            'cargo'        =>'Tecnico Nivel III',
            'tel'          =>'5555-5555',
            'email'        =>'contacto3cliente1@mail.com' 
        ]);

        Contactos::create([

            'cliente_id'   =>'2',
            'nombre'       =>'contacto 1 cliente 2',  
            'cargo'        =>'Tecnico Nivel III',
            'tel'          =>'5555-5555',
            'email'        =>'contacto1cliente2@mail.com' 
        ]);

        Contactos::create([

            'cliente_id'   =>'2',
            'nombre'       =>'contacto 2 cliente 2',  
            'cargo'        =>'Tecnico Nivel III',
            'tel'          =>'5555-5555',
            'email'        =>'contacto2cliente2@mail.com' 
        ]);

        Contactos::create([

            'cliente_id'   =>'3',
            'nombre'       =>'contacto 1 cliente 3',  
            'cargo'        =>'Tecnico Nivel III',
            'tel'          =>'5555-5555',
            'email'        =>'contacto1cliente3@mail.com' 
        ]);

        Contactos::create([

            'cliente_id'    =>'4',
            'nombre'       =>'contacto 1 cliente 4',  
            'cargo'        =>'Tecnico Nivel III',
            'tel'          =>'5555-5555',
            'email'        =>'contacto1cliente4@mail.com' 
        ]);

        Contactos::create([

            'cliente_id'   =>'4',
            'nombre'       =>'contacto 2 cliente 4',  
            'cargo'        =>'Tecnico Nivel III',
            'tel'          =>'5555-5555',
            'email'        =>'contacto2cliente4@mail.com' 
        ]);

        Contactos::create([

            'cliente_id'    =>'1',
            'nombre'       =>'contacto 4 cliente 1',  
            'cargo'        =>'Tecnico Nivel III',
            'tel'          =>'5555-5555',
            'email'        =>'contacto4cliente1@mail.com' 
        ]);
    }
}
