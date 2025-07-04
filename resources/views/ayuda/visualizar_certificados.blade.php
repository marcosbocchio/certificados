@extends('layouts.enod.master')

@section('contenido')

<div class="ayuda_enod">
    <div class="row">
        <div class="col-sm-12">
            <h2>Visualización de Certificados</h2>
            <p>Este módulo permite acceder y visualizar los certificados de trabajo generados y asociados a las órdenes de trabajo del sistema.</p>

            <h3>1. Acceso a la Visualización de Certificados desde la Página Principal</h3>
            <p>Para acceder a los certificados de una Orden de Trabajo (OT) específica, siga los siguientes pasos desde la página principal del sistema:</p>
            <ol>
                <li>En la barra de búsqueda ubicada en la parte superior derecha de la tabla de "Órdenes de trabajo", ingrese el número de la OT deseada.</li>
                <li>Presione Enter o haga clic en el icono de la lupa (🔍) para filtrar los resultados.</li>
                <li>Una vez localizada la OT en la tabla, haga clic en el recuadro de "Certificados" que se encuentra en la fila de la OT seleccionada. Este icono se identifica con un documento y un sello.</li>
            </ol>
        </div>
        <div class="col-sm-8 col-sm-offset-2">
            {{-- Asumiendo una animación o imagen que muestre la búsqueda de OT y el clic en el botón de "Certificados" --}}
            <img class="img-responsive" src="{{ asset('img/ayuda/certificados/enod_buscar_ot_visualizar_cert.gif') }}" alt="Búsqueda de OT y acceso a certificados (animación)"/>
            <p class="text-center help-block"><em>Fig. 1: Búsqueda de una Orden de Trabajo y acceso al módulo de certificados.</em></p>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h3>2. Vista Principal de Certificados Asignados</h3>
            <p>Al acceder a la sección de Certificados, se presentará una tabla con el listado de todos los certificados ya generados para la OT seleccionada. Por cada certificado, se mostrará información relevante como <strong>N°</strong> (Número de Certificado) y <strong>Fecha</strong>.</p>
        </div>
        <div class="col-sm-8 col-sm-offset-2">
            {{-- Asumiendo una imagen del listado de certificados --}}
            <img class="img-responsive" src="{{ asset('img/ayuda/certificados/enod_listado_certificados_visualizar.PNG') }}" alt="Listado de Certificados"/>
            <p class="text-center help-block"><em>Fig. 2: Vista del listado de certificados asignados a una Orden de Trabajo.</em></p>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h4>Búsqueda de Certificados</h4>
            <p>En la parte superior derecha de la tabla de certificados, encontrará un campo de <strong>Buscar...</strong>. Puede ingresar el número de certificado o cualquier otro dato relevante para filtrar la lista y localizar el certificado deseado.</p>

            <h4>Acciones Disponibles por Certificado</h4>
            <p>A la derecha de cada fila de certificado en la tabla, encontrará iconos de acción:</p>
        </div>
        <div class="col-sm-12 detalle_iconos">
            <p><img class="img-responsive" src="{{ asset('img/ayuda/certificados/Icono_pdf_certificado.PNG') }}" alt="Visualizar PDF"/>&nbsp;&nbsp;<strong>Visualizar PDF:</strong> Icono naranja con un símbolo de PDF. Al hacer clic en este icono, el certificado se abrirá en formato PDF en una nueva pestaña del navegador, permitiendo su visualización y descarga.</p>
            {{-- Incluye aquí otros iconos si existen y quieres documentarlos --}}
            {{--
            <p><img class="img-responsive" src="{{ asset('img/ayuda/certificados/Icono_editar_certificado.PNG') }}" alt="Editar Certificado"/>&nbsp;&nbsp;<strong>Editar Certificado:</strong> Icono para modificar los datos del certificado.</p>
            <p><img class="img-responsive" src="{{ asset('img/ayuda/certificados/Icono_otra_accion.PNG') }}" alt="Otra Acción"/>&nbsp;&nbsp;<strong>Otra Acción:</strong> Icono y descripción.</p>
            --}}
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h3>Artículos relacionados&nbsp;</h3>
            {{-- Aquí podrías enlazar a otros artículos de ayuda relevantes, por ejemplo: --}}
            {{-- <ul>
                <li><a href="{{ url('ayuda/creacion-certificados') }}">Creación de Certificados</a></li>
                <li><a href="{{ url('ayuda/gestion-ordenes-trabajo') }}">Gestión de Órdenes de Trabajo</a></li>
            </ul> --}}
        </div>
    </div>
</div>

@endsection
