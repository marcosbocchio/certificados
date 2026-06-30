@extends('layouts.enod.master')

@section('contenido')

<div id="app">
<div class="ayuda_enod">
    <div class="ayuda_panel">
        <h1>Visualizar vehiculos y documentacion complementaria asignados a una orden de trabajo (OT)</h1>
        <p>
            Esta pantalla permite consultar la documentacion de los vehiculos asociados a la OT y revisar tambien
            la documentacion complementaria cargada para ese trabajo.
        </p>
    </div>

    @include('ayuda.partials.functional_summary')

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <p>
                Desde aqui el usuario puede ver los archivos disponibles para cada vehiculo asignado y descargar la informacion
                complementaria vinculada a la orden de trabajo.
            </p>
            <p>A continuacion se muestra un ejemplo de visualizacion de documentacion:</p>
            <ayuda-demo-tabla-asignados entidad="vehiculo"></ayuda-demo-tabla-asignados>
        </div>
    </section>

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Como usar esta pantalla</h2>
            <ol>
                <li>Ingresar a la OT correspondiente.</li>
                <li>Abrir la seccion de vehiculos y documentacion complementaria.</li>
                <li>Revisar los archivos disponibles para cada vehiculo asignado.</li>
                <li>Descargar la documentacion necesaria.</li>
            </ol>
        </div>
    </section>

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Importante</h2>
            <p>
                Lo que aparece en esta pantalla depende de los vehiculos y documentos que se hayan asociado previamente a la OT.
            </p>
            <p>
                Si falta informacion, conviene revisar primero la asignacion de vehiculos y la documentacion cargada en los maestros.
            </p>
            <h3>Articulos relacionados</h3>
            <ul class="ayuda_links">
                <li><a href="{{ route('ayuda-asignar-vehiculos') }}">Asignar vehiculos y documentacion complementaria</a></li>
                <li><a href="{{ route('ayuda-gestion-vehiculos') }}">Gestionar vehiculos</a></li>
                <li><a href="{{ route('ayuda-gestion-documentaciones') }}">Gestionar documentacion</a></li>
            </ul>
        </div>
    </section>
</div>
</div>

@endsection
