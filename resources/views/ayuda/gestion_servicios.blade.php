@extends('layouts.enod.master')

@section('contenido')

<div class="ayuda_enod">
    <div class="row">
        <div class="col-sm-12">
            <h2>Gestión de Servicios</h2>
            <p>El maestro de "Servicios" permite definir y catalogar los diferentes tipos de servicios que la empresa ofrece. Cada servicio se define con un código, una descripción, una unidad de medida para su cuantificación, y un método de ensayo asociado. Estos servicios son fundamentales para la creación de cotizaciones y Órdenes de Trabajo (OT).</p>

            <h3>1. Acceso a la Gestión de Servicios</h3>
            <p>Para acceder al módulo, diríjase al menú principal y seleccione la opción <strong>Maestros</strong> y luego, dentro del submenú desplegado, haga clic en <strong>Servicios</strong>.</p>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h3>2. Vista Principal de Servicios</h3>
            <p>Al acceder a la sección, se presentará una tabla con el listado de todos los servicios registrados. Por cada servicio, se mostrará su <strong>Código</strong>, <strong>Descripción</strong>, <strong>Unidad Medida</strong> y el <strong>Método ensayo</strong> asociado.</p>
        </div>
        <div class="col-sm-12"> <img class="img-responsive" src="{{ asset('img/ayuda/servicios/Listado_servicios.PNG') }}" alt="Listado de Servicios"/><br>
            <p class="text-center help-block"><em>Fig. 1: Vista principal del listado de servicios. (Basado en image_87dc60.png)</em></p>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h4>Buscar Servicios</h4>
            <p>En la parte superior derecha de la tabla, encontrará un campo de <strong>Buscar...</strong>. Ingrese el código, parte de la descripción, unidad de medida o método de ensayo del servicio que desea localizar y presione Enter o haga clic en el icono de la lupa (🔍) para filtrar la lista.</p>

            <h4>Paginación</h4>
            <p>Si el listado de servicios es extenso, se activarán los controles de paginación en la parte inferior izquierda de la tabla para navegar entre las diferentes páginas del listado.</p>

            <h4>Acciones Disponibles por Servicio</h4>
            <p>A la derecha de cada fila en la tabla, encontrará los siguientes iconos de acción:</p>
        </div>
        <div class="col-sm-12 detalle_iconos">
            <p><img class="img-responsive" src="{{ asset('img/ayuda/usuarios/Icono_editar_usuario.PNG') }}" alt="Editar Servicio"/>&nbsp;&nbsp;<strong>Editar Servicio:</strong> Icono naranja con un lápiz. Permite modificar los datos del servicio seleccionado.</p>
            <p><img class="img-responsive" src="{{ asset('img/ayuda/usuarios/Icono_eliminar_usuario.PNG') }}" alt="Eliminar Servicio"/>&nbsp;&nbsp;<strong>Eliminar Servicio:</strong> Icono rojo con un cesto de basura. Permite eliminar el servicio del sistema, previa confirmación.</p>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h3>3. Crear un Nuevo Servicio</h3>
            <p>Para agregar un nuevo servicio al sistema, haga clic en el botón amarillo <strong>"+ Nuevo"</strong> ubicado en la esquina superior izquierda de la pantalla de listado.</p>
        </div>
         <div class="col-sm-8 col-sm-offset-2">
            <img class="img-responsive" src="{{ asset('img/ayuda/servicios/Formulario_nuevo_servicio.PNG') }}" alt="Formulario Nuevo Servicio"/><br>
            <p class="text-center help-block"><em>Fig. 2: Formulario para la creación de un nuevo servicio. (Basado en image_87d897.png)</em></p>
        </div>
        <div class="col-sm-12">
            <p>Esto abrirá el formulario de creación con los siguientes campos:</p>
            <ul>
                <li><strong>Código *:</strong> Un código único para identificar el servicio (ej: BOR1, C12A). Es un campo obligatorio.</li>
                <li><strong>Descripción:</strong> Una descripción detallada del servicio (ej: BOROSCOPIA - 12 HORAS (LUNES A VIERNES), Servicio de Radiografía Digital CR por Día (12hs) A).</li>
                <li><strong>Unidad Medida *:</strong> Un menú desplegable para seleccionar la unidad en la que se medirá o cotizará el servicio (ej: Hora, Día, Mes, Unidad). Estas unidades se cargan desde el maestro de "Unidades de Medida". Es un campo obligatorio.</li>
                <li><strong>Método Ensayo *:</strong> Un menú desplegable para seleccionar el método de ensayo asociado al servicio (ej: IV para Inspección Visual, RD para Radiografía Digital, CI para Corrientes Inducidas). Estos métodos se definen en otra sección del sistema. Es un campo obligatorio.</li>
            </ul>
            <h4>Guardar o Cancelar</h4>
            <p>Una vez completados los campos:</p>
            <ul>
                <li>Haga clic en <strong>"Guardar"</strong> para crear el nuevo servicio y añadirlo al listado.</li>
                <li>Haga clic en <strong>"Cancelar"</strong> para descartar los cambios y cerrar el formulario.</li>
            </ul>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h3>4. Editar un Servicio Existente</h3>
            <p>Para modificar la información de un servicio ya creado:</p>
            <ol>
                <li>Localice el servicio en la tabla y haga clic en el icono naranja de editar (✏️) correspondiente.</li>
                <li>Se abrirá un formulario similar al de creación, pre-cargado con los datos actuales del servicio.</li>
            </ol>
        </div>
        <div class="col-sm-8 col-sm-offset-2">
            <img class="img-responsive" src="{{ asset('img/ayuda/servicios/Formulario_editar_servicio.PNG') }}" alt="Formulario Editar Servicio"/><br>
            <p class="text-center help-block"><em>Fig. 3: Ejemplo del formulario de edición de un servicio. (Basado en image_87d861.png)</em></p>
        </div>
        <div class="col-sm-12">
            <ol start="3">
                <li>Realice las modificaciones necesarias en los campos. Puede cambiar el código, la descripción o seleccionar diferentes opciones de los desplegables de Unidad Medida y Método Ensayo.</li>
                <li>Haga clic en <strong>"Guardar"</strong> para aplicar los cambios o <strong>"Cancelar"</strong> para descartarlos.</li>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h3>5. Eliminar un Servicio</h3>
            <p>Para eliminar un servicio del sistema:</p>
            <ol>
                <li>Localice el servicio en la tabla y haga clic en el icono rojo de eliminar (🗑️) correspondiente.</li>
                <li>Se mostrará una ventana de advertencia solicitando confirmación, similar a la de otros módulos (ej: "Advertencia: Está seguro de eliminar el registro '[CÓDIGO DEL SERVICIO]' ?").</li>
                <li>Para proceder con la eliminación, haga clic en el botón <strong>"Aceptar"</strong>.</li>
                <li>Si desea cancelar la operación, haga clic en <strong>"Cancelar"</strong>.</li>
            </ol>
            <p><strong>Importante:</strong> La eliminación de un servicio podría estar restringida si este se encuentra actualmente en uso en Órdenes de Trabajo, cotizaciones u otras partes del sistema.</p>
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
