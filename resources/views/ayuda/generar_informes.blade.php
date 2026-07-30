@extends('layouts.enod.master')

@section('contenido')

<div id="app">
    <enod-back-button fallback-url="/ayuda_general"></enod-back-button>

    <div class="ayuda_enod">
        <div class="ayuda_hero">
            <h1>Generar informes</h1>
            <p>Como iniciar la carga de un informe eligiendo el metodo de ensayo correspondiente.</p>
        </div>

        @include('ayuda.partials.functional_summary')

        <section class="ayuda_section">
            <div class="ayuda_panel">
                <h2>Asi se ve la pantalla</h2>
                <p>Vista de ejemplo con datos de muestra (no son datos reales).</p>
                <ayuda-demo-selector-metodo></ayuda-demo-selector-metodo>
                <ayuda-demo-tabla-informes></ayuda-demo-tabla-informes>
            </div>
        </section>
    </div>
</div>

@endsection
