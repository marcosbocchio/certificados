@extends('layouts.enod.master')

@section('contenido')

<div id="app">
<div class="ayuda_enod">
    <div class="row">
        <div class="col-sm-12">
            <h2>Gestión de Roles y Permisos</h2>
            <p>El módulo de "Gestión de Roles" es una parte crucial de la seguridad del sistema. Permite definir roles específicos (como "Administrador", "Operador", "Cliente", "Supervisor de Reportes", etc.) y asignar un conjunto detallado de permisos a cada rol. Los usuarios del sistema luego son asignados a uno o más de estos roles, lo que determina a qué funcionalidades y datos pueden acceder y qué acciones pueden realizar.</p>
            <p>Este enfoque (Control de Acceso Basado en Roles - RBAC) simplifica la administración de permisos, ya que en lugar de asignar permisos individualmente a cada usuario, se asignan a roles, y los roles a los usuarios.</p>

            <h3>1. Acceso a la Gestión de Roles</h3>
            <p>Para acceder al módulo de gestión de roles, normalmente se encuentra en una sección de <strong>Administración del Sistema</strong>, <strong>Configuración de Seguridad</strong>, o similar. Dado que es una función administrativa avanzada, podría ser <strong>Maestros</strong> -> <strong>Roles</strong> o una ruta específica para administradores.</p>
        </div>
</div>

