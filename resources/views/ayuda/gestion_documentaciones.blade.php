@extends('layouts.enod.master')

@section('contenido')

<div class="ayuda_enod">
    <div class="row">
        <div class="col-sm-12">
            <h2>Gestión de Documentaciones</h2>
            <p>Este módulo centraliza la administración de toda la documentación relevante para la operatoria de la empresa, los usuarios, equipos, y proyectos. Permite cargar, clasificar, buscar y gestionar el ciclo de vida de los documentos, incluyendo sus fechas de caducidad y la posibilidad de descargarlos.</p>

            <h3>1. Acceso a la Gestión de Documentaciones</h3>
            <p>Para acceder al módulo, diríjase al menú principal y seleccione <strong>Documentaciones</strong> (o el nombre exacto que tenga en su sistema, ej: "Gestor Documental", "Documentos").</p>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h3>2. Vista Principal de Documentaciones</h3>
            <p>Al ingresar, se muestra una tabla con todos los documentos cargados en el sistema. Las columnas visibles son:</p>
            <ul>
                <li><strong>Checkbox de Selección:</strong> Para seleccionar uno o varios documentos para la descarga masiva.</li>
                <li><strong>Tipo:</strong> Categoría del documento (Institucional, OT, Usuario, etc.).</li>
                <li><strong>Título:</strong> Nombre o título asignado al documento.</li>
                <li><strong>Descripción:</strong> Breve descripción del contenido o propósito del documento.</li>
                <li><strong>Método:</strong> Método de ensayo asociado (si aplica, ej: para Procedimientos Generales).</li>
                <li><strong>Usuario:</strong> Usuario asociado al documento (ej: propietario del documento de usuario, o quien cargó un procedimiento).</li>
                <li><strong>INT. N°:</strong> Número de interno o identificador relacionado (si aplica).</li>
                <li><strong>Caducidad:</strong> Fecha de vencimiento del documento.</li>
                <li><strong>Baja Equipo:</strong> Indicador si el equipo asociado al documento está dado de baja (si aplica).</li>
                <li><strong>Acciones:</strong> Iconos para Editar (✏️) y Eliminar (🗑️) el documento.</li>
            </ul>
        </div>
        <div class="col-sm-12">
            <img class="img-responsive" src="{{ asset('img/ayuda/documentaciones/Listado_documentaciones.PNG') }}" alt="Listado de Documentaciones"/><br>
            <p class="text-center help-block"><em>Fig. 1: Vista principal del gestor de documentaciones. (Basado en image_88af52.png)</em></p>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h4>Filtros y Búsqueda</h4>
            <p>La vista principal ofrece varias herramientas para localizar documentos:</p>
            <ul>
                <li><strong>Filtrar por Tipo:</strong> Un menú desplegable (inicialmente en "TODOS") permite filtrar los documentos por su categoría. Las opciones son: INSTITUCIONAL, OT, PROCEDIMIENTO GENERAL, USUARIO, EQUIPO, FUENTE, VEHICULO.</li>
                    <div class="col-sm-6 col-sm-offset-3">
                        <img class="img-responsive" src="{{ asset('img/ayuda/documentaciones/Filtro_tipo_documento.PNG') }}" alt="Filtro Tipo de Documento"/><br>
                        <p class="text-center help-block"><em>Fig. 2: Opciones del filtro por tipo de documento. (Basado en image_88ab32.png)</em></p>
                    </div>
                <li><strong>Documentación Vencida:</strong> Una casilla de verificación "Documentación vencida" permite mostrar únicamente los documentos cuya fecha de caducidad ya ha pasado.</li>
                <li><strong>Buscar:</strong> Un campo de texto "Buscar..." permite ingresar términos para localizar documentos por título, descripción, etc. Presione Enter o haga clic en la lupa (🔍) para aplicar la búsqueda.</li>
            </ul>

            <h4>Descargar Documentos</h4>
            <p>Para descargar uno o varios documentos en un archivo ZIP:</p>
            <ol>
                <li>Marque la casilla de selección a la izquierda de cada documento que desee incluir en la descarga.</li>
                <li>Una vez seleccionados, haga clic en el botón amarillo <strong>"Descargar"</strong> ubicado en la parte superior izquierda.</li>
                <li>El sistema generará un archivo ZIP con los documentos seleccionados.</li>
            </ol>

            <h4>Paginación</h4>
            <p>Si el listado es extenso, se activarán controles de paginación en la parte inferior para navegar entre las páginas.</p>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h3>3. Crear o Editar Documentación</h3>
            <p>Para agregar un nuevo documento, haga clic en el botón <strong>"+ Nuevo"</strong>. Para modificar uno existente, haga clic en su respectivo icono de editar (✏️).</p>
            <p>El formulario de carga/edición de documentos es dinámico y sus campos varían según el <strong>"Tipo Documento"</strong> seleccionado. Sin embargo, algunos elementos son comunes:</p>
            <ul>
                <li><strong>Visible:</strong> Una casilla en la esquina superior derecha para marcar si el documento es visible o no (puede usarse para ocultar documentos obsoletos sin eliminarlos).</li>
                <li><strong>Seleccionar archivo:</strong> Botón para adjuntar el archivo digital del documento (Formatos soportados: .jpg, .bmp, .pdf). Una barra de progreso mostrará el estado de la carga.</li>
                <li>Botones <strong>"Guardar"</strong> y <strong>"Cancelar"</strong>.</li>
            </ul>
            <p>A continuación, se detallan los campos específicos para cada tipo de documento:</p>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h4>3.1 Tipo Documento: INSTITUCIONAL</h4>
             <div class="col-sm-8 col-sm-offset-2">
                <img class="img-responsive" src="{{ asset('img/ayuda/documentaciones/Form_doc_institucional.PNG') }}" alt="Formulario Documento Institucional"/><br>
                <p class="text-center help-block"><em>Fig. 3: Formulario para documento tipo Institucional. (Basado en image_88aa99.png)</em></p>
            </div>
            <p>Documentos generales de la empresa.</p>
            <ul>
                <li><strong>Tipo Documento *:</strong> Se selecciona "INSTITUCIONAL".</li>
                <li><strong>Título *:</strong> Título del documento.</li>
                <li><strong>Descripción:</strong> Descripción adicional.</li>
                <li><strong>Fecha caducidad *:</strong> Fecha de vencimiento del documento (formato DD-MM-YYYY).</li>
            </ul>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h4>3.2 Tipo Documento: OT</h4>
             <div class="col-sm-8 col-sm-offset-2">
                <img class="img-responsive" src="{{ asset('img/ayuda/documentaciones/Form_doc_ot.PNG') }}" alt="Formulario Documento OT"/><br>
                <p class="text-center help-block"><em>Fig. 4: Formulario para documento tipo OT. (Basado en image_8858f7.png)</em></p>
            </div>
            <p>Documentos asociados a Órdenes de Trabajo específicas.</p>
            <ul>
                <li><strong>Tipo Documento *:</strong> Se selecciona "OT".</li>
                <li><strong>Título *:</strong> Título del documento.</li>
                <li><strong>Descripción:</strong> Descripción adicional.</li>
                <li><strong>Fecha caducidad *:</strong> Fecha de vencimiento del documento.</li>
                </ul>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h4>3.3 Tipo Documento: PROCEDIMIENTO GENERAL</h4>
             <div class="col-sm-8 col-sm-offset-2">
                <img class="img-responsive" src="{{ asset('img/ayuda/documentaciones/Form_doc_proc_general.PNG') }}" alt="Formulario Documento Procedimiento General"/><br>
                <p class="text-center help-block"><em>Fig. 5: Formulario para documento tipo Procedimiento General. (Basado en image_885538.png, interpretado para Proc. General)</em></p>
            </div>
            <p>Procedimientos técnicos o de gestión generales de la empresa.</p>
            <ul>
                <li><strong>Tipo Documento *:</strong> Se selecciona "PROCEDIMIENTO GENERAL".</li>
                <li><strong>Documento *:</strong> Menú desplegable para seleccionar un procedimiento específico de una lista predefinida.</li>
                <li><strong>Título *:</strong> Título del documento (puede autocompletarse o ser editable).</li>
                <li><strong>Descripción:</strong> Descripción adicional.</li>
                <li><strong>Usuario *:</strong> Menú desplegable para seleccionar el usuario responsable o que cargó el procedimiento.</li>
                <li><strong>Método de Ensayo:</strong> Menú desplegable. Las opciones comunes son CV (Control Visual), RI (Radiografía Industrial), US (Ultrasonido), entre otras definidas en el sistema.</li>
                <li><strong>Fecha caducidad *:</strong> Fecha de vencimiento del documento/procedimiento.</li>
            </ul>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h4>3.4 Tipo Documento: USUARIO</h4>
            <div class="col-sm-8 col-sm-offset-2">
                <img class="img-responsive" src="{{ asset('img/ayuda/documentaciones/Form_doc_usuario.PNG') }}" alt="Formulario Documento Usuario"/><br>
                <p class="text-center help-block"><em>Fig. 6: Formulario para documento tipo Usuario. (Basado en image_885538.png, interpretado para Usuario)</em></p>
            </div>
            <p>Documentación personal de los empleados/usuarios (habilitaciones, certificados, etc.).</p>
            <ul>
                <li><strong>Tipo Documento *:</strong> Se selecciona "USUARIO".</li>
                <li><strong>Documento *:</strong> Menú desplegable para indicar el tipo de documento del usuario (ej: Licencia de Operación, Apto Médico, CUIL, DNI, Curso de Manejo Defensivo).</li>
                <li><strong>Título *:</strong> Título del documento (puede autocompletarse según la selección en "Documento" o ser editable).</li>
                <li><strong>Descripción:</strong> Descripción adicional.</li>
                <li><strong>Usuario *:</strong> Menú desplegable para seleccionar al empleado/usuario al que pertenece el documento.</li>
                <li><strong>Método de Ensayo:</strong> Menú desplegable (este campo podría ser opcional o no aplicable para todos los documentos de usuario).</li>
                <li><strong>Fecha caducidad *:</strong> Fecha de vencimiento del documento.</li>
            </ul>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h4>3.5 Tipo Documento: EQUIPO</h4>
            <div class="col-sm-8 col-sm-offset-2">
                <img class="img-responsive" src="{{ asset('img/ayuda/documentaciones/Form_doc_equipo.PNG') }}" alt="Formulario Documento Equipo"/><br>
                <p class="text-center help-block"><em>Fig. 7: Formulario para documento tipo Equipo. (Basado en image_8854f7.png)</em></p>
            </div>
            <p>Documentación asociada a los equipos de la empresa (certificados, manuales, etc.).</p>
            <ul>
                <li><strong>Tipo Documento *:</strong> Se selecciona "EQUIPO".</li>
                <li><strong>Título *:</strong> Título del documento.</li>
                <li><strong>Certificado de verificación:</strong> Casilla de verificación para indicar si el documento es un certificado de verificación del equipo.</li>
                <li><strong>Descripción:</strong> Descripción adicional.</li>
                <li><strong>Equipo *:</strong> Menú desplegable para seleccionar el equipo al que se asocia el documento.</li>
                <li><strong>Tipo Equipamiento:</strong> Campo informativo, probablemente se complete automáticamente al seleccionar el Equipo.</li>
                <li><strong>Usuario asociado:</strong> Menú desplegable para seleccionar un usuario relacionado con el documento del equipo (ej: responsable del equipo).</li>
                <li><strong>Fecha caducidad *:</strong> Fecha de vencimiento del documento.</li>
            </ul>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h4>3.6 Tipo Documento: FUENTE</h4>
            <div class="col-sm-8 col-sm-offset-2">
                <img class="img-responsive" src="{{ asset('img/ayuda/documentaciones/Form_doc_fuente.PNG') }}" alt="Formulario Documento Fuente"/><br>
                <p class="text-center help-block"><em>Fig. 8: Formulario para documento tipo Fuente. (Basado en image_8854bd.png)</em></p>
            </div>
            <p>Documentación específica para fuentes radiactivas u otros tipos de fuentes.</p>
            <ul>
                <li><strong>Tipo Documento *:</strong> Se selecciona "FUENTE".</li>
                <li><strong>Título *:</strong> Título del documento.</li>
                <li><strong>Descripción:</strong> Descripción adicional.</li>
                <li><strong>Fuente:</strong> Menú desplegable para seleccionar la fuente específica a la que se asocia el documento.</li>
                <li><strong>Fecha caducidad *:</strong> Fecha de vencimiento del documento.</li>
            </ul>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h4>3.7 Tipo Documento: VEHICULO</h4>
            <div class="col-sm-8 col-sm-offset-2">
                <img class="img-responsive" src="{{ asset('img/ayuda/documentaciones/Form_doc_vehiculo.PNG') }}" alt="Formulario Documento Vehículo"/><br>
                <p class="text-center help-block"><em>Fig. 9: Formulario para documento tipo Vehículo. (Basado en image_885461.png)</em></p>
            </div>
            <p>Documentación relacionada con los vehículos de la empresa (seguro, VTV, etc.).</p>
            <ul>
                <li><strong>Tipo Documento *:</strong> Se selecciona "VEHICULO".</li>
                <li><strong>Título *:</strong> Título del documento.</li>
                <li><strong>Descripción:</strong> Descripción adicional.</li>
                <li><strong>Vehículo:</strong> Menú desplegable para seleccionar el vehículo específico al que se asocia el documento.</li>
                <li><strong>Fecha caducidad *:</strong> Fecha de vencimiento del documento.</li>
            </ul>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h3>4. Eliminar Documentación</h3>
            <p>Para eliminar un documento, haga clic en el icono de eliminar (🗑️) en la fila correspondiente del listado principal. El sistema solicitará una confirmación antes de proceder con la eliminación definitiva del registro y su archivo asociado.</p>
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
