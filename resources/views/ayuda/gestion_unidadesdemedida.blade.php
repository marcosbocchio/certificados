@extends('layouts.enod.master')

@section('contenido')

<div class="ayuda_enod">
    <div class="row">
        <div class="col-sm-12">
            <h2>Gestión de Unidades de Medida</h2>
            <p>Este módulo permite definir y administrar las diversas unidades de medida que se utilizan a lo largo del sistema. Estas unidades son esenciales para cuantificar servicios, mediciones, ítems en informes, entre otros.</p>

            <h3>1. Acceso a la Gestión de Unidades de Medida</h3>
            <p>Para acceder al módulo, diríjase al menú principal y seleccione la opción <strong>Maestros</strong> y luego, dentro del submenú desplegado, haga clic en <strong>Unidades de Medida</strong> (o el nombre exacto que corresponda en su sistema).</p>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h3>2. Vista Principal de Unidades de Medida</h3>
            <p>Al acceder a la sección, se presentará una tabla con el listado de todas las unidades de medida registradas. Por cada unidad, se mostrará su <strong>código</strong> y <strong>Descripción</strong>.</p>
        </div>
        <div class="col-sm-10 col-sm-offset-1">
            <img class="img-responsive" src="{{ asset('img/ayuda/unidades_medida/Listado_unidades_medida.PNG') }}" alt="Listado de Unidades de Medida"/><br>
            <p class="text-center help-block"><em>Fig. 1: Vista principal del listado de unidades de medida. (Basado en image_88455c.png)</em></p>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h4>Paginación</h4>
            <p>Si el listado de unidades de medida es extenso, se activarán los controles de paginación en la parte inferior izquierda de la tabla para navegar entre las diferentes páginas del listado.</p>
            <p>(No se observa una barra de búsqueda en la captura de pantalla para esta sección. Si su sistema la incluye de forma estándar, funcionaría de manera similar a otros módulos).</p>

            <h4>Acciones Disponibles por Unidad de Medida</h4>
            <p>A la derecha de cada fila en la tabla, encontrará los siguientes iconos de acción:</p>
        </div>
        <div class="col-sm-12 detalle_iconos">
            <p><img class="img-responsive" src="{{ asset('img/ayuda/usuarios/Icono_editar_usuario.PNG') }}" alt="Editar Unidad de Medida"/>&nbsp;&nbsp;<strong>Editar Unidad de Medida:</strong> Icono naranja con un lápiz. Permite modificar el código o la descripción de la unidad seleccionada.</p>
            <p><img class="img-responsive" src="{{ asset('img/ayuda/usuarios/Icono_eliminar_usuario.PNG') }}" alt="Eliminar Unidad de Medida"/>&nbsp;&nbsp;<strong>Eliminar Unidad de Medida:</strong> Icono rojo con un cesto de basura. Permite eliminar la unidad del sistema, previa confirmación.</p>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h3>3. Crear una Nueva Unidad de Medida</h3>
            <p>Para agregar una nueva unidad de medida al sistema, haga clic en el botón amarillo <strong>"+ Nuevo"</strong> ubicado en la esquina superior izquierda de la pantalla de listado.</p>
        </div>
         <div class="col-sm-8 col-sm-offset-2">
            <img class="img-responsive" src="{{ asset('img/ayuda/unidades_medida/Formulario_nueva_unidad_medida.PNG') }}" alt="Formulario Nueva Unidad de Medida"/><br>
            <p class="text-center help-block"><em>Fig. 2: Formulario para la creación de una nueva unidad de medida. (Basado en image_88453c.png)</em></p>
        </div>
        <div class="col-sm-12">
            <p>Esto abrirá el formulario de creación con los siguientes campos:</p>
            <ul>
                <li><strong>Código *:</strong> Un código o abreviatura única para la unidad de medida (ej: ", 1/2 Día, Cm, Km, Lts, Metro). Es un campo obligatorio.</li>
                <li><strong>Descripción:</strong> Una descripción más detallada de la unidad de medida (ej: Descripción para la unidad de medida pulgada, Para medio dia de servicio, unidad x Km).</li>
            </ul>
            <h4>Guardar o Cancelar</h4>
            <p>Una vez completados los campos:</p>
            <ul>
                <li>Haga clic en <strong>"Guardar"</strong> para crear la nueva unidad de medida y añadirla al listado.</li>
                <li>Haga clic en <strong>"Cancelar"</strong> para descartar los cambios y cerrar el formulario.</li>
            </ul>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h3>4. Editar una Unidad de Medida Existente</h3>
            <p>Para modificar la información de una unidad de medida ya creada:</p>
            <ol>
                <li>Localice la unidad en la tabla y haga clic en el icono naranja de editar (✏️) correspondiente.</li>
                <li>Se abrirá un formulario similar al de creación, pre-cargado con el Código y Descripción actuales de la unidad.</li>
            </ol>
        </div>
        <div class="col-sm-8 col-sm-offset-2">
            <img class="img-responsive" src="{{ asset('img/ayuda/unidades_medida/Formulario_editar_unidad_medida.PNG') }}" alt="Formulario Editar Unidad de Medida"/><br>
            <p class="text-center help-block"><em>Fig. 3: Ejemplo del formulario de edición de una unidad de medida. (Basado en image_88451b.png)</em></p>
        </div>
        <div class="col-sm-12">
            <ol start="3">
                <li>Realice las modificaciones necesarias en los campos Código o Descripción.</li>
                <li>Haga clic en <strong>"Guardar"</strong> para aplicar los cambios o <strong>"Cancelar"</strong> para descartarlos.</li>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h3>5. Eliminar una Unidad de Medida</h3>
            <p>Para eliminar una unidad de medida del sistema:</p>
            <ol>
                <li>Localice la unidad en la tabla y haga clic en el icono rojo de eliminar (🗑️) correspondiente.</li>
                <li>Se mostrará una ventana de advertencia solicitando confirmación, similar a la de otros módulos (ej: "Advertencia: Está seguro de eliminar el registro '[CÓDIGO]' ?").</li>
                <li>Para proceder con la eliminación, haga clic en el botón <strong>"Aceptar"</strong>.</li>
                <li>Si desea cancelar la operación, haga clic en <strong>"Cancelar"</strong>.</li>
            </ol>
            <p><strong>Importante:</strong> La eliminación de una unidad de medida podría estar restringida si esta se encuentra actualmente en uso en otras partes del sistema (ej: en ítems de cotización, servicios de Órdenes de Trabajo, etc.).</p>
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
