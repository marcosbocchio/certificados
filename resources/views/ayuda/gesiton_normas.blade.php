@extends('layouts.enod.master')

@section('contenido')

<div class="ayuda_enod">
    <div class="row">
        <div class="col-sm-12">
            <h2>Gestión de Normas</h2>
            <p>El sistema permite gestionar diferentes tipos de normas que son fundamentales para la correcta ejecución y documentación de los ensayos y trabajos. Estas normas se clasifican en Normas de Ensayo, Normas de Fabricación y Normas de Evaluaciones. Cada tipo de norma se administra desde su propia sección dentro del menú "Maestros".</p>
            <p>Las operaciones básicas como la creación, edición y eliminación son similares para todos los tipos de normas, variando principalmente el contexto y el uso específico de cada una.</p>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h3>1. Normas de Ensayo</h3>
            <p>Las Normas de Ensayo definen los estándares y procedimientos bajo los cuales se deben realizar los diferentes tipos de ensayos no destructivos (END) u otras pruebas.</p>
            <h4>Acceso a Normas de Ensayo</h4>
            <p>Para administrar las Normas de Ensayo, diríjase al menú principal y seleccione <strong>Maestros</strong> y luego <strong>Normas Ensayos</strong>.</p>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h4>Vista Principal de Normas de Ensayo</h4>
            <p>Se presentará una tabla con el listado de las Normas de Ensayo existentes, mostrando su <strong>código</strong> y <strong>Descripción</strong>.</p>
        </div>
        <div class="col-sm-10 col-sm-offset-1">
            <img class="img-responsive" src="{{ asset('img/ayuda/normas/Listado_normas_ensayo.PNG') }}" alt="Listado de Normas de Ensayo"/><br>
            <p class="text-center help-block"><em>Fig. 1: Vista principal del listado de Normas de Ensayo. (Basado en image_88c8db.png)</em></p>
        </div>
        <div class="col-sm-12">
            <p>Esta vista puede incluir controles de <strong>paginación</strong> en la parte inferior si el listado es extenso. No se observa una barra de búsqueda en la captura para esta sección específica.</p>
            <h5>Acciones Disponibles por Norma de Ensayo:</h5>
            <div class="detalle_iconos">
                <p><img class="img-responsive" src="{{ asset('img/ayuda/usuarios/Icono_editar_usuario.PNG') }}" alt="Editar Norma"/>&nbsp;&nbsp;<strong>Editar Norma:</strong> Icono naranja. Permite modificar el código o descripción de la norma seleccionada.</p>
                <p><img class="img-responsive" src="{{ asset('img/ayuda/usuarios/Icono_eliminar_usuario.PNG') }}" alt="Eliminar Norma"/>&nbsp;&nbsp;<strong>Eliminar Norma:</strong> Icono rojo. Permite eliminar la norma del sistema, previa confirmación.</p>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h4>Crear/Editar Norma de Ensayo</h4>
            <p>Al hacer clic en el botón <strong>"+ Nuevo"</strong> o en el icono de editar (✏️) de una norma existente, se abrirá un formulario.</p>
        </div>
        <div class="col-sm-8 col-sm-offset-2">
            <img class="img-responsive" src="{{ asset('img/ayuda/normas/Formulario_nueva_norma_ensayo.PNG') }}" alt="Formulario Nueva Norma de Ensayo"/><br>
            <p class="text-center help-block"><em>Fig. 2: Formulario para crear una Norma de Ensayo. (Basado en image_88c5d1.png)</em></p>
        </div>
        <div class="col-sm-8 col-sm-offset-2">
            <img class="img-responsive" src="{{ asset('img/ayuda/normas/Formulario_editar_norma_ensayo.PNG') }}" alt="Formulario Editar Norma de Ensayo"/><br>
            <p class="text-center help-block"><em>Fig. 3: Formulario para editar una Norma de Ensayo. (Basado en image_88be51.png)</em></p>
        </div>
        <div class="col-sm-12">
            <p>Los campos a completar son:</p>
            <ul>
                <li><strong>Código *:</strong> Identificador único o la nomenclatura oficial de la norma (ej: API1104 Ed 2021, ASME V Art 6). Es un campo obligatorio.</li>
                <li><strong>Descripción:</strong> Un texto descriptivo que aclare el alcance o el contenido de la norma (ej: Norma RI, Norma LP).</li>
            </ul>
            <p>Haga clic en <strong>"Guardar"</strong> para aplicar los cambios o <strong>"Cancelar"</strong> para cerrar el formulario sin guardar.</p>
            <h4>Eliminar Norma de Ensayo</h4>
            <p>Al hacer clic en el icono de eliminar (🗑️), el sistema solicitará confirmación antes de borrar el registro, de forma similar a otros módulos.</p>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <hr>
            <h3>2. Normas de Fabricación</h3>
            <p>Las Normas de Fabricación especifican los estándares y requisitos para la construcción o manufactura de componentes, equipos o estructuras.</p>
            <h4>Acceso a Normas de Fabricación</h4>
            <p>Para administrar las Normas de Fabricación, diríjase al menú principal y seleccione <strong>Maestros</strong> y luego <strong>Normas Fabricación</strong> (o el nombre exacto en su menú).</p>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h4>Vista Principal de Normas de Fabricación</h4>
            <p>Se presentará una tabla con el listado de las Normas de Fabricación, mostrando su <strong>código</strong> y <strong>Descripción</strong>.</p>
        </div>
        <div class="col-sm-10 col-sm-offset-1">
            <img class="img-responsive" src="{{ asset('img/ayuda/normas/Listado_normas_fabricacion.PNG') }}" alt="Listado de Normas de Fabricación"/><br>
            <p class="text-center help-block"><em>Fig. 4: Vista principal del listado de Normas de Fabricación. (Basado en image_88bdb6.png)</em></p>
        </div>
        <div class="col-sm-12">
            <p>Esta vista incluye una barra de <strong>búsqueda</strong> en la parte superior derecha para filtrar el listado. No se observan controles de paginación en la captura, lo que sugiere que el listado puede ser corto o la paginación se activa con más elementos.</p>
            <h5>Acciones Disponibles por Norma de Fabricación:</h5>
            <div class="detalle_iconos">
                 <p><img class="img-responsive" src="{{ asset('img/ayuda/usuarios/Icono_editar_usuario.PNG') }}" alt="Editar Norma"/>&nbsp;&nbsp;<strong>Editar Norma:</strong> Icono naranja. Permite modificar la norma.</p>
                <p><img class="img-responsive" src="{{ asset('img/ayuda/usuarios/Icono_eliminar_usuario.PNG') }}" alt="Eliminar Norma"/>&nbsp;&nbsp;<strong>Eliminar Norma:</strong> Icono rojo. Permite eliminar la norma, previa confirmación.</p>
            </div>
        </div>
    </div>
     <div class="row">
        <div class="col-sm-12">
            <h4>Crear/Editar Norma de Fabricación</h4>
            <p>El formulario para crear (botón <strong>"+ Nuevo"</strong>) o editar (icono ✏️) una Norma de Fabricación es idéntico en estructura al de Normas de Ensayo, solicitando los campos:</p>
            <ul>
                <li><strong>Código *:</strong> Identificador único de la norma de fabricación. Campo obligatorio.</li>
                <li><strong>Descripción:</strong> Texto descriptivo de la norma de fabricación.</li>
            </ul>
            <p>Los botones <strong>"Guardar"</strong> y <strong>"Cancelar"</strong> funcionan de la misma manera.</p>
            <p><em>(Para una referencia visual del formulario, ver Fig. 2 y Fig. 3 de la sección Normas de Ensayo, ya que la estructura es la misma).</em></p>
            <h4>Eliminar Norma de Fabricación</h4>
            <p>El proceso de eliminación es estándar: al hacer clic en el icono de eliminar (🗑️), se pedirá confirmación.</p>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <hr>
            <h3>3. Normas de Evaluaciones</h3>
            <p>Las Normas de Evaluaciones establecen los criterios y estándares para la aceptación o rechazo de resultados de inspecciones, soldaduras, u otros elementos evaluados.</p>
            <h4>Acceso a Normas de Evaluaciones</h4>
            <p>Para administrar las Normas de Evaluaciones, diríjase al menú principal y seleccione <strong>Maestros</strong> y luego <strong>Normas Evaluaciones</strong> (o el nombre exacto en su menú).</p>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <h4>Vista Principal de Normas de Evaluaciones</h4>
            <p>Se presentará una tabla con el listado de las Normas de Evaluaciones, mostrando su <strong>código</strong> y <strong>Descripción</strong>.</p>
        </div>
        <div class="col-sm-10 col-sm-offset-1">
            <img class="img-responsive" src="{{ asset('img/ayuda/normas/Listado_normas_evaluaciones.PNG') }}" alt="Listado de Normas de Evaluaciones"/><br>
            <p class="text-center help-block"><em>Fig. 5: Vista principal del listado de Normas de Evaluaciones. (Basado en image_88ba2f.png)</em></p>
        </div>
        <div class="col-sm-12">
            <p>Esta vista puede incluir controles de <strong>paginación</strong> en la parte inferior. No se observa una barra de búsqueda en la captura para esta sección específica.</p>
            <h5>Acciones Disponibles por Norma de Evaluación:</h5>
             <div class="detalle_iconos">
                <p><img class="img-responsive" src="{{ asset('img/ayuda/usuarios/Icono_editar_usuario.PNG') }}" alt="Editar Norma"/>&nbsp;&nbsp;<strong>Editar Norma:</strong> Icono naranja. Permite modificar la norma.</p>
                <p><img class="img-responsive" src="{{ asset('img/ayuda/usuarios/Icono_eliminar_usuario.PNG') }}" alt="Eliminar Norma"/>&nbsp;&nbsp;<strong>Eliminar Norma:</strong> Icono rojo. Permite eliminar la norma, previa confirmación.</p>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <h4>Crear/Editar Norma de Evaluación</h4>
            <p>El formulario para crear (botón <strong>"+ Nuevo"</strong>) o editar (icono ✏️) una Norma de Evaluación sigue la misma estructura que los otros tipos de normas, solicitando:</p>
            <ul>
                <li><strong>Código *:</strong> Identificador único de la norma de evaluación. Campo obligatorio.</li>
                <li><strong>Descripción:</strong> Texto descriptivo de la norma de evaluación.</li>
            </ul>
            <p>Use <strong>"Guardar"</strong> para aplicar cambios o <strong>"Cancelar"</strong> para salir.</p>
            <p><em>(Para una referencia visual del formulario, ver Fig. 2 y Fig. 3 de la sección Normas de Ensayo, ya que la estructura es la misma).</em></p>
            <h4>Eliminar Norma de Evaluación</h4>
            <p>La eliminación se realiza haciendo clic en el icono de eliminar (🗑️) y confirmando la acción en el diálogo que aparecerá.</p>
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
