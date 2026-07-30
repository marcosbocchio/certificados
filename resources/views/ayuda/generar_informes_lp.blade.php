@extends('layouts.enod.master')

@section('contenido')

<div id="app">
    <enod-back-button fallback-url="/ayuda_general"></enod-back-button>

    <div class="ayuda_enod">
        <div class="ayuda_hero">
            <h1>Generar informes LP (Liquidos Penetrantes)</h1>
            <p>Carga de un informe de Liquidos Penetrantes: datos del informe y elementos/indicaciones.</p>
        </div>

        @include('ayuda.partials.functional_summary')

        <section class="ayuda_section">
            <div class="ayuda_panel">
                <h2>Asi se ve la pantalla</h2>
                <p>Vista de ejemplo con datos de muestra (no son datos reales).</p>
                <ayuda-demo-form-informe metodo="LP"></ayuda-demo-form-informe>
                <ayuda-demo-tabla-elementos metodo="LP"></ayuda-demo-tabla-elementos>
            </div>
        </section>
    </div>
</div>

@endsection
