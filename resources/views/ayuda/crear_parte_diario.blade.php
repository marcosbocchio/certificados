@extends('layouts.enod.master')

@section('contenido')

<div id="app">
    <enod-back-button fallback-url="/ayuda_general"></enod-back-button>

    <div class="ayuda_enod">
        <div class="ayuda_hero">
            <h1>Crear parte diario</h1>
            <p>Como cargar un parte diario con los operarios y sus horas trabajadas.</p>
        </div>

        @include('ayuda.partials.functional_summary')

        <section class="ayuda_section">
            <div class="ayuda_panel">
                <h2>Asi se ve la pantalla</h2>
                <p>Vista de ejemplo con datos de muestra (no son datos reales).</p>
                <ayuda-demo-form-parte></ayuda-demo-form-parte>
                <ayuda-demo-tabla-operarios-horas></ayuda-demo-tabla-operarios-horas>
            </div>
        </section>
    </div>
</div>

@endsection