</div>

    <div class="row">
        <div class="col-sm-12">
            <h3>2. Vista Principal de Roles</h3>
            <p>Al acceder a la sección, se presentará una tabla con el listado de todos los roles definidos en el sistema. Las columnas principales son:</p>
            <ul>
                <li><strong>Nombre:</strong> El nombre descriptivo del rol (ej: REPORTES, Edita_informes, OPERADOR).</li>
                <li><strong>Guard:</strong> Indica el "guardia" de autenticación al que se aplica el rol. Comúnmente será "web" para roles que acceden a través de la interfaz web del sistema, o "api" para roles que interactúan con servicios API.</li>
            </ul>
        </div>
        <div class="col-sm-10 col-sm-offset-1">
            
            <p class="text-center help-block"><em>Fig. 1: Vista principal del listado de roles. (Basado en image_7d6c2f.png)</em></p>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <p>(No se observa una barra de búsqueda en la captura de pantalla para esta sección. Si existe, permitiría buscar roles por nombre o guard).</p>
            <h4>Paginación</h4>
            <p>Si el listado de roles es extenso, se activarán los controles de paginación en la parte inferior izquierda de la tabla para navegar entre las diferentes páginas.</p>

            <h4>Acciones Disponibles por Rol</h4>
            <p>A la derecha de cada fila en la tabla, encontrará los siguientes iconos de acción:</p>
        </div>
        <div class="col-sm-12 detalle_iconos">
            <p><strong>Editar Rol:</strong> Icono naranja con un lápiz. Permite modificar el nombre, el guard y los permisos asignados al rol seleccionado.</p>
            <p><strong>Eliminar Rol:</strong> Icono rojo con un cesto de basura. Permite eliminar el rol del sistema, previa confirmación.</p>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h3>3. Crear un Nuevo Rol</h3>
            <p>Para definir un nuevo rol, haga clic en el botón amarillo <strong>"+ Nuevo"</strong> ubicado en la esquina superior izquierda de la pantalla de listado.</p>
        </div>
         <div class="col-sm-10 col-sm-offset-1"> 
            <p class="text-center help-block"><em>Fig. 2: Formulario para la creación de un nuevo rol, mostrando la asignación de permisos. (Basado en image_7d6bb7.png)</em></p>
        </div>
        <div class="col-sm-12">
            <p>Esto abrirá el formulario de creación con los siguientes campos y secciones:</p>
            <ul>
                <li><strong>Nombre *:</strong> Nombre descriptivo y único para el rol. Es un campo obligatorio.</li>
                <li><strong>Guard *:</strong> Menú desplegable para seleccionar el guardia de autenticación (ej: "web", "api"). Indica a qué parte del sistema aplicarán los permisos de este rol. Es un campo obligatorio.</li>
            </ul>
            <h4>Sección "Permisos"</h4>
            <p>Debajo de los campos Nombre y Guard, encontrará una lista extensa de casillas de verificación (checkboxes). Cada casilla representa un permiso específico dentro del sistema. Estos permisos suelen tener nombres codificados que indican el módulo o la acción a la que se refieren (ej: <code>A_asistencia_acceder</code>, <code>C_edita</code>, <code>M_clientes_edita</code>, <code>D_resumen_Admin</code>, <code>ASISTENCIA</code>, <code>CURSOS</code>).</p>
            <p>Marque todas las casillas correspondientes a los permisos que desea incluir en este nuevo rol. Un rol puede agrupar múltiples permisos de diferentes áreas del sistema.</p>

            <h4>Guardar o Cancelar</h4>
            <p>Una vez asignado el nombre, el guard y seleccionados todos los permisos deseados:</p>
            <ul>
                <li>Haga clic en <strong>"Guardar"</strong> (ubicado debajo de la lista de permisos, no visible en la captura de pantalla) para crear el nuevo rol.</li>
                <li>Haga clic en <strong>"Cancelar"</strong> para descartar los cambios y cerrar el formulario.</li>
            </ul>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h3>4. Editar un Rol Existente</h3>
            <p>Para modificar un rol ya existente (cambiar su nombre, guard, o los permisos asignados):</p>
            <ol>
                <li>Localice el rol en la tabla y haga clic en el icono naranja de editar (✏️) correspondiente.</li>
                <li>Se abrirá un formulario similar al de creación, pre-cargado con el Nombre, Guard y los permisos actualmente seleccionados para ese rol.</li>
            </ol>
        </div>
        <div class="col-sm-10 col-sm-offset-1"> 
            <p class="text-center help-block"><em>Fig. 3: Ejemplo del formulario de edición de un rol, con permisos preseleccionados. (Basado en image_7d6853.png)</em></p>
        </div>
        <div class="col-sm-12">
            <ol start="3">
                <li>Modifique el Nombre o el Guard si es necesario.</li>
                <li>En la sección "Permisos", marque o desmarque las casillas para ajustar el conjunto de permisos para el rol.</li>
                <li>Haga clic en <strong>"Guardar"</strong> para aplicar los cambios o <strong>"Cancelar"</strong> para descartarlos.</li>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h3>5. Eliminar un Rol</h3>
            <p>Para eliminar un rol del sistema:</p>
            <ol>
                <li>Localice el rol en la tabla y haga clic en el icono rojo de eliminar (🗑️) correspondiente.</li>
                <li>Se mostrará una ventana de advertencia solicitando confirmación.</li>
                <li>Para proceder con la eliminación, haga clic en el botón <strong>"Aceptar"</strong>.</li>
                <li>Si desea cancelar la operación, haga clic en <strong>"Cancelar"</strong>.</li>
            </ol>
            <p><strong>Importante:</strong> Antes de eliminar un rol, asegúrese de que ningún usuario esté actualmente asignado a dicho rol. Eliminar un rol que está en uso podría dejar a los usuarios sin los permisos necesarios para operar el sistema o causar errores. Es recomendable reasignar los usuarios a otros roles antes de eliminar uno existente.</p>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <hr>
            <h3>Artículos relacionados&nbsp;</h3>
            </div>
    </div>
    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Ejemplo en pantalla</h2>
            <p>Asi se ve este maestro en el sistema. Probá el buscador y mirá los iconos de accion en cada fila.</p>
            <ayuda-demo-abm-tabla entidad="rol"></ayuda-demo-abm-tabla>
            <ayuda-demo-abm-form entidad="rol"></ayuda-demo-abm-form>
        </div>
    </section>
</div>
</div>

@endsection
