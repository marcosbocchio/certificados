@extends('layouts.enod.master')

@section('contenido')

<div class="ayuda_enod">
    <div class="ayuda_panel">
        <h1>Asignar vehiculos y documentacion complementaria a la orden de trabajo (OT)</h1>
        <p>
            Esta pantalla permite asociar a la OT los vehiculos que van a intervenir en el trabajo y otra documentacion complementaria
            que se desee dejar disponible para consulta.
        </p>
    </div>

    @include('ayuda.partials.functional_summary')

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <p>
                La informacion asignada queda vinculada a la OT para que pueda revisarse despues desde la visualizacion de la documentacion.
                Esto resulta util cuando se necesita dejar a disposicion del cliente la documentacion de vehiculos y otros archivos relacionados con la tarea.
            </p>
            <p>A continuacion se muestra un ejemplo de esta asignacion:</p>
            <div class="ayuda_media">
                <img class="img-responsive" src="{{ asset('img/ayuda/asignar_vehiculo.gif') }}" alt="Asignacion de vehiculos y documentacion complementaria" />
            </div>
        </div>
    </section>

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Como usar esta pantalla</h2>
            <ol>
                <li>Ingresar a la OT correspondiente.</li>
                <li>Seleccionar los vehiculos que deben quedar asociados.</li>
                <li>Agregar, si corresponde, documentacion complementaria para esa OT.</li>
                <li>Hacer click en <strong>Actualizar</strong> para guardar los cambios.</li>
            </ol>
        </div>
    </section>

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Importante</h2>
            <p>
                La documentacion y los vehiculos quedan efectivamente asociados despues de actualizar la pantalla.
            </p>
            <p>
                Esta informacion puede ser consultada mas adelante desde la visualizacion de vehiculos y documentacion complementaria de la OT.
            </p>
            <h3>Articulos relacionados</h3>
            <ul class="ayuda_links">
                <li><a href="{{ route('ayuda-visualizar-vehiculos') }}">Visualizar vehiculos y documentacion complementaria</a></li>
                <li><a href="{{ route('ayuda-gestion-documentaciones') }}">Gestionar documentacion</a></li>
                <li><a href="{{ route('ayuda-gestion-vehiculos') }}">Gestionar vehiculos</a></li>
            </ul>
        </div>
    </section>
</div>

@endsection
