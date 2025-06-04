@extends('layouts.enod.master')

@section('contenido')

<div class="ayuda_enod">
    <div class="row">
        <div class="col-sm-12">
            <h2>Gestión de Remisiones (Remitos)</h2>
            <p>El módulo de Remisiones permite gestionar la creación, seguimiento y administración de remitos o notas de entrega. Estos documentos son esenciales para registrar el movimiento de productos (especialmente aquellos que son inventariables/stockeables) y equipos entre diferentes frentes u ubicaciones, así como para asignar Equipos de Protección Personal (EPP) a los operadores vinculados a un remito.</p>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h3>1. Acceso al Listado de Remisiones</h3>
            <p>Para acceder al listado de remisiones, navegue desde el menú principal:</p>
            <ol>
                <li>Haga clic en <strong>REMISIONES</strong> en el menú lateral.</li>
                <li>Luego, seleccione <strong>Listado</strong> en el submenú desplegado.</li>
            </ol>
        </div>
        <div class="col-sm-4 col-sm-offset-4">
             <img class="img-responsive" src="{{ asset('img/ayuda/remisiones/Menu_remisiones.PNG') }}" alt="Acceso a Remisiones desde Menú"/><br>
            <p class="text-center help-block"><em>Fig. 1: Acceso al listado de remisiones desde el menú. (Basado en image_5fd48f.png)</em></p>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h3>2. Vista Principal (Listado de Remitos)</h3>
            <p>Al ingresar, se muestra una tabla con todos los remitos generados. Las columnas principales son:</p>
            <ul>
                <li><strong>N°:</strong> Número identificatorio único del remito.</li>
                <li><strong>Frente origen:</strong> Lugar desde donde se envían los ítems.</li>
                <li><strong>Frente destino:</strong> Lugar hacia donde se envían los ítems.</li>
                <li><strong>Receptor:</strong> Persona o entidad que recibe.</li>
                <li><strong>Destino:</strong> Descripción del destino final.</li>
                <li><strong>Fecha:</strong> Fecha de creación del remito.</li>
                <li><strong>Anulado:</strong> Indica si el remito ha sido anulado (usualmente con "Sí" o una fecha de anulación).</li>
                <li><strong>Borrador:</strong> Indica si el remito está guardado como borrador y aún no ha sido finalizado.</li>
            </ul>
        </div>
        <div class="col-sm-12">
            <img class="img-responsive" src="{{ asset('img/ayuda/remisiones/Listado_remitos.PNG') }}" alt="Listado de Remitos"/><br>
            <p class="text-center help-block"><em>Fig. 2: Vista principal del listado de remitos. (Basado en image_5fd44d.png)</em></p>
        </div>
        <div class="col-sm-12">
            <h4>Funcionalidades del Listado:</h4>
            <ul>
                <li><strong>Nuevo Remito:</strong> Botón amarillo <strong>"+ Nuevo"</strong> en la esquina superior izquierda para iniciar la creación de un remito.</li>
                <li><strong>Buscar:</strong> Campo de búsqueda en la esquina superior derecha para filtrar remitos.</li>
                <li><strong>Paginación:</strong> Controles en la parte inferior para navegar entre páginas si el listado es extenso.</li>
            </ul>
            <h4>Acciones Disponibles por Remito:</h4>
            <p>A la derecha de cada remito en la tabla, encontrará los siguientes iconos:</p>
        </div>
        <div class="col-sm-12 detalle_iconos">
            <p><img class="img-responsive" src="{{ asset('img/ayuda/usuarios/Icono_editar_usuario.PNG') }}" alt="Editar Remito"/>&nbsp;&nbsp;<strong>Editar Remito:</strong> Permite modificar un remito. <strong>Importante:</strong> Generalmente solo se pueden editar los remitos que han sido guardados como "Borrador".</p>
            <p><img class="img-responsive" src="{{ asset('img/ayuda/usuarios/Icono_eep_usuario.PNG') }}" alt="EPP Remito"/>&nbsp;&nbsp;<strong>EPP Remito:</strong> Icono de portapapeles. Permite ver y asignar Equipos de Protección Personal (EPP) a los operadores asociados con este remito (ver sección 4).</p>
            <p><img class="img-responsive" src="{{ asset('img/ayuda/remisiones/Icono_imprimir.PNG') }}" alt="Imprimir Remito"/>&nbsp;&nbsp;<strong>Imprimir Remito:</strong> Abre o descarga una versión en PDF del remito finalizado.</p>
            <p><img class="img-responsive" src="{{ asset('img/ayuda/remisiones/Icono_anular.PNG') }}" alt="Anular Remito"/>&nbsp;&nbsp;<strong>Anular Remito:</strong> Permite anular un remito que ya fue procesado. Esta acción revierte los movimientos de stock asociados al remito.</p>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h3>3. Crear un Nuevo Remito</h3>
            <p>Al hacer clic en el botón <strong>"+ Nuevo"</strong>, se accede al formulario de creación.</p>
             <div class="col-sm-10 col-sm-offset-1">
                <img class="img-responsive" src="{{ asset('img/ayuda/remisiones/Formulario_nuevo_remito.PNG') }}" alt="Formulario Nuevo Remito"/><br>
                <p class="text-center help-block"><em>Fig. 3: Formulario para la creación de un nuevo remito. (Basado en image_5fcd6d.png)</em></p>
            </div>
            <h4>Encabezado del Remito:</h4>
            <ul>
                <li><strong>Guardar como Borrador:</strong> Casilla de verificación en la esquina superior derecha. Si se marca, el remito se guarda en un estado editable y no finaliza movimientos de stock ni genera PDF final.</li>
                <li><strong>Fecha *:</strong> Fecha de emisión del remito (autocompletada con la fecha actual, editable).</li>
                <li><strong>Prefijo N° *:</strong> Prefijo para la numeración del remito.</li>
                <li><strong>Remito N° *:</strong> Número correlativo del remito (puede ser autogenerado o manual).</li>
                <li><strong>Frente origen *:</strong> Menú desplegable para seleccionar el lugar de origen de los ítems.</li>
                <li><strong>Frente destino *:</strong> Menú desplegable para seleccionar el lugar de destino.</li>
                <li><strong>Receptor *:</strong> Nombre de la persona o entidad que recibe.</li>
                <li><strong>Lugar Destino *:</strong> Descripción más detallada del destino.</li>
            </ul>
            <h4>Detalle del Remito:</h4>
            <p>El formulario se divide en secciones para agregar diferentes tipos de ítems:</p>
            <ul>
                <li><strong>Productos:</strong>
                    <ul>
                        <li><strong>Productos (Desplegable):</strong> Seleccione un producto de la lista. Solo se muestran productos definidos como "stockeables" en el maestro de Productos.</li>
                        <li><strong>Medidas (Desplegable):</strong> Seleccione la medida correspondiente al producto.</li>
                        <li><strong>Cant.:</strong> Ingrese la cantidad del producto.</li>
                        <li>Icono <strong>[+]</strong>: Haga clic para agregar la línea de producto al remito. Se pueden agregar múltiples productos.</li>
                        <li><strong>Impacto en Stock:</strong> Al guardar un remito finalizado (no borrador), las cantidades de los productos stockeables se descuentan del stock.</li>
                    </ul>
                </li>
                <li><strong>Equipo:</strong>
                    <ul>
                        <li><strong>Equipo * (Desplegable):</strong> Seleccione un equipo del inventario (Interno Equipos).</li>
                        <li>Icono <strong>[+]</strong>: Haga clic para agregar el equipo al remito.</li>
                    </ul>
                </li>
                <li><strong>Otros:</strong>
                    <ul>
                        <li><strong>Otros (Texto):</strong> Descripción de un ítem no catalogado como producto o equipo.</li>
                        <li><strong>Cantidad *:</strong> Ingrese la cantidad.</li>
                        <li>Icono <strong>[+]</strong>: Haga clic para agregar el ítem "Otros".</li>
                    </ul>
                </li>
                <li><strong>Observaciones:</strong> Campo de texto libre para cualquier nota adicional sobre el remito.</li>
            </ul>
            <h4>Guardado:</h4>
            <p>Al hacer clic en el botón <strong>"Guardar"</strong> (ubicado al final del formulario):</p>
            <ul>
                <li>Si está marcado como "Guardar como Borrador", el remito se guarda y permanece editable. No afecta stock.</li>
                <li>Si NO está marcado como borrador, el remito se finaliza, se descuenta el stock de los productos correspondientes, se genera un PDF del remito y se agrega al listado principal.</li>
            </ul>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h3>4. Gestión de EPP para un Remito</h3>
            <p>Esta funcionalidad permite asignar Equipos de Protección Personal (EPP) a los operadores en el contexto de un remito específico. Se accede haciendo clic en el icono de portapapeles (📋) en la fila del remito deseado en el listado principal.</p>
            <div class="col-sm-8 col-sm-offset-2">
                <img class="img-responsive" src="{{ asset('img/ayuda/remisiones/Vista_epp_remito.PNG') }}" alt="Vista EPP Remito"/><br>
                <p class="text-center help-block"><em>Fig. 4: Pantalla inicial de EPP para un Remito. (Basado en image_5e0e1a.png)</em></p>
            </div>
            <h4>4.1. Seleccionar Operador</h4>
            <p>En la pantalla "EPP Remito", el número de remito se muestra como referencia. Para asignar EPP, primero debe seleccionar un operador:</p>
            <ol>
                <li>Haga clic en el icono <strong>[+]</strong> junto al número de Remito.</li>
                <li>Se abrirá una ventana modal "Seleccionar Operador".</li>
                <li>Elija el <strong>Operador</strong> del menú desplegable.</li>
                <li>Haga clic en el botón amarillo <strong>"Seleccionar"</strong>.</li>
            </ol>
             <div class="col-sm-6 col-sm-offset-3">
                <img class="img-responsive" src="{{ asset('img/ayuda/remisiones/Modal_seleccionar_operador_epp.PNG') }}" alt="Modal Seleccionar Operador EPP"/><br>
                <p class="text-center help-block"><em>Fig. 5: Modal para seleccionar el operador al que se asignará EPP. (Basado en image_5e036b.png)</em></p>
            </div>
            <h4>4.2. Asignar Productos como EPP</h4>
            <p>Una vez seleccionado el operador, se habilita el formulario para la asignación de EPP:</p>
            <div class="col-sm-8 col-sm-offset-2">
                <img class="img-responsive" src="{{ asset('img/ayuda/remisiones/Formulario_asignacion_epp.PNG') }}" alt="Formulario Asignación EPP"/><br>
                <p class="text-center help-block"><em>Fig. 6: Formulario para asignar productos como EPP al operador seleccionado. (Basado en image_5e02d9.png)</em></p>
            </div>
            <ul>
                <li><strong>Operador *:</strong> Muestra el operador seleccionado (no editable aquí).</li>
                <li><strong>Remito *:</strong> Muestra el remito de referencia (no editable aquí).</li>
                <li><strong>Producto *:</strong> Menú desplegable. Este listado contendrá los <strong>productos que fueron incluidos en el remito original</strong>. Seleccione el producto que se entregará como EPP.</li>
                <li><strong>Cantidad *:</strong> Ingrese la cantidad de ese producto/EPP entregada al operador.</li>
                <li>Icono <strong>[+]</strong>: Haga clic para agregar la línea de EPP. Los EPP asignados se listarán debajo.</li>
                <li><strong>Observaciones:</strong> Campo para notas sobre la entrega de EPP.</li>
            </ul>
            <p>Haga clic en <strong>"Guardar"</strong> para registrar la asignación de EPP.</p>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h3>5. Editar un Remito (Borrador)</h3>
            <p>Como se mencionó, generalmente solo los remitos guardados como "Borrador" pueden ser editados. El proceso de edición es similar al de creación, abriendo el mismo formulario (Fig. 3) pero con los datos pre-cargados para su modificación.</p>

            <h3>6. Anular un Remito</h3>
            <p>Si un remito finalizado necesita ser invalidado, se utiliza la opción "Anular" (icono ❌ en el listado principal). Al anular un remito:</p>
            <ul>
                <li>El remito se marca como "Anulado".</li>
                <li>Cualquier movimiento de stock realizado por este remito (descuento de productos stockeables) se revierte (es decir, el stock de esos productos se incrementa de nuevo).</li>
            </ul>
            <p>Esta acción requiere confirmación y es importante para mantener la integridad del inventario.</p>

            <h3>7. Imprimir/Ver PDF de Remito</h3>
            <p>Haciendo clic en el icono de impresora (📠) en el listado principal, se puede visualizar o descargar una versión en PDF del remito finalizado. Los remitos en estado "Borrador" generalmente no tienen una opción de PDF final hasta que se guardan definitivamente.</p>
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
