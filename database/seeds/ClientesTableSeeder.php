<?php

use Illuminate\Database\Seeder;
use App\Clientes;


class ClientesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Clientes::create([
            'codigo' => Str::random(10),
            'nombre_fantasia' =>'Nombre cliente 1',
            'razon_social' =>'razon social cliente 1',
            'direccion' =>'dirección cliente 1',
            'cp' =>'7000',
            'email' => 'cliente1@mail.com',
            'tel' => Str::random(10),
            'localidad_id' => '231',
        ]);

        Clientes::create([
            'codigo' => Str::random(10),
            'nombre_fantasia' =>'Nombre cliente 2',
            'razon_social' =>'razon social cliente 2',
            'direccion' =>'dirección cliente 2',
            'cp' =>'7000',
            'email' => 'cliente2@mail.com',
            'tel' => Str::random(10),
            'localidad_id' => '230',
        ]);

        Clientes::create([
            'codigo' => Str::random(10),
            'nombre_fantasia' =>'Nombre cliente 3',
            'razon_social' =>'razon social cliente 3',
            'direccion' =>'dirección cliente 3',
            'cp' =>'7000',
            'email' =>'cliente3@mail.com',
            'tel' => Str::random(10),
            'localidad_id' => '1',
        ]);

        Clientes::create([
            'codigo' => Str::random(10),
            'nombre_fantasia' =>'Nombre cliente 4',
            'razon_social' =>'razon social cliente 4',
            'direccion' =>'dirección cliente 4',
            'cp' =>'7000',
            'email' => 'cliente4@mail.com',
            'tel' => Str::random(10),
            'localidad_id' => '9',
        ]);

        Clientes::create([
            'codigo' => Str::random(10),
            'nombre_fantasia' =>'Nombre cliente 5',
            'razon_social' =>'razon social cliente 5',
            'direccion' =>'dirección cliente 5',
            'cp' =>'7000',
            'email' => 'cliente5@mail.com',
            'tel' => Str::random(10),
            'localidad_id' => '10',
        ]);

    }
}
