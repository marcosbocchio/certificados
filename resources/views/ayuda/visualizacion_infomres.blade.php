@extends('layouts.enod.master')

@section('contenido')

<div class="ayuda_enod">
    <div class="row">
        <div class="col-sm-12">
            <h2>Visualización de Informes</h2>
            <p>Este módulo permite acceder y visualizar los informes generados y asociados a las órdenes de trabajo del sistema.</p>

            <h3>1. Acceso a la Visualización de Informes desde la Página Principal</h3>
            <p>Para acceder a los informes de una Orden de Trabajo (OT) específica, siga los siguientes pasos desde la página principal del sistema:</p>
            <ol>
                <li>En la barra de búsqueda ubicada en la parte superior derecha de la tabla de "Órdenes de trabajo", ingrese el número de la OT deseada (ej. "3485").</li>
                <li>Presione Enter o haga clic en el icono de la lupa (🔍) para filtrar los resultados.</li>
                <li>Una vez localizada la OT en la tabla, haga clic en el recuadro de "Informes" que se encuentra en la fila de la OT seleccionada. Este icono se identifica con tres gráficos circulares (Ver Fig. 1).</li>
            </ol>
        </div>
        <div class="col-sm-8 col-sm-offset-2">
            <img class="img-responsive" src="{{ asset('img/ayuda/informes/enod_buscar_ot_informes.gif') }}" alt="Búsqueda de OT y acceso a informes (animación)"/>
            <p class="text-center help-block"><em>Fig. 1: Búsqueda de una Orden de Trabajo y acceso al módulo de informes.</em></p>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h3>2. Vista Principal de Informes Asignados</h3>
            <p>Una vez que haya hecho clic en el recuadro de "Informes", el sistema lo redirigirá a una nueva pantalla donde se listan todos los informes asignados a la Orden de Trabajo seleccionada.</p>
            <p>En esta sección, se mostrará una tabla con información relevante de cada informe, como <strong>Tipo</strong>, <strong>N°</strong> (Número de Informe), <strong>N° Rev.</strong> (Número de Revisión), <strong>Obra</strong>, <strong>Usuario alta</strong> y <strong>Fecha</strong>.</p>
        </div>
        <div class="col-sm-8 col-sm-offset-2">
            <img class="img-responsive" src="{{ asset('img/ayuda/informes/enod_listado_informes.PNG') }}" alt="Listado de Informes Asignados"/>
            <p class="text-center help-block"><em>Fig. 2: Vista del listado de informes asignados a una Orden de Trabajo.</em></p>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h4>Búsqueda de Informes</h4>
            <p>En la parte superior derecha de la tabla de informes, encontrará un campo de <strong>Buscar...</strong>. Puede ingresar el número de informe o cualquier otro dato relevante para filtrar la lista y localizar el informe deseado.</p>

            <h4>Acciones Disponibles por Informe</h4>
            <p>A la derecha de cada fila de informe en la tabla, encontrará iconos de acción:</p>
        </div>
        <div class="col-sm-12 detalle_iconos">
            <p><img class="img-responsive" src="{{ asset('img/ayuda/informes/Icono_pdf_informe.PNG') }}" alt="Visualizar PDF"/>&nbsp;&nbsp;<strong>Visualizar PDF:</strong> Icono naranja con un símbolo de PDF. Al hacer clic en este icono, el informe se abrirá en formato PDF en una nueva pestaña del navegador, permitiendo su visualización y descarga.</p>
            {{-- Incluye aquí otros iconos si existen y quieres documentarlos --}}
            {{--
            <p><img class="img-responsive" src="{{ asset('img/ayuda/informes/Icono_otra_accion.PNG') }}" alt="Otra Acción"/>&nbsp;&nbsp;<strong>Otra Acción:</strong> Icono y descripción.</p>
            --}}
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h3>Artículos relacionados&nbsp;</h3>
            {{-- Aquí podrías enlazar a otros artículos de ayuda relevantes, por ejemplo: --}}
            {{-- <ul>
                <li><a href="{{ url('ayuda/gestion-ordenes-trabajo') }}">Gestión de Órdenes de Trabajo</a></li>
                <li><a href="{{ url('ayuda/creacion-informes') }}">Creación de Informes</a></li>
            </ul> --}}
        </div>
    </div>
</div>

@endsection
