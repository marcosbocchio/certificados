@extends('layouts.enod.master')

@section('contenido')

<div id="app">
    <enod-back-button fallback-url="/ayuda_general"></enod-back-button>

    <div class="ayuda_enod">
        <div class="ayuda_hero">
            <h1>Buscar formularios</h1>
            <p>El buscador te permite encontrar rapido las OT, informes y demas formularios cargados.</p>
        </div>

        @include('ayuda.partials.functional_summary')

        <section class="ayuda_section">
            <div class="ayuda_panel">
                <h2>Asi se ve la pantalla</h2>
                <p>Vista de ejemplo con datos de muestra (no son datos reales).</p>
                <ayuda-demo-buscador></ayuda-demo-buscador>
            </div>
        </section>
    </div>
</div>

@endsection
