@extends('layouts.enod.master')

@section('contenido')

<div class="ayuda_enod">
    <div class="row">
        <div class="col-sm-12">
            <h2>Gestión de Comitentes</h2>
            <p>Los comitentes son las entidades o empresas para las cuales se realizan los trabajos y a nombre de quién se emiten ciertos documentos o certificaciones. Este módulo permite administrar la información básica de los comitentes.</p>

            <h3>1. Acceso a la Gestión de Comitentes</h3>
            <p>Para acceder al módulo de gestión de comitentes, diríjase al menú principal y seleccione la opción <strong>Maestros</strong> y luego, dentro del submenú desplegado, haga clic en <strong>Comitente</strong> (o el nombre exacto que tenga en su menú, ej: "Comitentes").</p>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h3>2. Vista Principal de Comitentes</h3>
            <p>Al acceder a la sección de Comitentes, se presentará una tabla con el listado de todos los comitentes registrados. Por cada comitente, se mostrará su <strong>Nombre</strong>. Otros detalles como la Razón Social se gestionan en el formulario de alta/edición.</p>
        </div>
        <div class="col-sm-10 col-sm-offset-1">
            <img class="img-responsive" src="{{ asset('img/ayuda/comitentes/Listado_comitentes.PNG') }}" alt="Listado de Comitentes"/><br>
            <p class="text-center help-block"><em>Fig. 1: Vista principal del listado de comitentes. (Basado en image_892dd8.png)</em></p>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h4>Acciones Disponibles por Comitente</h4>
            <p>A la derecha de cada fila de comitente en la tabla, encontrará los siguientes iconos de acción:</p>
            <p>.</p>
        </div>
        <div class="col-sm-12 detalle_iconos">
            <p><img class="img-responsive" src="{{ asset('img/ayuda/usuarios/Icono_editar_usuario.PNG') }}" alt="Editar Comitente"/>&nbsp;&nbsp;<strong>Editar Comitente:</strong> Icono naranja con un lápiz. Permite modificar los datos del comitente seleccionado.</p>
            <p><img class="img-responsive" src="{{ asset('img/ayuda/usuarios/Icono_eliminar_usuario.PNG') }}" alt="Eliminar Comitente"/>&nbsp;&nbsp;<strong>Eliminar Comitente:</strong> Icono rojo con un cesto de basura. Permite eliminar el comitente del sistema, previa confirmación.</p>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h3>3. Crear un Nuevo Comitente</h3>
            <p>Para agregar un nuevo comitente al sistema, haga clic en el botón amarillo <strong>"+ Nuevo"</strong> ubicado en la esquina superior izquierda de la pantalla de listado de comitentes.</p>
        </div>
         <div class="col-sm-8 col-sm-offset-2">
            <img class="img-responsive" src="{{ asset('img/ayuda/comitentes/Formulario_nuevo_comitente.PNG') }}" alt="Formulario Nuevo Comitente"/><br>
            <p class="text-center help-block"><em>Fig. 2: Formulario para la creación de un nuevo comitente. (Basado en image_892b0f.png)</em></p>
        </div>
        <div class="col-sm-12">
            <p>Esto abrirá el formulario de creación de comitentes con los siguientes campos (los campos con * son obligatorios):</p>
            <ul>
                <li><strong>Nombre *:</strong> Nombre identificatorio del comitente. Este es el nombre que usualmente se mostrará en los listados.</li>
                <li><strong>Razón Social *:</strong> Razón social legal completa del comitente.</li>
                <li><strong>Logo:</strong> Permite cargar el logo del comitente. Haga clic en "Seleccionar archivo" para buscar la imagen en su equipo.
                    <ul>
                        <li><em>Formatos soportados: .png, .bmp, .jpg.</em></li>
                    </ul>
                </li>
            </ul>
            <h4>Guardar o Cancelar</h4>
            <p>Una vez completados todos los campos necesarios:</p>
            <ul>
                <li>Haga clic en <strong>"Guardar"</strong> para crear el nuevo comitente y añadirlo al listado.</li>
                <li>Haga clic en <strong>"Cancelar"</strong> para descartar los cambios y cerrar el formulario.</li>
            </ul>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h3>4. Editar un Comitente Existente</h3>
            <p>Para modificar la información de un comitente ya creado:</p>
            <ol>
                <li>Localice el comitente en la tabla y haga clic en el icono naranja de editar (✏️) correspondiente.</li>
                <li>Se abrirá un formulario similar al de creación, pero pre-cargado con los datos actuales del comitente. Si el comitente ya tiene un logo cargado, se mostrará una previsualización.</li>
            </ol>
        </div>
        <div class="col-sm-8 col-sm-offset-2">
            <img class="img-responsive" src="{{ asset('img/ayuda/comitentes/Formulario_editar_comitente.PNG') }}" alt="Formulario Editar Comitente"/><br>
            <p class="text-center help-block"><em>Fig. 3: Ejemplo del formulario de edición de un comitente, mostrando datos y un logo cargado. (Basado en image_892aec.png)</em></p>
        </div>
        <div class="col-sm-12">
            <ol start="3">
                <li>Realice las modificaciones necesarias en los campos Nombre, Razón Social o cambie el Logo si es necesario.</li>
                <li>Haga clic en <strong>"Guardar"</strong> para aplicar los cambios o <strong>"Cancelar"</strong> para descartarlos.</li>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h3>5. Eliminar un Comitente</h3>
            <p>Para eliminar un comitente del sistema:</p>
            <ol>
                <li>Localice el comitente en la tabla y haga clic en el icono rojo de eliminar (🗑️) correspondiente.</li>
                <li>Se mostrará una ventana de advertencia con el mensaje: <strong>"Advertencia: Está seguro de eliminar el registro '[NOMBRE DEL COMITENTE]' ?"</strong>.</li>
            </ol>
        </div>
        <div class="col-sm-8 col-sm-offset-2">
            <img class="img-responsive" src="{{ asset('img/ayuda/comitentes/Dialogo_eliminar_comitente.PNG') }}" alt="Diálogo Eliminar Comitente"/><br>
            <p class="text-center help-block"><em>Fig. 4: Ventana de confirmación para eliminar un comitente. (Basado en image_892a70.png)</em></p>
        </div>
         <div class="col-sm-12">
            <ol start="3">
                <li>Para proceder con la eliminación, haga clic en el botón <strong>"Aceptar"</strong>.</li>
                <li>Si desea cancelar la operación, haga clic en <strong>"Cancelar"</strong>.</li>
            </ol>
            <p><strong>Importante:</strong> La eliminación de un comitente puede estar restringida si este tiene registros asociados en otras partes del sistema (por ejemplo, si está vinculado a Órdenes de Trabajo activas o históricas).</p>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h3>Artículos relacionados&nbsp;</h3>
            <p><a href="{{ route('ayuda-ordenes-trabajo') }}">Gestión de Órdenes de Trabajo (OT)</a></p>
            <p><a href="{{ route('ayuda-gestion-clientes') }}">Gestión de Clientes</a></p>
            <p><a href="{{ route('ayuda-informes-configuracion') }}">Configuración de Informes (donde podría usarse el logo del comitente)</a></p>
        </div>
    </div>
</div>

@endsection
