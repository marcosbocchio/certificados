<?php


use App\Materiales;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Materiales::class, function (Faker $faker) {
    return [
        'codigo' => Str::random(15),
        'descripcion' =>Str::random(100),
    ];
});
