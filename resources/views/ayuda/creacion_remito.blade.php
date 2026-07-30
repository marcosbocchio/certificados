@extends('layouts.enod.master')

@section('contenido')

<div id="app">
    <enod-back-button fallback-url="/ayuda_general"></enod-back-button>

    <div class="ayuda_enod">
        <div class="ayuda_hero">
            <h1>Creacion de remitos</h1>
            <p>Como generar un remito y ver los remitos ya emitidos.</p>
        </div>

        @include('ayuda.partials.functional_summary')

        <section class="ayuda_section">
            <div class="ayuda_panel">
                <h2>Asi se ve la pantalla</h2>
                <p>Vista de ejemplo con datos de muestra (no son datos reales).</p>
                <ayuda-demo-form-remito></ayuda-demo-form-remito>
                <ayuda-demo-tabla-remitos></ayuda-demo-tabla-remitos>
            </div>
        </section>
    </div>
</div>

@endsection
