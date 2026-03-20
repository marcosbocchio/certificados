@extends('layouts.enod.master')

@section('contenido')

<div class="ayuda_enod">
    <div class="ayuda_panel">
        <h1>Generar informes RI</h1>
        <p>
            Esta pantalla se usa para registrar informes de radiografia industrial dentro de una OT.
            Segun el tipo de trabajo, el informe puede corresponder a planta o ducto, y eso modifica parte del encabezado y la numeracion.
        </p>
    </div>

    @include('ayuda.partials.functional_summary')

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Encabezado del informe</h2>
            <p>
                Si la OT fue creada como multiobra, al ingresar primero debe indicarse a que obra corresponde el informe.
            </p>
            <div class="ayuda_media">
                <img class="img-responsive" src="{{ asset('img/ayuda/Encabezado_principal.PNG') }}" alt="Encabezado principal de informe RI" />
            </div>
            <p>
                Luego debe completarse el segundo encabezado indicando si el informe corresponde a <strong>Planta</strong> o <strong>Ducto</strong>.
                Aunque la carga es similar, la numeracion cambia entre ambos casos.
            </p>
            <p>
                En ducto el numero se arma considerando PK y tipo de soldadura definidos en los procedimientos del cliente.
                En planta esos campos quedan deshabilitados y el numero sigue una secuencia correlativa por OT.
            </p>
            <p><strong>Ejemplo:</strong> ducto `150-LR-RI001` y planta `RI001`.</p>
            <div class="ayuda_media">
                <img class="img-responsive" src="{{ asset('img/ayuda/Encabezado_RI.PNG') }}" alt="Campos principales del informe RI" />
            </div>
        </div>
    </section>

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Datos a revisar en la carga</h2>
            <ul>
                <li><strong>Tipo Sol.:</strong> en ducto se elige uno de los tipos de soldadura definidos para esa obra. Si el informe es de reparacion, debe marcarse la opcion correspondiente.</li>
                <li><strong>Espesor:</strong> si el valor no aparece en la lista, puede escribirse manualmente.</li>
                <li><strong>EPS y PQR:</strong> se eligen segun la configuracion disponible para la OT y quedan relacionados entre si.</li>
                <li><strong>Equipo:</strong> al seleccionar el equipo se completan datos de la fuente o los valores del equipo RX.</li>
                <li><strong>Tecnica:</strong> modifica el grafico visible y se usa para calcular la distancia fuente-film.</li>
            </ul>
            <div class="ayuda_media">
                <img class="img-responsive" src="{{ asset('img/ayuda/pk_sol.PNG') }}" alt="Campos PK y tipo de soldadura en RI" />
            </div>
        </div>
    </section>

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Modelos 3D y detalle del informe</h2>
            <p>
                El informe puede vincular uno o mas modelos 3D disponibles en el repositorio. En el PDF se muestra una captura
                y luego puede consultarse el modelo desde el visualizador 3D.
            </p>
            <div class="ayuda_media">
                <img class="img-responsive" src="{{ asset('img/ayuda/Modelo_3d.PNG') }}" alt="Modelos 3D en informe RI" />
            </div>
            <p>
                En la seccion de <strong>Elementos/posiciones</strong> se cargan las costuras o elementos con sus posiciones de placa y densidad.
                El sistema permite clonar posiciones para agilizar la carga.
            </p>
            <div class="ayuda_media">
                <img class="img-responsive" src="{{ asset('img/ayuda/Agregar_costuras.gif') }}" alt="Carga de costuras en informe RI" />
            </div>
        </div>
    </section>

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Indicaciones y pasadas</h2>
            <p>
                Al seleccionar una posicion de placa, se habilita la carga de <strong>indicaciones</strong> y <strong>rechazos</strong>.
                Cuando se informa posicion de la anomalia, el sistema la interpreta como rechazo y marca la costura como no aceptable,
                aunque ese estado puede modificarse manualmente.
            </p>
            <div class="ayuda_media">
                <img class="img-responsive" src="{{ asset('img/ayuda/Agregar_indicaciones.gif') }}" alt="Carga de indicaciones en informe RI" />
            </div>
            <p>
                En <strong>Pasadas</strong> se cargan los soldadores responsables. En planta se registra una pasada y en ducto pueden cargarse hasta seis.
                Tambien es posible clonar la informacion o importarla desde un archivo CSV.
            </p>
            <div class="ayuda_media">
                <img class="img-responsive" src="{{ asset('img/ayuda/Agregar_pasadas_manual.gif') }}" alt="Carga manual de pasadas en informe RI" />
            </div>
            <div class="ayuda_media">
                <img class="img-responsive" src="{{ asset('img/ayuda/Agregar_pasadas_archivo.gif') }}" alt="Importacion de pasadas en informe RI" />
            </div>
        </div>
    </section>

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Importante</h2>
            <p>
                Antes de guardar conviene revisar encabezado, costuras, indicaciones, pasadas y observaciones.
            </p>
            <p>
                Si faltan soldadores o procedimientos en las listas, primero debe revisarse la configuracion de la OT.
            </p>
            <h3>Articulos relacionados</h3>
            <ul class="ayuda_links">
                <li><a href="{{ route('ayuda-generar-informes') }}">Creacion de informes</a></li>
                <li><a href="{{ route('ayuda-asignar-soldadores-y-usuarios') }}">Asignar soldadores y usuarios de cliente</a></li>
                <li><a href="{{ route('ayuda-asignar-procedimientos') }}">Asignar procedimientos</a></li>
                <li><a href="{{ route('ayuda-crear-ot') }}">Como crear una orden de trabajo (OT)</a></li>
            </ul>
        </div>
    </section>
</div>

@endsection
