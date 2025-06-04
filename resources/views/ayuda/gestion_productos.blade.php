@extends('layouts.enod.master')

@section('contenido')

<div class="ayuda_enod">
    <div class="row">
        <div class="col-sm-12">
            <h2>Gestión de Productos</h2>
            <p>El maestro de "Productos" se utiliza para definir y catalogar los insumos, consumibles o cualquier artículo que la empresa maneje, ya sea para la venta, uso interno en servicios, o control de inventario. Cada producto puede tener propiedades específicas como si es inventariable (stockeable), si está relacionado con placas (ej. radiográficas), o si debe ser visible en las Órdenes de Trabajo (OT).</p>

            <h3>1. Acceso a la Gestión de Productos</h3>
            <p>Para acceder al módulo, diríjase al menú principal y seleccione la opción <strong>Maestros</strong> y luego, dentro del submenú desplegado, haga clic en <strong>Productos</strong>.</p>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h3>2. Vista Principal de Productos</h3>
            <p>Al acceder a la sección, se presentará una tabla con el listado de todos los productos registrados. Las columnas principales son: <strong>código</strong>, <strong>Descripción</strong>, <strong>Unidad Medida</strong>, <strong>Visible OT</strong> (indica si el producto es seleccionable en Órdenes de Trabajo), y <strong>Stock</strong> (cantidad actual si el producto es inventariable).</p>
        </div>
        <div class="col-sm-12"> <img class="img-responsive" src="{{ asset('img/ayuda/productos/Listado_productos.PNG') }}" alt="Listado de Productos"/><br>
            <p class="text-center help-block"><em>Fig. 1: Vista principal del listado de productos. (Basado en image_87d0de.png)</em></p>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h4>Filtros y Búsqueda</h4>
            <p>La vista principal ofrece herramientas para refinar el listado de productos:</p>
            <ul>
                <li><strong>Filtros de Propiedades:</strong> En la parte superior derecha, encontrará casillas de verificación:
                    <ul>
                        <li><strong>Stockeable:</strong> Marque esta casilla para ver solo los productos definidos como inventariables.</li>
                        <li><strong>Relacionado a Placas:</strong> Marque esta casilla para ver solo los productos que tienen una relación con placas (ej. películas radiográficas, chasis).</li>
                    </ul>
                </li>
                <li><strong>Buscar:</strong> Un campo de texto "Buscar..." permite ingresar el código o parte de la descripción del producto para localizarlo. Presione Enter o haga clic en el icono de la lupa (🔍) para aplicar la búsqueda.</li>
            </ul>

            <h4>Paginación</h4>
            <p>Si el listado de productos es extenso, se activarán los controles de paginación en la parte inferior izquierda de la tabla para navegar entre las diferentes páginas.</p>

            <h4>Acciones Disponibles por Producto</h4>
            <p>A la derecha de cada fila en la tabla, encontrará los siguientes iconos de acción:</p>
        </div>
        <div class="col-sm-12 detalle_iconos">
            <p><img class="img-responsive" src="{{ asset('img/ayuda/usuarios/Icono_editar_usuario.PNG') }}" alt="Editar Producto"/>&nbsp;&nbsp;<strong>Editar Producto:</strong> Icono naranja con un lápiz. Permite modificar los datos del producto seleccionado.</p>
            <p><img class="img-responsive" src="{{ asset('img/ayuda/usuarios/Icono_eliminar_usuario.PNG') }}" alt="Eliminar Producto"/>&nbsp;&nbsp;<strong>Eliminar Producto:</strong> Icono rojo con un cesto de basura. Permite eliminar el producto del sistema, previa confirmación.</p>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h3>3. Crear un Nuevo Producto</h3>
            <p>Para agregar un nuevo producto al sistema, haga clic en el botón amarillo <strong>"+ Nuevo"</strong> ubicado en la esquina superior izquierda de la pantalla de listado.</p>
        </div>
         <div class="col-sm-8 col-sm-offset-2">
            <img class="img-responsive" src="{{ asset('img/ayuda/productos/Formulario_nuevo_producto.PNG') }}" alt="Formulario Nuevo Producto"/><br>
            <p class="text-center help-block"><em>Fig. 2: Formulario para la creación de un nuevo producto. (Basado en image_87d0be.png)</em></p>
        </div>
        <div class="col-sm-12">
            <p>Esto abrirá el formulario de creación. En la parte superior, encontrará casillas para definir las propiedades del producto:</p>
            <ul>
                <li><strong>VISIBLE OT:</strong> Marque esta casilla si el producto debe estar disponible para ser seleccionado o utilizado en las Órdenes de Trabajo.</li>
                <li><strong>STOCKEABLE:</strong> Marque esta casilla si el producto es inventariable, es decir, si se controlará su stock.</li>
                <li><strong>RELACIONADO A PLACAS:</strong> Marque esta casilla si el producto tiene una relación directa con placas (ej. películas, chasis, líquidos de revelado para placas).</li>
            </ul>
            <p>A continuación, complete los siguientes campos:</p>
            <ul>
                <li><strong>Código *:</strong> Un código único para identificar el producto (ej: 000001). Es un campo obligatorio.</li>
                <li><strong>Descripción:</strong> Nombre o descripción del producto.</li>
                <li><strong>Metros Totales:</strong> Un campo numérico que podría representar una dimensión total del producto (ej: longitud de un rollo, cantidad inicial si es un ítem a granel). Puede aceptar valores decimales (ej: 11,10).</li>
                <li><strong>Unidad Medida *:</strong> Un menú desplegable para seleccionar la unidad en la que se mide el producto (ej: Cm, Unidad). Estas unidades se cargan desde el maestro de "Unidades de Medida". Es un campo obligatorio.</li>
            </ul>
            <h4>Guardar o Cancelar</h4>
            <p>Una vez completados los campos:</p>
            <ul>
                <li>Haga clic en <strong>"Guardar"</strong> para crear el nuevo producto y añadirlo al listado.</li>
                <li>Haga clic en <strong>"Cancelar"</strong> para descartar los cambios y cerrar el formulario.</li>
            </ul>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h3>4. Editar un Producto Existente</h3>
            <p>Para modificar la información de un producto ya creado:</p>
            <ol>
                <li>Localice el producto en la tabla y haga clic en el icono naranja de editar (✏️) correspondiente.</li>
                <li>Se abrirá un formulario similar al de creación, pre-cargado con los datos y propiedades actuales del producto. Las casillas de VISIBLE OT, STOCKEABLE y RELACIONADO A PLACAS reflejarán el estado actual del producto.</li>
            </ol>
        </div>
        <div class="col-sm-8 col-sm-offset-2">
            <img class="img-responsive" src="{{ asset('img/ayuda/productos/Formulario_editar_producto.PNG') }}" alt="Formulario Editar Producto"/><br>
            <p class="text-center help-block"><em>Fig. 3: Ejemplo del formulario de edición de un producto. (Basado en image_87ce12.png)</em></p>
        </div>
        <div class="col-sm-12">
            <ol start="3">
                <li>Realice las modificaciones necesarias en las propiedades (checkboxes) o en los campos de Código, Descripción, Metros Totales o Unidad Medida.</li>
                <li>Haga clic en <strong>"Guardar"</strong> para aplicar los cambios o <strong>"Cancelar"</strong> para descartarlos.</li>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h3>5. Eliminar un Producto</h3>
            <p>Para eliminar un producto del sistema:</p>
            <ol>
                <li>Localice el producto en la tabla y haga clic en el icono rojo de eliminar (🗑️) correspondiente.</li>
                <li>Se mostrará una ventana de advertencia solicitando confirmación, similar a la de otros módulos (ej: "Advertencia: Está seguro de eliminar el registro '[CÓDIGO DEL PRODUCTO]' ?").</li>
                <li>Para proceder con la eliminación, haga clic en el botón <strong>"Aceptar"</strong>.</li>
                <li>Si desea cancelar la operación, haga clic en <strong>"Cancelar"</strong>.</li>
            </ol>
            <p><strong>Importante:</strong> La eliminación de un producto podría estar restringida si este tiene stock, está asociado a Órdenes de Trabajo, o tiene otros registros vinculados en el sistema.</p>
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
