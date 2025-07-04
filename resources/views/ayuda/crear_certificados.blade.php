@extends('layouts.enod.master')

@section('contenido')

<div class="ayuda_enod">
    <div class="row">
        <div class="col-sm-12">
            <h2>Creación de Certificados</h2>
            <p>Este módulo permite generar y gestionar certificados asociados a los partes diarios de una Orden de Trabajo, permitiendo la consolidación y emisión de documentos finales.</p>

            <h3>1. Acceso a la Gestión de Certificados</h3>
            <p>Para crear o gestionar certificados para una Orden de Trabajo (OT) específica, siga los siguientes pasos desde la página principal del sistema:</p>
            <ol>
                <li>En la barra de búsqueda ubicada en la parte superior derecha de la tabla de "Órdenes de trabajo", ingrese el número de la OT deseada (ej. "3485").</li>
                <li>Presione Enter o haga clic en el icono de la lupa (🔍) para filtrar los resultados.</li>
                <li>Una vez localizada la OT en la tabla, haga clic en el recuadro de "Certificados" que se encuentra en la fila de la OT seleccionada. Este icono se identifica con un documento y un sello (Ver Fig. 1).</li>
            </ol>
        </div>
        <div class="col-sm-8 col-sm-offset-2">
            <img class="img-responsive" src="{{ asset('img/ayuda/certificados/enod_buscar_ot_certificados.gif') }}" alt="Búsqueda de OT y acceso a certificados (animación)"/>
            <p class="text-center help-block"><em>Fig. 1: Búsqueda de una Orden de Trabajo y acceso al módulo de certificados.</em></p>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h3>2. Vista Principal de Certificados Asignados</h3>
            <p>Al acceder a la sección de Certificados, se presentará una tabla con el listado de todos los certificados ya generados para la OT seleccionada. Por cada certificado, se mostrará información relevante como <strong>N°</strong> (Número de Certificado) y <strong>Fecha</strong>.</p>
        </div>
        <div class="col-sm-8 col-sm-offset-2">
            <img class="img-responsive" src="{{ asset('img/ayuda/certificados/enod_listado_certificados.PNG') }}" alt="Listado de Certificados"/>
            <p class="text-center help-block"><em>Fig. 2: Vista del listado de certificados asignados a una Orden de Trabajo.</em></p>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h3>3. Creación de un Nuevo Certificado</h3>
            <p>Para generar un nuevo certificado, haga clic en el botón amarillo <strong>"+ Nuevo"</strong> ubicado en la esquina superior izquierda de la pantalla de listado de certificados.</p>
            <p>Esto abrirá el formulario de creación de certificados, donde deberá completar los siguientes campos:</p>

            <h4>3.1. Datos Generales del Certificado</h4>
            <ul>
                <li><strong>Fecha *:</strong> Ingrese o seleccione la fecha del certificado.</li>
                <li><strong>Certificado N°:</strong> Campo donde se puede ingresar un número de certificado (o se autogenera si aplica).</li>
                <li><strong>Título:</strong> Campo opcional para un título descriptivo del certificado.</li>
                <li><strong>Información adicional:</strong> Espacio para agregar cualquier nota o detalle extra sobre el certificado.</li>
            </ul>

            <h4>3.2. Partes sin Certificados</h4>
            <p>En esta sección se listarán los partes diarios que aún no han sido asociados a ningún certificado. Marque las casillas de selección <strong>"Sel."</strong> de los partes que desea incluir en el nuevo certificado.</p>
        </div>
        <div class="col-sm-8 col-sm-offset-2">
            <img class="img-responsive" src="{{ asset('img/ayuda/certificados/enod_formulario_crear_certificado.PNG') }}" alt="Formulario de Creación de Certificado"/>
            <p class="text-center help-block"><em>Fig. 3: Ejemplo del formulario de creación de un nuevo certificado.</em></p>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h3>4. Guardar Certificado y Visualización del PDF</h3>
            <p>Una vez que haya seleccionado la fecha y los partes a incluir en el certificado:</p>
            <ul>
                <li>Haga clic en el botón <strong>"Guardar"</strong> ubicado en la parte inferior izquierda de la pantalla.</li>
            </ul>
            <p>Al guardar, el sistema realizará las siguientes acciones:</p>
            <ol>
                <li>Lo redirigirá de nuevo a la tabla principal de certificados, donde el nuevo certificado creado aparecerá en el listado.</li>
                <li>Automáticamente, se abrirá en una nueva pestaña del navegador el archivo PDF correspondiente al certificado recién creado, permitiendo su visualización y descarga inmediata.</li>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h3>Artículos relacionados&nbsp;</h3>
            {{-- Aquí podrías enlazar a otros artículos de ayuda relevantes, por ejemplo: --}}
            {{-- <ul>
                <li><a href="{{ url('ayuda/creacion-partes-diarios') }}">Creación de Partes Diarios</a></li>
                <li><a href="{{ url('ayuda/visualizacion-certificados') }}">Visualización de Certificados</a></li>
            </ul> --}}
        </div>
    </div>
</div>

@endsection
