@extends('layouts.enod.master')

@section('contenido')

<div id="app">
<div class="ayuda_enod">
    <div class="ayuda_panel">
        <h1>Visualizar procedimientos asignados a una orden de trabajo (OT)</h1>
        <p>
            Esta pantalla permite consultar los procedimientos que fueron asociados a la OT y acceder a su documentacion.
            Desde aqui el usuario puede revisar los procedimientos disponibles y descargar los archivos necesarios.
        </p>
    </div>

    @include('ayuda.partials.functional_summary')

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <p>
                Los procedimientos que aparecen en este listado son los que quedaron asignados previamente a la orden de trabajo y que pueden
                intervenir despues en la generacion de informes.
            </p>
            <p>A continuacion se muestra un ejemplo de visualizacion de procedimientos:</p>
            <ayuda-demo-tabla-asignados entidad="procedimiento"></ayuda-demo-tabla-asignados>
        </div>
    </section>

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Como usar esta pantalla</h2>
            <ol>
                <li>Ingresar a la OT correspondiente.</li>
                <li>Abrir la seccion de procedimientos asignados.</li>
                <li>Consultar el listado disponible.</li>
                <li>Descargar la documentacion del procedimiento cuando sea necesario.</li>
            </ol>
        </div>
    </section>

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Importante</h2>
            <p>
                Si un procedimiento no aparece en esta pantalla, conviene revisar primero que haya sido asignado correctamente a la OT.
            </p>
            <p>
                Los procedimientos disponibles aqui pueden ser utilizados mas adelante al momento de generar informes.
            </p>
            <h3>Articulos relacionados</h3>
            <ul class="ayuda_links">
                <li><a href="{{ route('ayuda-asignar-procedimientos') }}">Asignar procedimientos</a></li>
                <li><a href="{{ route('ayuda-gestion-documentaciones') }}">Gestionar documentacion</a></li>
                <li><a href="{{ route('ayuda-generar-informes') }}">Creacion de informes</a></li>
            </ul>
        </div>
    </section>
</div>
</div>

@endsection
