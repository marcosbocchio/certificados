@extends('layouts.enod.master')

@section('contenido')

<div class="ayuda_enod">
    <div class="row">
        <div class="col-sm-12">
            <h2>Gestión de Fuentes</h2>
            <p>El maestro de "Fuentes" se utiliza para definir y catalogar los diferentes tipos de fuentes (ej. fuentes radiactivas como Iridio-192, Selenio-75, o Cobalto-60) que se utilizan en conjunto con ciertos equipos para la realización de ensayos, como la gammagrafía industrial. Para cada tipo de fuente, se registra un código, una descripción y su vida media (T 1/2).</p>

            <h3>1. Acceso a la Gestión de Fuentes</h3>
            <p>Para acceder al módulo, diríjase al menú principal y seleccione la opción <strong>Maestros</strong> y luego, dentro del submenú desplegado, haga clic en <strong>Fuentes</strong>.</p>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h3>2. Vista Principal de Fuentes</h3>
            <p>Al acceder a la sección, se presentará una tabla con el listado de todos los tipos de fuentes registradas. Por cada fuente, se mostrará su <strong>código</strong> y <strong>Descripción</strong>. El dato de "T 1/2" (vida media) se gestiona en los formularios de alta/edición.</p>
        </div>
        <div class="col-sm-10 col-sm-offset-1">
            <img class="img-responsive" src="{{ asset('img/ayuda/fuentes/Listado_fuentes.PNG') }}" alt="Listado de Fuentes"/><br>
            <p class="text-center help-block"><em>Fig. 1: Vista principal del listado de fuentes. (Basado en image_875d3a.png)</em></p>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <p>(No se observan controles de búsqueda o paginación en la captura de pantalla para esta sección, lo que podría indicar que el listado es generalmente corto o que estos controles aparecen con un mayor número de registros).</p>

            <h4>Acciones Disponibles por Fuente</h4>
            <p>A la derecha de cada fila en la tabla, encontrará los siguientes iconos de acción:</p>
        </div>
        <div class="col-sm-12 detalle_iconos">
            <p><img class="img-responsive" src="{{ asset('img/ayuda/usuarios/Icono_editar_usuario.PNG') }}" alt="Editar Fuente"/>&nbsp;&nbsp;<strong>Editar Fuente:</strong> Icono naranja con un lápiz. Permite modificar los datos del tipo de fuente seleccionada.</p>
            <p><img class="img-responsive" src="{{ asset('img/ayuda/usuarios/Icono_eliminar_usuario.PNG') }}" alt="Eliminar Fuente"/>&nbsp;&nbsp;<strong>Eliminar Fuente:</strong> Icono rojo con un cesto de basura. Permite eliminar el tipo de fuente del sistema, previa confirmación.</p>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h3>3. Crear un Nuevo Tipo de Fuente</h3>
            <p>Para agregar un nuevo tipo de fuente al sistema, haga clic en el botón amarillo <strong>"+ Nuevo"</strong> ubicado en la esquina superior izquierda de la pantalla de listado.</p>
        </div>
         <div class="col-sm-8 col-sm-offset-2">
            <img class="img-responsive" src="{{ asset('img/ayuda/fuentes/Formulario_nueva_fuente.PNG') }}" alt="Formulario Nueva Fuente"/><br>
            <p class="text-center help-block"><em>Fig. 2: Formulario para la creación de un nuevo tipo de fuente. (Basado en image_875d1a.png)</em></p>
        </div>
        <div class="col-sm-12">
            <p>Esto abrirá el formulario de creación con los siguientes campos:</p>
            <ul>
                <li><strong>Código *:</strong> Un código único para identificar el tipo de fuente (ej: IR 192 - POLATOM, SE 75 - QSA GLOBAL). Es un campo obligatorio.</li>
                <li><strong>Descripción:</strong> Una descripción adicional o aclaratoria sobre el tipo de fuente.</li>
                <li><strong>T 1/2:</strong> Campo numérico para ingresar la vida media de la fuente, usualmente expresada en días (ej: 74 para Iridio-192).</li>
            </ul>
            <h4>Guardar o Cancelar</h4>
            <p>Una vez completados los campos:</p>
            <ul>
                <li>Haga clic en <strong>"Guardar"</strong> para crear el nuevo tipo de fuente y añadirlo al listado.</li>
                <li>Haga clic en <strong>"Cancelar"</strong> para descartar los cambios y cerrar el formulario.</li>
            </ul>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h3>4. Editar un Tipo de Fuente Existente</h3>
            <p>Para modificar la información de un tipo de fuente ya creado:</p>
            <ol>
                <li>Localice el tipo de fuente en la tabla y haga clic en el icono naranja de editar (✏️) correspondiente.</li>
                <li>Se abrirá un formulario similar al de creación, pre-cargado con el Código, Descripción y T 1/2 actuales.</li>
            </ol>
        </div>
        <div class="col-sm-8 col-sm-offset-2">
            <img class="img-responsive" src="{{ asset('img/ayuda/fuentes/Formulario_editar_fuente.PNG') }}" alt="Formulario Editar Fuente"/><br>
            <p class="text-center help-block"><em>Fig. 3: Ejemplo del formulario de edición de un tipo de fuente. (Basado en image_875cfb.png)</em></p>
        </div>
        <div class="col-sm-12">
            <ol start="3">
                <li>Realice las modificaciones necesarias en los campos.</li>
                <li>Haga clic en <strong>"Guardar"</strong> para aplicar los cambios o <strong>"Cancelar"</strong> para descartarlos.</li>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h3>5. Eliminar un Tipo de Fuente</h3>
            <p>Para eliminar un tipo de fuente del sistema:</p>
            <ol>
                <li>Localice el tipo de fuente en la tabla y haga clic en el icono rojo de eliminar (🗑️) correspondiente.</li>
                <li>Se mostrará una ventana de advertencia solicitando confirmación (ej: "Advertencia: Está seguro de eliminar el registro '[CÓDIGO DE LA FUENTE]' ?").</li>
                <li>Para proceder con la eliminación, haga clic en el botón <strong>"Aceptar"</strong>.</li>
                <li>Si desea cancelar la operación, haga clic en <strong>"Cancelar"</strong>.</li>
            </ol>
            <p><strong>Importante:</strong> La eliminación de un tipo de fuente podría estar restringida si este se encuentra actualmente asignado a equipos en el módulo de "Interno Equipos" o referenciado en otros registros del sistema.</p>
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
