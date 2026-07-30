@extends('layouts.enod.master')

@section('contenido')

<div id="app">
    <enod-back-button fallback-url="/ayuda_general"></enod-back-button>

    <div class="ayuda_enod">
        <div class="ayuda_hero">
            <h1>Gestion de usuarios</h1>
            <p>Alta, edicion y baja de los usuarios del sistema, y asignacion de sus roles.</p>
        </div>

        @include('ayuda.partials.functional_summary')

        <section class="ayuda_section">
            <div class="ayuda_panel">
                <h2>Asi se ve la pantalla</h2>
                <p>Vista de ejemplo con datos de muestra (no son datos reales).</p>
                <ayuda-demo-abm-tabla entidad="usuario"></ayuda-demo-abm-tabla>
                <ayuda-demo-abm-form entidad="usuario"></ayuda-demo-abm-form>
            </div>
        </section>
    </div>
</div>

@endsection
