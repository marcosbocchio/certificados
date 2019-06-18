<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Clientes;
use Faker\Generator as Faker;

$factory->define(Clientes::class, function (Faker $faker) {
    return [
        'codigo' => Str::random(10),
        'nombre_fantasia' =>Str::random(20),
        'razon_social' =>Str::random(10),
        'direccion' =>Str::random(20),
        'cp' =>$faker->randomDigit,
        'mail' => $faker->unique()->safeEmail,
        'tel' => Str::random(20),
        'localidad_id' => '231',
    ];
});
