@extends('layouts.enod.master')

@section('contenido')

<div class="ayuda_enod">
    <div class="row">
        <div class="col-sm-12">
            <h2>Creación de Partes Diarios</h2>
            <p>Este módulo permite registrar los partes diarios de trabajo asociados a las Órdenes de Trabajo, vinculando informes y servicios realizados.</p>

            <h3>1. Acceso a la Gestión de Partes</h3>
            <p>Para crear o gestionar partes diarios para una Orden de Trabajo (OT) específica, siga los siguientes pasos desde la página principal del sistema:</p>
            <ol>
                <li>En la barra de búsqueda ubicada en la parte superior derecha de la tabla de "Órdenes de trabajo", ingrese el número de la OT deseada (ej. "3485").</li>
                <li>Presione Enter o haga clic en el icono de la lupa (🔍) para filtrar los resultados.</li>
                <li>Una vez localizada la OT en la tabla, haga clic en el recuadro de "Partes" que se encuentra en la fila de la OT seleccionada. Este icono se identifica con un calendario (Ver Fig. 1).</li>
            </ol>
        </div>
        <div class="col-sm-8 col-sm-offset-2">
            <img class="img-responsive" src="{{ asset('img/ayuda/partes/enod_buscar_ot_partes.gif') }}" alt="Búsqueda de OT y acceso a partes (animación)"/>
            <p class="text-center help-block"><em>Fig. 1: Búsqueda de una Orden de Trabajo y acceso al módulo de partes.</em></p>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h3>2. Vista Principal de Partes Asignados</h3>
            <p>Al acceder a la sección de Partes, se presentará una tabla con el listado de todos los partes diarios ya registrados para la OT seleccionada. Por cada parte, se mostrará información relevante como <strong>N°</strong> (Número de Parte), <strong>Tipo Servicio</strong>, <strong>Usuario alta</strong> y <strong>Fecha</strong>.</p>
        </div>
        <div class="col-sm-8 col-sm-offset-2">
            <img class="img-responsive" src="{{ asset('img/ayuda/partes/enod_listado_partes.PNG') }}" alt="Listado de Partes Diarios"/>
            <p class="text-center help-block"><em>Fig. 2: Vista del listado de partes diarios asignados a una Orden de Trabajo.</em></p>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h3>3. Creación de un Nuevo Parte Diario</h3>
            <p>Para generar un nuevo parte diario, haga clic en el botón amarillo <strong>"+ Nuevo"</strong> ubicado en la esquina superior izquierda de la pantalla de listado de partes.</p>
            <p>Esto abrirá el formulario de creación de partes diarios, donde deberá completar los siguientes campos:</p>

            <h4>3.1. Datos Generales del Parte</h4>
            <ul>
                <li><strong>Obra N°:</strong> Campo para seleccionar el número de obra.</li>
                <li><strong>Fecha *:</strong> Seleccione la fecha del parte. Esta fecha determinará los informes sin parte diario que se mostrarán.</li>
                <li><strong>Permitir Anteriores:</strong> Marque esta casilla si desea visualizar informes sin parte de fechas anteriores a la seleccionada.</li>
                <li><strong>Tipo Servicio:</strong> Elija el tipo de servicio asociado al parte.</li>
                <li><strong>Horario:</strong> Ingrese el horario de inicio del parte diario.</li>
            </ul>

            <h4>3.2. Responsabilidades</h4>
            <ul>
                <li><strong>Operador:</strong> Seleccione los operadores responsables de los trabajos realizados en este parte.</li>
            </ul>

            <h4>3.3. Informes sin Parte Diario</h4>
            <p>En esta sección se mostrarán automáticamente los informes que aún no han sido asociados a un parte diario, filtrados por la <strong>Fecha</strong> seleccionada previamente. Podrá seleccionar los informes que desea incluir en este parte marcando la casilla <strong>"Sel."</strong> junto a cada uno.</p>
            <div class="col-sm-8 col-sm-offset-2">
                <img class="img-responsive" src="{{ asset('img/ayuda/partes/enod_informes_sin_parte.PNG') }}" alt="Informes sin Parte Diario"/>
                <p class="text-center help-block"><em>Fig. 3: Sección de informes pendientes de asignación a un parte diario.</em></p>
            </div>

            <h4>3.4. Servicios</h4>
            <p>Aquí puede agregar los servicios específicos realizados durante el día. Puede seleccionar métodos y descripciones de servicios, así como indicar la cantidad. Esto complementa la información de los informes asociados.</p>

            <h4>3.5. Observaciones</h4>
            <p>Utilice este campo para añadir cualquier aclaración, comentario o detalle adicional relevante sobre el parte diario.</p>
        </div>
        <div class="col-sm-8 col-sm-offset-2">
            <img class="img-responsive" src="{{ asset('img/ayuda/partes/enod_formulario_crear_parte.PNG') }}" alt="Formulario de Creación de Parte Diario"/>
            <p class="text-center help-block"><em>Fig. 4: Ejemplo del formulario de creación de un nuevo parte diario.</em></p>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h3>4. Guardar Parte y Visualización del PDF</h3>
            <p>Una vez que haya completado todos los campos necesarios en el formulario:</p>
            <ul>
                <li>Haga clic en el botón <strong>"Guardar"</strong> ubicado en la parte inferior de la pantalla.</li>
            </ul>
            <p>Al guardar, el sistema realizará las siguientes acciones:</p>
            <ol>
                <li>Lo redirigirá de nuevo a la tabla principal de partes diarios, donde el nuevo parte creado aparecerá en el listado.</li>
                <li>Automáticamente, se abrirá en una nueva pestaña del navegador el archivo PDF correspondiente al parte diario recién creado, permitiendo su visualización y descarga inmediata.</li>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h3>Artículos relacionados&nbsp;</h3>
            {{-- Aquí podrías enlazar a otros artículos de ayuda relevantes, por ejemplo: --}}
            {{-- <ul>
                <li><a href="{{ url('ayuda/visualizacion-informes') }}">Visualización de Informes</a></li>
                <li><a href="{{ url('ayuda/gestion-operadores') }}">Gestión de Operadores</a></li>
            </ul> --}}
        </div>
    </div>
</div>

@endsection
