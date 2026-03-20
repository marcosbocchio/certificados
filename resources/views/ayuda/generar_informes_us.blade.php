@extends('layouts.enod.master')

@section('contenido')

<div class="ayuda_enod">
    <div class="ayuda_panel">
        <h1>Generar informes US</h1>
        <p>
            Esta pantalla se utiliza para registrar informes de ultrasonido dentro de una OT.
            Segun la tecnica elegida, el formulario cambia y solicita distintas calibraciones y mediciones.
        </p>
    </div>

    @include('ayuda.partials.functional_summary')

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Encabezado del informe</h2>
            <p>
                Si la OT fue creada como multiobra, primero debe indicarse a que obra corresponde el informe.
            </p>
            <div class="ayuda_media">
                <img class="img-responsive" src="{{ asset('img/ayuda/Encabezado_principal.PNG') }}" alt="Encabezado principal de informe US" />
            </div>
            <p>
                Despues se completa el encabezado propio del informe con los campos obligatorios y la informacion tecnica del ensayo.
            </p>
            <div class="ayuda_media">
                <img class="img-responsive" src="{{ asset('img/ayuda/Encabezado_US.PNG') }}" alt="Campos principales del informe US" />
            </div>
        </div>
    </section>

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Datos a revisar en la carga</h2>
            <ul>
                <li><strong>Espesor:</strong> si el valor no aparece en la lista, puede escribirse manualmente.</li>
                <li><strong>EPS y PQR:</strong> se seleccionan segun la configuracion disponible para la OT y se completan entre si.</li>
                <li><strong>Tecnica:</strong> puede ser US convencional, Phase Array o Medicion de espesores. Segun la tecnica cambian las calibraciones y mediciones.</li>
                <li><strong>Equipo:</strong> se muestran equipos creados para US y se excluyen los que fueron definidos como palpadores.</li>
            </ul>
            <p>
                El informe tambien puede vincular modelos 3D ya cargados en el sistema.
            </p>
            <div class="ayuda_media">
                <img class="img-responsive" src="{{ asset('img/ayuda/Modelo_3d.PNG') }}" alt="Modelos 3D en informe US" />
            </div>
        </div>
    </section>

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>US convencional y Phase Array</h2>
            <p>
                Estas tecnicas comparten la misma base de calibracion. Se pueden cargar hasta cuatro calibraciones usando el boton de agregar.
                Los palpadores disponibles corresponden a equipos de US creados como palpador.
            </p>
            <div class="ayuda_media">
                <img class="img-responsive" src="{{ asset('img/ayuda/Calibraciones_us_pa.PNG') }}" alt="Calibraciones para informe US y PA" />
            </div>
            <p>
                Despues se registran las mediciones. Cada una debe completarse y agregarse al listado para poder aceptar o rechazar la medicion
                y adjuntar archivos o imagenes de referencia.
            </p>
            <div class="ayuda_media">
                <img class="img-responsive" src="{{ asset('img/ayuda/Mediciones_us_pa.PNG') }}" alt="Mediciones para informe US y PA" />
            </div>
        </div>
    </section>

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Medicion de espesores</h2>
            <p>
                Cuando la tecnica elegida es medicion de espesores, el informe solicita otra calibracion y otra forma de registrar los datos.
            </p>
            <div class="ayuda_media">
                <img class="img-responsive" src="{{ asset('img/ayuda/Calibraciones_me.PNG') }}" alt="Calibraciones para medicion de espesores" />
            </div>
            <p>
                Por cada elemento agregado se genera una matriz de <strong>Posicion</strong> por <strong>Generatrices</strong>, en la cual
                deben cargarse los valores medidos. Si el valor es menor al espesor minimo, el reporte lo destaca para facilitar su revision.
            </p>
            <div class="ayuda_media">
                <img class="img-responsive" src="{{ asset('img/ayuda/Mediciones_me.gif') }}" alt="Mediciones de espesores en informe US" />
            </div>
        </div>
    </section>

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Importante</h2>
            <p>
                Antes de guardar conviene revisar encabezado, tecnica elegida, calibraciones, mediciones y observaciones.
            </p>
            <p>
                Si faltan equipos, palpadores o procedimientos en las listas, primero debe revisarse la configuracion de la OT y los maestros relacionados.
            </p>
            <h3>Articulos relacionados</h3>
            <ul class="ayuda_links">
                <li><a href="{{ route('ayuda-generar-informes') }}">Creacion de informes</a></li>
                <li><a href="{{ route('ayuda-crear-ot') }}">Como crear una orden de trabajo (OT)</a></li>
                <li><a href="{{ route('ayuda-asignar-procedimientos') }}">Asignar procedimientos</a></li>
            </ul>
        </div>
    </section>
</div>

@endsection
