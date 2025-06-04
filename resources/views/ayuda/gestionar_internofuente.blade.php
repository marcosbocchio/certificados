@extends('layouts.enod.master')

@section('contenido')

<div class="ayuda_enod">
    <div class="row">
        <div class="col-sm-12">
            <h2>Gestión de Interno Fuentes (Inventario de Fuentes Radiactivas)</h2>
            <p>El módulo de "Interno Fuentes" permite administrar el inventario individual y serializado de las fuentes radiactivas que utiliza la empresa. A diferencia del maestro de "Fuentes" (donde se definen los tipos de isótopos y su vida media T 1/2), aquí se registran las fuentes físicas, cada una con su número de serie, fecha de evaluación inicial, actividad inicial, foco y estado (activo/inactivo). El sistema también puede calcular y mostrar la actividad actual de la fuente.</p>

            <h3>1. Acceso a "Interno Fuentes"</h3>
            <p>Para acceder al módulo, diríjase al menú principal y seleccione la opción <strong>Maestros</strong> y luego, dentro del submenú desplegado, haga clic en <strong>Interno Fuentes</strong> (o el nombre exacto que corresponda en su sistema).</p>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h3>2. Vista Principal de Interno Fuentes</h3>
            <p>Al acceder, se presentará una tabla con el listado de todas las instancias de fuentes registradas. Las columnas principales son:</p>
            <ul>
                <li><strong>N° Serie:</strong> Número de serie único de la fuente física.</li>
                <li><strong>Fuente:</strong> Tipo de isótopo de la fuente (ej: SE 75 - POLYTEC, IR 192 - POLATOM), enlazado al maestro de Fuentes.</li>
                <li><strong>Actividad:</strong> Actividad actual de la fuente (ej: 38.8 Ci, 0.2 Ci).</li>
                <li><strong>Activo S/N:</strong> Indica si la fuente está actualmente activa ("SI") o inactiva ("NO").</li>
            </ul>
        </div>
        <div class="col-sm-12">
            <img class="img-responsive" src="{{ asset('img/ayuda/interno_fuentes/Listado_interno_fuentes.PNG') }}" alt="Listado de Interno Fuentes"/><br>
            <p class="text-center help-block"><em>Fig. 1: Vista principal del listado de interno fuentes. (Basado en image_7d6f78.png)</em></p>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <p>(No se observa una barra de búsqueda en la captura de pantalla para esta sección. Si su sistema la incluye, funcionaría de manera similar a otros módulos para filtrar por N° Serie, tipo de Fuente, etc.).</p>
            <h4>Paginación</h4>
            <p>Si el listado de fuentes es extenso, se activarán controles de paginación en la parte inferior para navegar entre las páginas.</p>

            <h4>Acciones Disponibles por Interno Fuente</h4>
            <p>A la derecha de cada fila en la tabla, encontrará los siguientes iconos de acción:</p>
        </div>
        <div class="col-sm-12 detalle_iconos">
            <p><img class="img-responsive" src="{{ asset('img/ayuda/usuarios/Icono_editar_usuario.PNG') }}" alt="Editar Interno Fuente"/>&nbsp;&nbsp;<strong>Editar Interno Fuente:</strong> Icono naranja con un lápiz. Permite modificar los datos de la fuente seleccionada.</p>
            <p><img class="img-responsive" src="{{ asset('img/ayuda/usuarios/Icono_eliminar_usuario.PNG') }}" alt="Dar de Baja/Eliminar Interno Fuente"/>&nbsp;&nbsp;<strong>Dar de Baja/Eliminar Interno Fuente:</strong> Icono rojo. Permite dar de baja la fuente (marcarla como inactiva) o eliminarla, previa confirmación.</p>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h3>3. Crear una Nueva "Interno Fuente"</h3>
            <p>Para registrar una nueva instancia de fuente radiactiva, haga clic en el botón amarillo <strong>"+ Nuevo"</strong>.</p>
        </div>
         <div class="col-sm-8 col-sm-offset-2">
            <img class="img-responsive" src="{{ asset('img/ayuda/interno_fuentes/Formulario_nueva_interno_fuente.PNG') }}" alt="Formulario Nueva Interno Fuente"/><br>
            <p class="text-center help-block"><em>Fig. 2: Formulario para registrar una nueva interno fuente. (Basado en image_7d6f57.png)</em></p>
        </div>
        <div class="col-sm-12">
            <p>Se abrirá un formulario con los siguientes campos a completar:</p>
            <ul>
                <li><strong>N° Serie *:</strong> Número de serie del fabricante de la fuente. Campo obligatorio.</li>
                <li><strong>ACTIVO:</strong> Casilla de verificación (marcada por defecto) para indicar si la fuente está activa.</li>
                <li><strong>Fecha Evaluación *:</strong> Fecha en la que se evaluó o midió la actividad inicial de la fuente (formato DD-MM-YYYY). Campo obligatorio.</li>
                <li><strong>Actividad:</strong> Valor numérico de la actividad inicial de la fuente en la "Fecha Evaluación" (ej: 100, usualmente en Curies - Ci).</li>
                <li><strong>Foco *:</strong> Dimensiones o características del foco de la fuente. Campo obligatorio.</li>
                <li><strong>Fuente *:</strong> Menú desplegable para seleccionar el tipo de isótopo (definido en el maestro de "Fuentes", ej: "SE 75 - POLYTEC"). Esta selección es crucial ya que el sistema utilizará la vida media (T 1/2) de este tipo de fuente para calcular la actividad actual. Campo obligatorio.</li>
            </ul>
            <h4>Guardar o Cancelar</h4>
            <p>Completados todos los campos necesarios, haga clic en <strong>"Guardar"</strong> o <strong>"Cancelar"</strong>.</p>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h3>4. Editar una "Interno Fuente" Existente</h3>
            <p>Para modificar los datos de una fuente existente en el inventario:</p>
            <ol>
                <li>Localice la fuente en la tabla y haga clic en el icono naranja de editar (✏️).</li>
                <li>Se abrirá un formulario pre-cargado con los datos de la fuente.</li>
            </ol>
        </div>
        <div class="col-sm-8 col-sm-offset-2">
            <img class="img-responsive" src="{{ asset('img/ayuda/interno_fuentes/Formulario_editar_interno_fuente.PNG') }}" alt="Formulario Editar Interno Fuente"/><br>
            <p class="text-center help-block"><em>Fig. 3: Formulario de edición de una interno fuente, mostrando campos calculados/deshabilitados. (Basado en image_7d6f37.png)</em></p>
        </div>
        <div class="col-sm-12">
            <p>En el modo de edición, algunos campos pueden tener un comportamiento particular:</p>
            <ul>
                <li><strong>N° Serie *:</strong> Generalmente editable.</li>
                <li><strong>ACTIVO:</strong> Casilla de verificación para cambiar el estado activo/inactivo.</li>
                <li><strong>Fecha Evaluación *:</strong> Fecha de la evaluación inicial. Podría ser editable o fija una vez creada.</li>
                <li><strong>Act. inicial:</strong> Muestra la actividad que se ingresó al crear la fuente en la "Fecha Evaluación". Este campo suele ser <strong>no editable (deshabilitado)</strong>.</li>
                <li><strong>Act. Actual:</strong> Muestra la actividad actual calculada por el sistema, basada en la "Act. inicial", "Fecha Evaluación" y la vida media (T 1/2) del tipo de "Fuente" seleccionada. Este campo es <strong>no editable (deshabilitado)</strong> y se actualiza automáticamente.</li>
                <li><strong>Foco *:</strong> Generalmente editable.</li>
                <li><strong>Fuente *:</strong> Tipo de isótopo. Puede ser editable, pero cambiarlo afectaría el cálculo de la "Act. Actual".</li>
            </ul>
            <p>Realice las modificaciones en los campos editables y haga clic en <strong>"Guardar"</strong> para aplicar los cambios, o <strong>"Cancelar"</strong> para descartarlos.</p>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h3>5. Dar de Baja una "Interno Fuente"</h3>
            <p>Dar de baja una fuente usualmente implica cambiar su estado a "Inactivo" en lugar de eliminarla permanentemente del registro, para mantener la trazabilidad.</p>
            <ol>
                <li>Localice la fuente en la tabla y haga clic en el icono rojo de eliminar/dar de baja (🗑️).</li>
                <li>El sistema solicitará confirmación.</li>
                <li>Al confirmar, el estado de la fuente cambiará (la casilla "ACTIVO" se desmarcará si se edita, o la columna "Activo S/N" en el listado mostrará "NO").</li>
            </ol>
            <p><strong>Importante:</strong> Una fuente dada de baja ya no debería estar disponible para ser asignada a equipos o utilizada en servicios. El sistema podría impedir la eliminación completa de fuentes que tengan un historial de uso.</p>
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
