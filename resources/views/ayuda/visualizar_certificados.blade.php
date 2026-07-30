@extends('layouts.enod.master')

@section('contenido')

<div id="app">
    <enod-back-button fallback-url="/ayuda_general"></enod-back-button>

    <div class="ayuda_enod">
        <div class="ayuda_hero">
            <h1>Visualizar certificados</h1>
            <p>Como consultar los certificados generados de la OT y su estado de firma.</p>
        </div>

        @include('ayuda.partials.functional_summary')

        <section class="ayuda_section">
            <div class="ayuda_panel">
                <h2>Asi se ve la pantalla</h2>
                <p>Vista de ejemplo con datos de muestra (no son datos reales).</p>
                <ayuda-demo-tabla-certificados></ayuda-demo-tabla-certificados>
            </div>
        </section>
    </div>
</div>

@endsection
