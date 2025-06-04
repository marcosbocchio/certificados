@extends('layouts.enod.master')

@section('contenido')

<div class="ayuda_enod">
    <div class="row">
        <div class="col-sm-12">
            <h2>Gestión de Equipos</h2>
            <p>El maestro de "Equipos" es fundamental para registrar y catalogar todos los equipos utilizados por la empresa para realizar ensayos, mediciones u otras operaciones. Cada equipo se define con un código, descripción, y se asocia a un método de ensayo, un tipo de equipamiento y, opcionalmente, un instrumento de medición específico.</p>

            <h3>1. Acceso a la Gestión de Equipos</h3>
            <p>Para acceder al módulo, diríjase al menú principal y seleccione la opción <strong>Maestros</strong> y luego, dentro del submenú desplegado, haga clic en <strong>Equipos</strong>.</p>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h3>2. Vista Principal de Equipos</h3>
            <p>Al acceder a la sección, se presentará una tabla con el listado de todos los equipos registrados. Las columnas principales son: <strong>código</strong>, <strong>Descripción</strong>, <strong>Método</strong> (método de ensayo principal asociado), <strong>Tipo Equipamiento</strong>, e <strong>Inst. Medición</strong> (Instrumento de Medición).</p>
        </div>
        <div class="col-sm-12"> <img class="img-responsive" src="{{ asset('img/ayuda/equipos/Listado_equipos.PNG') }}" alt="Listado de Equipos"/><br>
            <p class="text-center help-block"><em>Fig. 1: Vista principal del listado de equipos. (Basado en image_876fd8.png)</em></p>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h4>Buscar Equipos</h4>
            <p>En la parte superior derecha de la tabla, encontrará un campo de <strong>Buscar...</strong>. Ingrese el código, parte de la descripción, método, o tipo de equipamiento para localizarlo y presione Enter o haga clic en el icono de la lupa (🔍) para filtrar la lista.</p>

            <h4>Paginación</h4>
            <p>Si el listado de equipos es extenso, se activarán los controles de paginación en la parte inferior izquierda de la tabla para navegar entre las diferentes páginas del listado.</p>

            <h4>Acciones Disponibles por Equipo</h4>
            <p>A la derecha de cada fila en la tabla, encontrará los siguientes iconos de acción:</p>
        </div>
        <div class="col-sm-12 detalle_iconos">
            <p><img class="img-responsive" src="{{ asset('img/ayuda/usuarios/Icono_editar_usuario.PNG') }}" alt="Editar Equipo"/>&nbsp;&nbsp;<strong>Editar Equipo:</strong> Icono naranja con un lápiz. Permite modificar los datos del equipo seleccionado.</p>
            <p><img class="img-responsive" src="{{ asset('img/ayuda/usuarios/Icono_eliminar_usuario.PNG') }}" alt="Eliminar Equipo"/>&nbsp;&nbsp;<strong>Eliminar Equipo:</strong> Icono rojo con un cesto de basura. Permite eliminar el equipo del sistema, previa confirmación.</p>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h3>3. Crear un Nuevo Equipo</h3>
            <p>Para agregar un nuevo equipo al sistema, haga clic en el botón amarillo <strong>"+ Nuevo"</strong> ubicado en la esquina superior izquierda de la pantalla de listado.</p>
        </div>
         <div class="col-sm-8 col-sm-offset-2">
            <img class="img-responsive" src="{{ asset('img/ayuda/equipos/Formulario_nuevo_equipo.PNG') }}" alt="Formulario Nuevo Equipo"/><br>
            <p class="text-center help-block"><em>Fig. 2: Formulario para la creación de un nuevo equipo. (Basado en image_876f25.png)</em></p>
        </div>
        <div class="col-sm-12">
            <p>Esto abrirá el formulario de creación con los siguientes campos:</p>
            <ul>
                <li><strong>Código *:</strong> Un código único para identificar el equipo (ej: LUZ, DUR1, ESECO). Es un campo obligatorio.</li>
                <li><strong>Descripción:</strong> Nombre o descripción detallada del equipo (ej: Luz Solar, prueba dureza, DENSITOMETRO).</li>
                <li><strong>Método de Ensayo *:</strong> Un menú desplegable para seleccionar el método de ensayo principal con el que se utiliza este equipo (ej: PM - PARTÍCULAS MAGNETIZABLES, RI - RADIOGRAFÍA INDUSTRIAL, US - ULTRASONIDO). Es un campo obligatorio.</li>
                <li><strong>Tipo Equipamiento:</strong> Un menú desplegable para clasificar el tipo de equipamiento (ej: EQUIPO-DENSITOMETRO, EQUIPO-PROYECTOR, EQUIPO-DOSIMETRO INTEGRADOR). Este campo puede depender o estar filtrado por el "Método de Ensayo" seleccionado.</li>
                <li><strong>Instrumento Medición:</strong> Un menú desplegable para seleccionar un instrumento de medición más específico asociado al equipo, si aplica. Este campo puede ser opcional.</li>
            </ul>
            <h4>Guardar o Cancelar</h4>
            <p>Una vez completados los campos:</p>
            <ul>
                <li>Haga clic en <strong>"Guardar"</strong> para crear el nuevo equipo y añadirlo al listado.</li>
                <li>Haga clic en <strong>"Cancelar"</strong> para descartar los cambios y cerrar el formulario.</li>
            </ul>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h3>4. Editar un Equipo Existente</h3>
            <p>Para modificar la información de un equipo ya creado:</p>
            <ol>
                <li>Localice el equipo en la tabla y haga clic en el icono naranja de editar (✏️) correspondiente.</li>
                <li>Se abrirá un formulario similar al de creación, pre-cargado con los datos actuales del equipo.</li>
            </ol>
        </div>
        <div class="col-sm-8 col-sm-offset-2">
            <img class="img-responsive" src="{{ asset('img/ayuda/equipos/Formulario_editar_equipo.PNG') }}" alt="Formulario Editar Equipo"/><br>
            <p class="text-center help-block"><em>Fig. 3: Ejemplo del formulario de edición de un equipo. (Basado en image_876c78.png)</em></p>
        </div>
        <div class="col-sm-12">
            <ol start="3">
                <li>Realice las modificaciones necesarias en los campos. Puede cambiar el código, la descripción o seleccionar diferentes opciones de los desplegables de Método de Ensayo, Tipo Equipamiento e Instrumento Medición.</li>
                <li>Haga clic en <strong>"Guardar"</strong> para aplicar los cambios o <strong>"Cancelar"</strong> para descartarlos.</li>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h3>5. Eliminar un Equipo</h3>
            <p>Para eliminar un equipo del sistema:</p>
            <ol>
                <li>Localice el equipo en la tabla y haga clic en el icono rojo de eliminar (🗑️) correspondiente.</li>
                <li>Se mostrará una ventana de advertencia solicitando confirmación (ej: "Advertencia: Está seguro de eliminar el registro '[CÓDIGO DEL EQUIPO]' ?").</li>
                <li>Para proceder con la eliminación, haga clic en el botón <strong>"Aceptar"</strong>.</li>
                <li>Si desea cancelar la operación, haga clic en <strong>"Cancelar"</strong>.</li>
            </ol>
            <p><strong>Importante:</strong> La eliminación de un equipo podría estar restringida si este tiene documentación asociada (calibraciones, verificaciones), está asignado a Órdenes de Trabajo, o tiene otros registros vinculados en el sistema.</p>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <hr>
            <h3>Artículos relacionados&nbsp;</h3>
            </div>
    </div>
</div>

@endsection
