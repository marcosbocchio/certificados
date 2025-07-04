@extends('layouts.enod.master')

@section('contenido')

    <div id="app">

    <informes-sin-parte
            :ots_data="{{ json_encode($ots_data) }}"
            :clientes_data="{{ json_encode($clientes_data) }}"
    ></informes-sin-parte>

    </div>

@endsection
