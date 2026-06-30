@extends('layouts.enod.master')

@section('contenido')

<div id="app">
<div class="ayuda_enod">
    <div class="ayuda_panel">
        <h1>Visualizar documentacion de operadores y ayudantes de una orden de trabajo</h1>
        <p>
            Esta pantalla permite consultar la documentacion asociada a los operadores y ayudantes que fueron asignados a la OT.
            Desde aqui el usuario puede revisar la informacion disponible y descargar los archivos que correspondan.
        </p>
    </div>

    @include('ayuda.partials.functional_summary')

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <p>
                La documentacion mostrada puede incluir documentacion general y tambien documentacion vinculada a los metodos de ensayo
                que intervienen en la orden de trabajo. Por ejemplo, si la OT incluye determinados servicios, se mostrara la documentacion
                relacionada con esas tecnicas.
            </p>
            <p>A continuacion se muestra un ejemplo de visualizacion de documentacion:</p>
            <ayuda-demo-tabla-asignados entidad="doc-operador"></ayuda-demo-tabla-asignados>
        </div>
    </section>

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Como usar esta pantalla</h2>
            <ol>
                <li>Ingresar a la OT correspondiente.</li>
                <li>Abrir la seccion de documentacion de operadores.</li>
                <li>Revisar los archivos disponibles para cada operador o ayudante.</li>
                <li>Descargar la documentacion que se necesite consultar.</li>
            </ol>
        </div>
    </section>

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Importante</h2>
            <p>
                El contenido disponible depende de los operadores asignados a la OT y de la documentacion cargada para cada uno.
            </p>
            <p>
                Si falta informacion en esta pantalla, conviene revisar primero la asignacion de operadores y la documentacion cargada en los maestros.
            </p>
            <h3>Articulos relacionados</h3>
            <ul class="ayuda_links">
                <li><a href="{{ route('ayuda-asignar-operadores') }}">Asignar operadores</a></li>
                <li><a href="{{ route('ayuda-gestion-usuario') }}">Gestionar usuarios</a></li>
                <li><a href="{{ route('ayuda-generar-informes') }}">Creacion de informes</a></li>
            </ul>
        </div>
    </section>
</div>
</div>

@endsection
