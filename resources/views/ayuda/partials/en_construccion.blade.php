@extends('layouts.enod.master')

@section('contenido')

<div id="app">
    <enod-back-button fallback-url="/ayuda_general"></enod-back-button>

    <div class="ayuda_enod">
        <div class="box box-custom-enod ayuda_construccion">
            <div class="box-body">
                <div class="ayuda_construccion_icon">
                    <i class="fa fa-wrench"></i>
                </div>
                <h2>Ayuda en construcción</h2>
                <p>
                    Este artículo todavía no está terminado. Estamos trabajando para tenerlo disponible pronto.
                </p>
                <p class="ayuda_construccion_subtitle">
                    Mientras tanto, podés volver al
                    <a href="{{ route('ayuda-general') }}">centro de ayuda</a>
                    y consultar los temas ya disponibles.
                </p>
            </div>
        </div>
    </div>
</div>

@endsection
