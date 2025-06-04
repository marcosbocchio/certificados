@extends('layouts.enod.master')

@section('contenido')

<div class="ayuda_enod">
    <div class="row">
        <div class="col-sm-12">
            <h2>Gestión de Materiales</h2>
            <p>El maestro de materiales permite definir y catalogar los diferentes tipos de materiales con los que se trabaja o que componen los elementos a inspeccionar. Esta información es utilizada en diversas partes del sistema, como en la definición de procedimientos o la carga de detalles en informes.</p>

            <h3>1. Acceso a la Gestión de Materiales</h3>
            <p>Para acceder al módulo de gestión de materiales, diríjase al menú principal y seleccione la opción <strong>Maestros</strong> y luego, dentro del submenú desplegado, haga clic en <strong>Materiales</strong>.</p>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h3>2. Vista Principal de Materiales</h3>
            <p>Al acceder a la sección de Materiales, se presentará una tabla con el listado de todos los materiales registrados. Por cada material, se mostrará su <strong>CÓDIGO</strong> y <strong>Descripción</strong>.</p>
        </div>
        <div class="col-sm-10 col-sm-offset-1">
            <img class="img-responsive" src="{{ asset('img/ayuda/materiales/Listado_materiales.PNG') }}" alt="Listado de Materiales"/><br>
            <p class="text-center help-block"><em>Fig. 1: Vista principal del listado de materiales. (Basado en image_892675.png)</em></p>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h4>Buscar Materiales</h4>
            <p>En la parte superior derecha de la tabla, encontrará un campo de <strong>Buscar...</strong>. Ingrese el código o parte de la descripción del material que desea localizar y presione Enter o haga clic en el icono de la lupa (🔍) para filtrar la lista.</p>

            <h4>Paginación</h4>
            <p>Si el listado de materiales es extenso y supera la cantidad de registros visibles por página, se activarán los controles de paginación en la parte inferior izquierda de la tabla. Puede utilizar los números de página o los botones "Next >" (Siguiente) y "< Previous" (Anterior, si no está en la primera página) para navegar entre las diferentes páginas del listado.</p>

            <h4>Acciones Disponibles por Material</h4>
            <p>A la derecha de cada fila de material en la tabla, encontrará los siguientes iconos de acción:</p>
        </div>
        <div class="col-sm-12 detalle_iconos">
            <p><img class="img-responsive" src="{{ asset('img/ayuda/usuarios/Icono_editar_usuario.PNG') }}" alt="Editar Material"/>&nbsp;&nbsp;<strong>Editar Material:</strong> Icono naranja con un lápiz. Permite modificar los datos del material seleccionado.</p>
            <p><img class="img-responsive" src="{{ asset('img/ayuda/usuarios/Icono_eliminar_usuario.PNG') }}" alt="Eliminar Material"/>&nbsp;&nbsp;<strong>Eliminar Material:</strong> Icono rojo con un cesto de basura. Permite eliminar el material del sistema, previa confirmación.</p>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h3>3. Crear un Nuevo Material</h3>
            <p>Para agregar un nuevo material al sistema, haga clic en el botón amarillo <strong>"+ Nuevo"</strong> ubicado en la esquina superior izquierda de la pantalla de listado de materiales.</p>
        </div>
         <div class="col-sm-8 col-sm-offset-2">
            <img class="img-responsive" src="{{ asset('img/ayuda/materiales/Formulario_nuevo_material.PNG') }}" alt="Formulario Nuevo Material"/><br>
            <p class="text-center help-block"><em>Fig. 2: Formulario para la creación de un nuevo material. (Basado en image_8923ad.png)</em></p>
        </div>
        <div class="col-sm-12">
            <p>Esto abrirá el formulario de creación de materiales con los siguientes campos (los campos con * son obligatorios):</p>
            <ul>
                <li><strong>Código *:</strong> Un código único o normalizado para identificar el material (ej: W-420, UPN 200, SAE 1010).</li>
                <li><strong>Descripción *:</strong> Una descripción clara y concisa del material (ej: ACERO CARBONO, AC. INOX, T316L).</li>
            </ul>
            <h4>Guardar o Cancelar</h4>
            <p>Una vez completados todos los campos necesarios:</p>
            <ul>
                <li>Haga clic en <strong>"Guardar"</strong> para crear el nuevo material y añadirlo al listado.</li>
                <li>Haga clic en <strong>"Cancelar"</strong> para descartar los cambios y cerrar el formulario.</li>
            </ul>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h3>4. Editar un Material Existente</h3>
            <p>Para modificar la información de un material ya creado:</p>
            <ol>
                <li>Localice el material en la tabla y haga clic en el icono naranja de editar (✏️) correspondiente.</li>
                <li>Se abrirá un formulario similar al de creación, pero pre-cargado con el Código y Descripción actuales del material.</li>
            </ol>
        </div>
        <div class="col-sm-8 col-sm-offset-2">
            <img class="img-responsive" src="{{ asset('img/ayuda/materiales/Formulario_editar_material.PNG') }}" alt="Formulario Editar Material"/><br>
            <p class="text-center help-block"><em>Fig. 3: Ejemplo del formulario de edición de un material. (Basado en image_891feb.png)</em></p>
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
            <h3>5. Eliminar un Material</h3>
            <p>Para eliminar un material del sistema:</p>
            <ol>
                <li>Localice el material en la tabla y haga clic en el icono rojo de eliminar (🗑️) correspondiente.</li>
                <li>Se mostrará una ventana de advertencia solicitando confirmación, similar a la de otros módulos (ej: "Advertencia: Está seguro de eliminar el registro '[CÓDIGO DEL MATERIAL]' ?").</li>
                <li>Para proceder con la eliminación, haga clic en el botón <strong>"Aceptar"</strong>.</li>
                <li>Si desea cancelar la operación, haga clic en <strong>"Cancelar"</strong>.</li>
            </ol>
            <p><strong>Importante:</strong> La eliminación de un material podría estar restringida si este se encuentra referenciado en otras partes del sistema (ej: asociado a procedimientos, OTs, o informes).</p>
        </div>
        </div>

    <div class="row">
        <div class="col-sm-12">
            <h3>Artículos relacionados&nbsp;</h3>
            </div>
    </div>
</div>

@endsection
