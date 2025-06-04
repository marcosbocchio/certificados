@extends('layouts.enod.master')

@section('contenido')

<div class="ayuda_enod">
    <div class="row">
        <div class="col-sm-12">
            <h2>Gestión de Medidas</h2>
            <p>El módulo de "Medidas" permite definir y catalogar dimensiones, tamaños o cantidades específicas que se utilizan en el sistema, asociándolas con una descripción y una unidad de medida previamente creada. Esto ayuda a estandarizar la forma en que se refieren a diferentes magnitudes en informes, servicios u otros contextos.</p>

            <h3>1. Acceso a la Gestión de Medidas</h3>
            <p>Para acceder al módulo, diríjase al menú principal y seleccione la opción <strong>Maestros</strong> y luego, dentro del submenú desplegado, haga clic en <strong>Medidas</strong>.</p>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h3>2. Vista Principal de Medidas</h3>
            <p>Al acceder a la sección, se presentará una tabla con el listado de todas las medidas registradas. Por cada medida, se mostrará su <strong>código</strong>, <strong>Descripción</strong> y la <strong>Unidad medida</strong> asociada.</p>
        </div>
        <div class="col-sm-10 col-sm-offset-1">
            <img class="img-responsive" src="{{ asset('img/ayuda/medidas/Listado_medidas.PNG') }}" alt="Listado de Medidas"/><br>
            <p class="text-center help-block"><em>Fig. 1: Vista principal del listado de medidas. (Basado en image_883a71.png)</em></p>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h4>Paginación</h4>
            <p>Si el listado de medidas es extenso, se activarán los controles de paginación en la parte inferior izquierda de la tabla para navegar entre las diferentes páginas del listado.</p>
            <p>(No se observa una barra de búsqueda en la captura de pantalla para esta sección. Si su sistema la incluye de forma estándar, funcionaría de manera similar a otros módulos).</p>

            <h4>Acciones Disponibles por Medida</h4>
            <p>A la derecha de cada fila en la tabla, encontrará los siguientes iconos de acción:</p>
        </div>
        <div class="col-sm-12 detalle_iconos">
            <p><img class="img-responsive" src="{{ asset('img/ayuda/usuarios/Icono_editar_usuario.PNG') }}" alt="Editar Medida"/>&nbsp;&nbsp;<strong>Editar Medida:</strong> Icono naranja con un lápiz. Permite modificar los datos de la medida seleccionada.</p>
            <p><img class="img-responsive" src="{{ asset('img/ayuda/usuarios/Icono_eliminar_usuario.PNG') }}" alt="Eliminar Medida"/>&nbsp;&nbsp;<strong>Eliminar Medida:</strong> Icono rojo con un cesto de basura. Permite eliminar la medida del sistema, previa confirmación.</p>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h3>3. Crear una Nueva Medida</h3>
            <p>Para agregar una nueva medida al sistema, haga clic en el botón amarillo <strong>"+ Nuevo"</strong> ubicado en la esquina superior izquierda de la pantalla de listado.</p>
        </div>
         <div class="col-sm-8 col-sm-offset-2">
            <img class="img-responsive" src="{{ asset('img/ayuda/medidas/Formulario_nueva_medida.PNG') }}" alt="Formulario Nueva Medida"/><br>
            <p class="text-center help-block"><em>Fig. 2: Formulario para la creación de una nueva medida. (Basado en image_883a50.png)</em></p>
        </div>
        <div class="col-sm-12">
            <p>Esto abrirá el formulario de creación con los siguientes campos:</p>
            <ul>
                <li><strong>Código *:</strong> Un código o valor que representa la medida (ej: <: 04", >3"x43cm, S4, 06" a 08"). Es un campo obligatorio.</li>
                <li><strong>Descripción:</strong> Una descripción textual de lo que representa la medida (ej: Probetas Planas, Costura).</li>
                <li><strong>Unidad Medida *:</strong> Un menú desplegable para seleccionar la unidad de medida correspondiente a este código/descripción (ej: ", Cm). Estas unidades se cargan desde el maestro de "Unidades de Medida". Es un campo obligatorio.</li>
            </ul>
            <h4>Guardar o Cancelar</h4>
            <p>Una vez completados los campos:</p>
            <ul>
                <li>Haga clic en <strong>"Guardar"</strong> para crear la nueva medida y añadirla al listado.</li>
                <li>Haga clic en <strong>"Cancelar"</strong> para descartar los cambios y cerrar el formulario.</li>
            </ul>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h3>4. Editar una Medida Existente</h3>
            <p>Para modificar la información de una medida ya creada:</p>
            <ol>
                <li>Localice la medida en la tabla y haga clic en el icono naranja de editar (✏️) correspondiente.</li>
                <li>Se abrirá un formulario similar al de creación, pre-cargado con el Código, Descripción y Unidad Medida actuales.</li>
            </ol>
        </div>
        <div class="col-sm-8 col-sm-offset-2">
            <img class="img-responsive" src="{{ asset('img/ayuda/medidas/Formulario_editar_medida.PNG') }}" alt="Formulario Editar Medida"/><br>
            <p class="text-center help-block"><em>Fig. 3: Ejemplo del formulario de edición de una medida. (Basado en image_8839f6.png)</em></p>
        </div>
        <div class="col-sm-12">
            <ol start="3">
                <li>Realice las modificaciones necesarias en los campos. Puede cambiar el código, la descripción o seleccionar una unidad de medida diferente del desplegable.</li>
                <li>Haga clic en <strong>"Guardar"</strong> para aplicar los cambios o <strong>"Cancelar"</strong> para descartarlos.</li>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h3>5. Eliminar una Medida</h3>
            <p>Para eliminar una medida del sistema:</p>
            <ol>
                <li>Localice la medida en la tabla y haga clic en el icono rojo de eliminar (🗑️) correspondiente.</li>
                <li>Se mostrará una ventana de advertencia solicitando confirmación, similar a la de otros módulos (ej: "Advertencia: Está seguro de eliminar el registro '[CÓDIGO DE LA MEDIDA]' ?").</li>
                <li>Para proceder con la eliminación, haga clic en el botón <strong>"Aceptar"</strong>.</li>
                <li>Si desea cancelar la operación, haga clic en <strong>"Cancelar"</strong>.</li>
            </ol>
            <p><strong>Importante:</strong> La eliminación de una medida podría estar restringida si esta se encuentra actualmente en uso en otras partes del sistema (ej: asociada a ítems de informe, servicios, etc.).</p>
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
