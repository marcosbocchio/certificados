@extends('layouts.enod.master')

@section('contenido')

<div class="ayuda_enod">
    <div class="ayuda_panel">
        <h1>Visualizacion de partes diarios</h1>
        <p>
            Esta vista muestra los partes ya registrados para una OT. Sirve para controlar la actividad diaria cargada,
            revisar el tipo de servicio informado y acceder a la salida PDF o a la edicion cuando el usuario tiene permiso.
        </p>
    </div>

    @include('ayuda.partials.functional_summary')

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Como leer el listado</h2>
            <ul>
                <li><strong>Numero:</strong> identificador del parte.</li>
                <li><strong>Fecha:</strong> dia al que corresponde la carga.</li>
                <li><strong>Tipo de servicio:</strong> clasificacion operativa del trabajo informado.</li>
                <li><strong>Usuario alta:</strong> quien genero el registro.</li>
                <li><strong>Firma:</strong> estado documental segun el circuito del modulo.</li>
            </ul>
            <p>
                Esta consulta es util para verificar si una jornada ya fue consolidada y si puede ser utilizada despues
                en un certificado o en reportes.
            </p>
        </div>
    </section>

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Cuando conviene revisar esta pantalla</h2>
            <ul>
                <li>Cuando se necesita confirmar si una jornada ya quedo consolidada correctamente.</li>
                <li>Cuando se quiere abrir el PDF del parte adecuado antes de compartirlo o seguir con certificados.</li>
                <li>Cuando se revisa que partes estan disponibles para ser usados en el cierre documental de la OT.</li>
                <li>Cuando hace falta detectar si una jornada todavia necesita correcciones o complementos.</li>
            </ul>
        </div>
    </section>

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Acciones frecuentes</h2>
            <ul>
                <li>Buscar un parte puntual por numero, fecha, responsable o tipo de servicio.</li>
                <li>Abrir el PDF del parte para consulta o entrega.</li>
                <li>Editar el registro cuando el permiso y el estado lo permiten.</li>
                <li>Ver que OT ya tiene jornadas consolidadas y cuales aun no.</li>
            </ul>
        </div>
    </section>

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Que conviene revisar</h2>
            <p>
                El parte se alimenta de informes y a la vez alimenta certificados. Por eso esta vista funciona como punto intermedio
                entre el trabajo tecnico detallado y la consolidacion final que luego se entrega o reporta.
            </p>
            <ul>
                <li>Que la fecha y el tipo de servicio reflejen la jornada correcta.</li>
                <li>Que el PDF abierto corresponda al parte que se quiere consultar o compartir.</li>
                <li>Que los partes necesarios para un certificado ya esten disponibles y no falte consolidar jornadas previas.</li>
            </ul>
            <h3>Articulos relacionados</h3>
            <ul class="ayuda_links">
                <li><a href="{{ route('ayuda-crear-parte-diario') }}">Creacion de partes diarios</a></li>
                <li><a href="{{ route('ayuda-generar-informes') }}">Creacion de informes</a></li>
                <li><a href="{{ route('ayuda-crear-certificados') }}">Creacion de certificados</a></li>
            </ul>
        </div>
    </section>
</div>

@endsection
