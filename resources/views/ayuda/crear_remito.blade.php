@extends('layouts.enod.master')

@section('contenido')

<div id="app">
<div class="ayuda_enod">
    <div class="ayuda_panel">
        <h1>Crear remito</h1>
        <p>
            El alta de un remito se hace desde el modulo de Remitos. El sistema arma la cabecera con prefijo y numero automaticos,
            y permite cargar productos, internos de equipos y observaciones antes de guardar como borrador o definitivo.
        </p>
    </div>

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Formulario completo</h2>
            <p>Asi se ve el formulario al cargar un remito nuevo:</p>
            <ayuda-demo-form-remito></ayuda-demo-form-remito>
        </div>
    </section>

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Para entender todo el circuito</h2>
            <p>
                Para ver detalle de campos, decisiones entre borrador y definitivo, y resultado esperado sobre stock e internos,
                consulta el articulo general de remitos.
            </p>
            <ul class="ayuda_links">
                <li><a href="{{ route('ayuda-creacion-remito') }}">Remitos - articulo completo</a></li>
                <li><a href="{{ route('ayuda-stock') }}">Gestion de stock</a></li>
                <li><a href="{{ route('ayuda-gestion-interno-equipos') }}">Gestionar internos de equipos</a></li>
            </ul>
        </div>
    </section>
</div>
</div>

@endsection
