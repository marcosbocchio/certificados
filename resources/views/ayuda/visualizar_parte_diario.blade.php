@extends('layouts.enod.master')

@section('contenido')

<div class="ayuda_enod">
    <div class="row">
        <div class="col-sm-12">
            <h2>Visualización de Partes Diarios</h2>
            <p>Este módulo permite acceder y visualizar los partes diarios de trabajo generados y asociados a las órdenes de trabajo del sistema.</p>

            <h3>1. Acceso a la Visualización de Partes desde la Página Principal</h3>
            <p>Para acceder a los partes diarios de una Orden de Trabajo (OT) específica, siga los siguientes pasos desde la página principal del sistema:</p>
            <ol>
                <li>En la barra de búsqueda ubicada en la parte superior derecha de la tabla de "Órdenes de trabajo", ingrese el número de la OT deseada (ej. "3485").</li>
                <li>Presione Enter o haga clic en el icono de la lupa (🔍) para filtrar los resultados.</li>
                <li>Una vez localizada la OT en la tabla, haga clic en el recuadro de "Partes" que se encuentra en la fila de la OT seleccionada. Este icono se identifica con un calendario (Ver Fig. 1).</li>
            </ol>
        </div>
        <div class="col-sm-8 col-sm-offset-2">
            <img class="img-responsive" src="{{ asset('img/ayuda/partes/enod_buscar_ot_partes_visualizar.gif') }}" alt="Búsqueda de OT y acceso a partes (animación)"/>
            <p class="text-center help-block"><em>Fig. 1: Búsqueda de una Orden de Trabajo y acceso al módulo de partes.</em></p>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h3>2. Vista Principal de Partes Asignados</h3>
            <p>Al acceder a la sección de Partes, se presentará una tabla con el listado de todos los partes diarios ya registrados para la OT seleccionada. Por cada parte, se mostrará información relevante como <strong>N°</strong> (Número de Parte), <strong>Tipo Servicio</strong>, <strong>Usuario alta</strong> y <strong>Fecha</strong>.</p>
        </div>
        <div class="col-sm-8 col-sm-offset-2">
            <img class="img-responsive" src="{{ asset('img/ayuda/partes/enod_listado_partes_visualizar.PNG') }}" alt="Listado de Partes Diarios"/>
            <p class="text-center help-block"><em>Fig. 2: Vista del listado de partes diarios asignados a una Orden de Trabajo.</em></p>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h4>Búsqueda de Partes</h4>
            <p>En la parte superior derecha de la tabla de partes, encontrará un campo de <strong>Buscar...</strong>. Puede ingresar el número de parte o cualquier otro dato relevante para filtrar la lista y localizar el parte deseado.</p>

            <h4>Acciones Disponibles por Parte</h4>
            <p>A la derecha de cada fila de parte en la tabla, encontrará iconos de acción:</p>
        </div>
        <div class="col-sm-12 detalle_iconos">
            <p><img class="img-responsive" src="{{ asset('img/ayuda/partes/Icono_pdf_parte.PNG') }}" alt="Visualizar PDF"/>&nbsp;&nbsp;<strong>Visualizar PDF:</strong> Icono naranja con un símbolo de PDF. Al hacer clic en este icono, el parte diario se abrirá en formato PDF en una nueva pestaña del navegador, permitiendo su visualización y descarga.</p>
            {{-- Incluye aquí otros iconos si existen y quieres documentarlos --}}
            {{--
            <p><img class="img-responsive" src="{{ asset('img/ayuda/partes/Icono_editar_parte.PNG') }}" alt="Editar Parte"/>&nbsp;&nbsp;<strong>Editar Parte:</strong> Icono para modificar los datos del parte.</p>
            <p><img class="img-responsive" src="{{ asset('img/ayuda/partes/Icono_otra_accion.PNG') }}" alt="Otra Acción"/>&nbsp;&nbsp;<strong>Otra Acción:</strong> Icono y descripción.</p>
            --}}
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h3>Artículos relacionados&nbsp;</h3>
            {{-- Aquí podrías enlazar a otros artículos de ayuda relevantes, por ejemplo: --}}
            {{-- <ul>
                <li><a href="{{ url('ayuda/creacion-partes-diarios') }}">Creación de Partes Diarios</a></li>
                <li><a href="{{ url('ayuda/gestion-ordenes-trabajo') }}">Gestión de Órdenes de Trabajo</a></li>
            </ul> --}}
        </div>
    </div>
</div>

@endsection
