@extends('layouts.enod.master')

@section('contenido')

 <div id="app">

    @foreach ($resultados ?? '' as $resultado)
        <categoria-grupos
            title="{{$resultado['nombreCategoria']}}"
            v-bind:subcategorias="{{$resultado['subcategorias']}}"
            url = "{{route('multimedia')}}">
        </categoria-grupos>
    @endforeach
 </div>

@endsection

