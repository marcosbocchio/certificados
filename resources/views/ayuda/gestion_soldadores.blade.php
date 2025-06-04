@extends('layouts.enod.master')

@section('contenido')

<div class="ayuda_enod">
    <div class="row">
        <div class="col-sm-12">
            <h2>Gestión de Soldadores por Cliente</h2>
            <p>El maestro de "Soldadores" permite registrar y administrar los soldadores asociados a un cliente particular. Esta información es crucial para la trazabilidad y la asignación de soldadores en los informes de ciertos ensayos (especialmente en Radiografía Industrial - RI).</p>
            <p><strong>Importante:</strong> La gestión de soldadores se realiza por cliente. Primero debe seleccionar un cliente para ver, agregar, editar o eliminar los soldadores vinculados a él.</p>

            <h3>1. Acceso a la Gestión de Soldadores</h3>
            <p>Para acceder al módulo, diríjase al menú principal y seleccione la opción <strong>Maestros</strong> y luego, dentro del submenú desplegado, haga clic en <strong>Soldadores</strong>.</p>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h3>2. Selección del Cliente y Vista de Soldadores</h3>
            <p>Al ingresar a la sección de Soldadores, la primera acción requerida es seleccionar un cliente:</p>
            <ul>
                <li>Utilice el menú desplegable etiquetado como <strong>"SELECCIONE EL CLIENTE:"</strong> para elegir el cliente cuyos soldadores desea gestionar.</li>
            </ul>
        </div>
        <div class="col-sm-10 col-sm-offset-1">
            <img class="img-responsive" src="{{ asset('img/ayuda/soldadores/Seleccion_cliente_y_listado_soldadores.PNG') }}" alt="Selección de Cliente y Listado de Soldadores"/><br>
            <p class="text-center help-block"><em>Fig. 1: Selección de cliente y visualización de soldadores asociados. (Basado en image_87c670.png)</em></p>
        </div>
        <div class="col-sm-12">
            <p>Una vez seleccionado un cliente, se mostrará una tabla debajo con los soldadores actualmente asignados a ese cliente. Las columnas son:</p>
            <ul>
                <li><strong>código:</strong> Código o estampilla identificatoria del soldador.</li>
                <li><strong>Nombre:</strong> Nombre del soldador.</li>
            </ul>
            <p>(No se observan controles de búsqueda o paginación para la lista de soldadores de un cliente específico en la captura, lo que sugiere que se espera un número manejable de soldadores por cliente).</p>
            <h4>Acciones Disponibles por Soldador (del cliente seleccionado)</h4>
            <p>A la derecha de cada fila de soldador en la tabla, encontrará los siguientes iconos de acción:</p>
        </div>
        <div class="col-sm-12 detalle_iconos">
            <p><img class="img-responsive" src="{{ asset('img/ayuda/usuarios/Icono_editar_usuario.PNG') }}" alt="Editar Soldador"/>&nbsp;&nbsp;<strong>Editar Soldador:</strong> Icono naranja con un lápiz. Permite modificar el código o nombre del soldador seleccionado.</p>
            <p><img class="img-responsive" src="{{ asset('img/ayuda/usuarios/Icono_eliminar_usuario.PNG') }}" alt="Eliminar Soldador"/>&nbsp;&nbsp;<strong>Eliminar Soldador:</strong> Icono rojo con un cesto de basura. Permite desvincular/eliminar el soldador para ese cliente, previa confirmación.</p>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h3>3. Crear un Nuevo Soldador para el Cliente Seleccionado</h3>
            <p>Asegúrese de tener un cliente seleccionado. Luego, para agregar un nuevo soldador a ese cliente, haga clic en el botón amarillo <strong>"+ Nuevo"</strong> ubicado en la esquina superior izquierda (debajo del selector de cliente).</p>
        </div>
         <div class="col-sm-8 col-sm-offset-2">
            <img class="img-responsive" src="{{ asset('img/ayuda/soldadores/Formulario_nuevo_soldador.PNG') }}" alt="Formulario Nuevo Soldador"/><br>
            <p class="text-center help-block"><em>Fig. 2: Formulario para la creación de un nuevo soldador para el cliente seleccionado. (Basado en image_87c630.png)</em></p>
        </div>
        <div class="col-sm-12">
            <p>Esto abrirá el formulario de creación con los siguientes campos:</p>
            <ul>
                <li><strong>Código *:</strong> Código o estampilla única del soldador (ej: hola). Es un campo obligatorio.</li>
                <li><strong>Nombre *:</strong> Nombre completo del soldador (ej: bysergio). Es un campo obligatorio.</li>
            </ul>
            <h4>Guardar o Cancelar</h4>
            <p>Una vez completados los campos:</p>
            <ul>
                <li>Haga clic en <strong>"Guardar"</strong> para crear el nuevo soldador y asociarlo al cliente actualmente seleccionado. El soldador aparecerá en el listado.</li>
                <li>Haga clic en <strong>"Cancelar"</strong> para descartar los cambios y cerrar el formulario.</li>
            </ul>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h3>4. Editar un Soldador Existente</h3>
            <p>Para modificar la información de un soldador ya asignado a un cliente:</p>
            <ol>
                <li>Asegúrese de tener seleccionado el cliente correcto.</li>
                <li>Localice el soldador en la tabla y haga clic en el icono naranja de editar (✏️) correspondiente.</li>
                <li>Se abrirá un formulario similar al de creación, pre-cargado con el Código y Nombre actuales del soldador.</li>
                <li>Realice las modificaciones necesarias.</li>
                <li>Haga clic en <strong>"Guardar"</strong> para aplicar los cambios o <strong>"Cancelar"</strong> para descartarlos.</li>
            </ol>
            <p><em>(El formulario de edición es visualmente idéntico al de creación -Fig. 2-, pero con los campos rellenos con la información del soldador a editar).</em></p>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h3>5. Eliminar un Soldador del Cliente</h3>
            <p>Para eliminar (o desvincular) un soldador de un cliente específico:</p>
            <ol>
                <li>Asegúrese de tener seleccionado el cliente correcto.</li>
                <li>Localice el soldador en la tabla y haga clic en el icono rojo de eliminar (🗑️) correspondiente.</li>
                <li>Se mostrará una ventana de advertencia solicitando confirmación, similar a la de otros módulos (ej: "Advertencia: Está seguro de eliminar el registro '[CÓDIGO DEL SOLDADOR]' ?").</li>
                <li>Para proceder con la eliminación, haga clic en el botón <strong>"Aceptar"</strong>.</li>
                <li>Si desea cancelar la operación, haga clic en <strong>"Cancelar"</strong>.</li>
            </ol>
            <p><strong>Importante:</strong> Eliminar un soldador aquí lo quita de la lista de ese cliente. Considere si el soldador debe ser eliminado completamente del sistema o solo desvinculado de este cliente, según la lógica de su aplicación.</p>
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
