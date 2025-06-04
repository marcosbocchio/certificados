@extends('layouts.enod.master')

@section('contenido')

<div class="ayuda_enod">
    <div class="row">
        <div class="col-sm-12">
            <h2>Gestión de Interno Equipos (Inventario de Equipos)</h2>
            <p>El módulo de "Interno Equipos" permite administrar el inventario individual y serializado de los equipos de la empresa. A diferencia del maestro de "Equipos" (donde se definen los tipos de equipo), aquí se registran las unidades físicas, cada una con su número de serie, número interno, estado (activo/baja), y se pueden gestionar características específicas como las fuentes asignadas (para equipos que las utilicen, como los de radiografía industrial).</p>

            <h3>1. Acceso a "Interno Equipos"</h3>
            <p>Para acceder al módulo, diríjase al menú principal y seleccione la opción <strong>Maestros</strong> y luego, dentro del submenú desplegado, haga clic en <strong>Interno Equipos</strong> (o el nombre exacto que corresponda en su sistema).</p>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h3>2. Vista Principal de Interno Equipos</h3>
            <p>Al acceder, se presentará una tabla con el listado de todas las instancias de equipos registradas. Las columnas principales son:</p>
            <ul>
                <li><strong>N° INT.:</strong> Número interno asignado al equipo.</li>
                <li><strong>Tipo equipamiento:</strong> Clasificación del tipo de equipo.</li>
                <li><strong>Equipo:</strong> Nombre o modelo del equipo (definido en el maestro de Equipos).</li>
                <li><strong>Método:</strong> Método de ensayo principal asociado.</li>
                <li><strong>Fuente:</strong> Fuente actualmente asignada al equipo (si aplica).</li>
                <li><strong>Actividad:</strong> Actividad de la fuente (si aplica).</li>
                <li><strong>Ubicación:</strong> Ubicación actual del equipo.</li>
                <li><strong>Baja:</strong> Fecha en que el equipo fue dado de baja (si aplica).</li>
            </ul>
            <p>Los equipos que han sido dados de baja o están inactivos se resaltan en color rojo.</p>
        </div>
        <div class="col-sm-12">
            <img class="img-responsive" src="{{ asset('img/ayuda/interno_equipos/Listado_interno_equipos.PNG') }}" alt="Listado de Interno Equipos"/><br>
            <p class="text-center help-block"><em>Fig. 1: Vista principal del listado de interno equipos. (Basado en image_87681c.png)</em></p>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h4>Filtros y Búsqueda</h4>
            <ul>
                <li><strong>Mostrar activos:</strong> Una casilla de verificación en la parte superior derecha. Cuando está marcada (por defecto), solo muestra los equipos activos. Desmárquela para ver todos los equipos, incluyendo los dados de baja.</li>
                <li><strong>Buscar:</strong> Un campo de texto "Buscar..." permite ingresar términos para localizar equipos. Presione Enter o haga clic en la lupa (🔍) para aplicar la búsqueda.</li>
            </ul>

            <h4>Paginación</h4>
            <p>Si el listado es extenso, se activarán controles de paginación en la parte inferior.</p>

            <h4>Acciones Disponibles por Interno Equipo</h4>
            <p>A la derecha de cada fila en la tabla, encontrará los siguientes iconos de acción:</p>
        </div>
        <div class="col-sm-12 detalle_iconos">
            <p><img class="img-responsive" src="{{ asset('img/ayuda/interno_equipos/Icono_historial_fuentes.PNG') }}" alt="Historial de Fuentes" style="width:20px; height:20px; display:inline-block;"/>&nbsp;&nbsp;<strong>Historial de Fuentes:</strong> Icono de una tabla con cuadraditos. Abre una ventana para ver y gestionar las fuentes asignadas a ese equipo específico (ver detalle en punto 5).</p>
            <p><img class="img-responsive" src="{{ asset('img/ayuda/usuarios/Icono_editar_usuario.PNG') }}" alt="Editar Interno Equipo"/>&nbsp;&nbsp;<strong>Editar Interno Equipo:</strong> Icono naranja con un lápiz. Permite modificar los datos del equipo seleccionado.</p>
            <p><img class="img-responsive" src="{{ asset('img/ayuda/usuarios/Icono_eliminar_usuario.PNG') }}" alt="Dar de Baja/Eliminar Interno Equipo"/>&nbsp;&nbsp;<strong>Dar de Baja/Eliminar Interno Equipo:</strong> Icono rojo. Permite dar de baja el equipo (marcarlo como inactivo) o eliminarlo, previa confirmación.</p>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h3>3. Crear un Nuevo "Interno Equipo"</h3>
            <p>Para registrar una nueva instancia de equipo, haga clic en el botón amarillo <strong>"+ Nuevo"</strong>.</p>
        </div>
         <div class="col-sm-8 col-sm-offset-2">
            <img class="img-responsive" src="{{ asset('img/ayuda/interno_equipos/Formulario_nuevo_interno_equipo_1.PNG') }}" alt="Formulario Nuevo Interno Equipo - Parte 1"/><br>
            <p class="text-center help-block"><em>Fig. 2: Formulario inicial para crear un nuevo interno equipo. (Basado en image_8767ba.png)</em></p>
        </div>
        <div class="col-sm-12">
            <p>Se abrirá un formulario con campos iniciales:</p>
            <ul>
                <li><strong>N° Serie *:</strong> Número de serie del fabricante del equipo. Campo obligatorio.</li>
                <li><strong>ACTIVO:</strong> Casilla de verificación (marcada por defecto) para indicar si el equipo está activo.</li>
                <li><strong>N° Interno *:</strong> Número de identificación interno asignado por la empresa. Campo obligatorio.</li>
                <li><strong>Equipo *:</strong> Menú desplegable para seleccionar el tipo de equipo (definido en el maestro de "Equipos", ej: "Sentinel 880 Delta"). Es un campo obligatorio.</li>
                <li><strong>Tipo Equipamiento:</strong> Campo no editable que se completará automáticamente con el tipo de equipamiento asociado al "Equipo" seleccionado (ej: EQUIPO - PROYECTOR).</li>
            </ul>
            <p><strong>Campos Condicionales:</strong> Una vez que seleccione un "Equipo" del desplegable, pueden aparecer campos adicionales si el tipo de equipo lo requiere (por ejemplo, equipos que utilizan fuentes).</p>
        </div>
        <div class="col-sm-8 col-sm-offset-2">
            <img class="img-responsive" src="{{ asset('img/ayuda/interno_equipos/Formulario_nuevo_interno_equipo_2.PNG') }}" alt="Formulario Nuevo Interno Equipo - Parte 2 (Condicional)"/><br>
            <p class="text-center help-block"><em>Fig. 3: Campos adicionales que pueden aparecer al seleccionar un equipo que utiliza fuentes. (Basado en image_8764f1.png)</em></p>
        </div>
         <div class="col-sm-12">
            <p>Estos campos adicionales pueden incluir:</p>
            <ul>
                <li><strong>Fuente:</strong> Menú desplegable para asignar una fuente específica a esta instancia del equipo.</li>
                <li><strong>Foco:</strong> Dimensiones o características del foco (si aplica).</li>
                <li><strong>Voltaje:</strong> Voltaje de operación (si aplica).</li>
                <li><strong>Amperaje:</strong> Amperaje de operación (si aplica).</li>
            </ul>
            <h4>Guardar o Cancelar</h4>
            <p>Completados todos los campos necesarios, haga clic en <strong>"Guardar"</strong> o <strong>"Cancelar"</strong>.</p>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h3>4. Editar un "Interno Equipo" Existente</h3>
            <p>Para modificar un equipo del inventario:</p>
            <ol>
                <li>Localice el equipo en la tabla y haga clic en el icono naranja de editar (✏️).</li>
                <li>Se abrirá un formulario similar al de creación, pre-cargado con los datos actuales, incluyendo los campos condicionales si aplican al tipo de equipo.</li>
                <li>Realice las modificaciones y haga clic en <strong>"Guardar"</strong>.</li>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h3>5. Historial de Fuentes</h3>
            <p>Para los equipos que utilizan fuentes (ej. equipos de gammagrafía), el icono de "tabla" ( <img src="{{ asset('img/ayuda/interno_equipos/Icono_historial_fuentes.PNG') }}" alt="Icono Historial Fuentes" style="width:16px; height:16px; display:inline-block;"/> ) en la lista principal permite acceder al historial de fuentes asignadas a esa instancia específica del equipo.</p>
        </div>
         <div class="col-sm-8 col-sm-offset-2">
            <img class="img-responsive" src="{{ asset('img/ayuda/interno_equipos/Modal_historial_fuentes.PNG') }}" alt="Modal Historial de Fuentes"/><br>
            <p class="text-center help-block"><em>Fig. 4: Ventana de Historial de Fuentes asignadas al equipo. (Basado en image_876114.png)</em></p>
        </div>
        <div class="col-sm-12">
            <p>Esta ventana muestra:</p>
            <ul>
                <li><strong>Equipo:</strong> Identificación del equipo al que pertenece el historial.</li>
                <li><strong>Fuentes asignadas al equipo:</strong> Una tabla con las fuentes que han sido asignadas a este equipo, mostrando:
                    <ul>
                        <li><strong>Fuente:</strong> Identificador de la fuente.</li>
                        <li><strong>Alta:</strong> Fecha en que la fuente fue asignada o activada en este equipo.</li>
                        <li><strong>Baja:</strong> Fecha en que la fuente fue desasignada o dada de baja de este equipo.</li>
                    </ul>
                </li>
            </ul>
            <p>Los botones <strong>"Guardar"</strong> y <strong>"Cancelar"</strong> en esta ventana sugieren que se podrían modificar las fechas de alta/baja de las fuentes o gestionar su asignación. Consulte la funcionalidad específica de estos botones en su sistema.</p>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h3>6. Dar de Baja un "Interno Equipo"</h3>
            <p>Para marcar un equipo como inactivo (dar de baja):</p>
            <ol>
                <li>Localice el equipo en la tabla y haga clic en el icono rojo de eliminar/dar de baja (🗑️).</li>
                <li>El sistema probablemente solicitará confirmación.</li>
                <li>Al confirmar, el equipo cambiará su estado a inactivo (se mostrará resaltado en rojo en la lista si el filtro "Mostrar activos" está desactivado) y se registrará la fecha de baja.</li>
            </ol>
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
