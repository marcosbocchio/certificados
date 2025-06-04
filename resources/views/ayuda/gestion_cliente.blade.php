@extends('layouts.enod.master')

@section('contenido')

<div class="ayuda_enod">
    <div class="row">
        <div class="col-sm-12">
            <h2>Gestión de Clientes</h2>
            <p>Este módulo es fundamental para registrar y mantener actualizada la información de todos los clientes de la empresa. Un correcto registro de clientes y sus contactos es crucial para la generación de Órdenes de Trabajo (OT) y la documentación asociada.</p>

            <h3>1. Acceso a la Gestión de Clientes</h3>
            <p>Para acceder al módulo de gestión de clientes, diríjase al menú principal y seleccione la opción <strong>Maestros</strong> y luego, dentro del submenú desplegado, haga clic en <strong>Clientes</strong>.</p>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h3>2. Vista Principal de Clientes</h3>
            <p>Al acceder a la sección de Clientes, se presentará una tabla con el listado de todos los clientes registrados. Por cada cliente, se mostrará información como <strong>Nombre</strong> (o nombre de fantasía), <strong>Razón Social</strong>, <strong>Email</strong> principal y <strong>Localidad</strong>.</p>
        </div>
        <div class="col-sm-10 col-sm-offset-1">
            <img class="img-responsive" src="{{ asset('img/ayuda/clientes/Listado_clientes.PNG') }}" alt="Listado de Clientes"/><br>
            <p class="text-center help-block"><em>Fig. 1: Vista principal del listado de clientes. (Basado en image_894158.png)</em></p>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h4>Buscar Clientes</h4>
            <p>En la parte superior derecha de la tabla, encontrará un campo de <strong>Buscar...</strong>. Ingrese el nombre, razón social, email u otro dato relevante del cliente que desea localizar y presione Enter o haga clic en el icono de la lupa (🔍) para filtrar la lista.</p>

            <h4>Acciones Disponibles por Cliente</h4>
            <p>A la derecha de cada fila de cliente en la tabla, encontrará los siguientes iconos de acción:</p>
        </div>
        <div class="col-sm-12 detalle_iconos">
            <p><img class="img-responsive" src="{{ asset('img/ayuda/usuarios/Icono_editar_usuario.PNG') }}" alt="Editar Cliente"/>&nbsp;&nbsp;<strong>Editar Cliente:</strong> Icono naranja con un lápiz. Permite modificar los datos del cliente seleccionado, incluyendo sus contactos.</p>
            <p><img class="img-responsive" src="{{ asset('img/ayuda/usuarios/Icono_eliminar_usuario.PNG') }}" alt="Eliminar Cliente"/>&nbsp;&nbsp;<strong>Eliminar Cliente:</strong> Icono rojo con un cesto de basura. Permite eliminar el cliente del sistema (esta acción generalmente requiere confirmación y puede estar restringida si el cliente tiene OTs asociadas).</p>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h3>3. Crear un Nuevo Cliente</h3>
            <p>Para agregar un nuevo cliente al sistema, haga clic en el botón amarillo <strong>"+ Nuevo"</strong> ubicado en la esquina superior izquierda de la pantalla de listado de clientes.</p>
        </div>
         <div class="col-sm-8 col-sm-offset-2">
            <img class="img-responsive" src="{{ asset('img/ayuda/clientes/Formulario_nuevo_cliente.PNG') }}" alt="Formulario Nuevo Cliente"/><br>
            <p class="text-center help-block"><em>Fig. 2: Formulario para la creación de un nuevo cliente. (Basado en image_8940fa.png)</em></p>
        </div>
        <div class="col-sm-12">
            <p>Esto abrirá el formulario de creación de clientes, dividido en secciones:</p>
            <h4>Sección "Datos Cliente"</h4>
            <p>Complete la información general del cliente (los campos con * son obligatorios):</p>
            <ul>
                <li><strong>Código *:</strong> Identificador único para el cliente (puede ser asignado por el sistema o manual).</li>
                <li><strong>Nombre *:</strong> Nombre de fantasía o comercial del cliente.</li>
                <li><strong>Razón Social *:</strong> Razón social legal del cliente.</li>
                <li><strong>Provincia *:</strong> Seleccione la provincia de una lista desplegable.</li>
                <li><strong>Localidad *:</strong> Seleccione la localidad de una lista desplegable (dependiente de la provincia).</li>
                <li><strong>Código Postal *:</strong> Código postal de la dirección principal.</li>
                <li><strong>Dirección *:</strong> Dirección física principal del cliente.</li>
                <li><strong>Teléfono *:</strong> Número de teléfono principal. (Ej: 0299-15-1234567 / 0299-4444-3333 (111))</li>
                <li><strong>Email *:</strong> Dirección de correo electrónico principal del cliente.</li>
                <li><strong>Logo:</strong> Permite cargar el logo del cliente (Formatos soportados: .png, .bmp, .jpg).</li>
            </ul>

            <h4>Sección "Contacto"</h4>
            <p>Esta sección permite agregar una o más personas de contacto para el cliente. Es importante registrar al menos un contacto, ya que puede ser requerido en otras partes del sistema (ej. para notificaciones o como responsable en OTs).</p>
            <ul>
                <li><strong>Nombre:</strong> Nombre del contacto.</li>
                <li><strong>Cargo:</strong> Cargo del contacto dentro de la empresa cliente.</li>
                <li><strong>Teléfono:</strong> Número de teléfono del contacto.</li>
                <li><strong>Email:</strong> Dirección de correo electrónico del contacto.</li>
            </ul>
            <p>Para agregar un contacto, complete los campos y haga clic en el botón <strong>"+"</strong> (icono de suma). El contacto se añadirá a una lista en la parte inferior de esta sección.</p>
        </div>
        <div class="col-sm-8 col-sm-offset-2">
            <img class="img-responsive" src="{{ asset('img/ayuda/clientes/Formulario_nuevo_cliente_contacto.PNG') }}" alt="Sección Contacto Nuevo Cliente"/><br>
            <p class="text-center help-block"><em>Fig. 3: Detalle de la sección "Contacto" en el formulario de nuevo cliente. (Montaje conceptual basado en image_8940fa.png)</em></p>
        </div>
         <div class="col-sm-12">
            <h4>Guardar o Cancelar</h4>
            <p>Una vez completados todos los campos necesarios:</p>
            <ul>
                <li>Haga clic en <strong>"Guardar"</strong> para crear el nuevo cliente y añadirlo al listado.</li>
                <li>Haga clic en <strong>"Cancelar"</strong> para descartar los cambios y cerrar el formulario.</li>
            </ul>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h3>4. Editar un Cliente Existente</h3>
            <p>Para modificar la información de un cliente ya creado:</p>
            <ol>
                <li>Localice el cliente en la tabla y haga clic en el icono naranja de editar (✏️) correspondiente.</li>
                <li>Se abrirá un formulario similar al de creación, pero pre-cargado con los datos actuales del cliente y sus contactos.</li>
            </ol>
        </div>
        <div class="col-sm-8 col-sm-offset-2">
            <img class="img-responsive" src="{{ asset('img/ayuda/clientes/Formulario_editar_cliente.PNG') }}" alt="Formulario Editar Cliente"/><br>
            <p class="text-center help-block"><em>Fig. 4: Ejemplo del formulario de edición de un cliente, mostrando datos y un contacto existente. (Basado en image_89409c.png)</em></p>
        </div>
        <div class="col-sm-12">
            <ol start="3">
                <li>Realice las modificaciones necesarias en la sección "Datos Cliente".</li>
                <li>En la sección "Contacto", puede:
                    <ul>
                        <li><strong>Agregar nuevos contactos:</strong> Complete los campos y pulse el botón "+".</li>
                        <li><strong>Eliminar contactos existentes:</strong> Cada contacto listado tendrá un icono de eliminar (generalmente una papelera 🗑️) a su derecha. Haga clic en él para quitar el contacto.</li>
                    </ul>
                </li>
                <li>Haga clic en <strong>"Guardar"</strong> para aplicar los cambios o <strong>"Cancelar"</strong> para descartarlos.</li>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h3>5. Eliminar un Cliente</h3>
            <p>Para eliminar un cliente del sistema:</p>
            <ol>
                <li>Localice el cliente en la tabla y haga clic en el icono rojo de eliminar (🗑️) correspondiente.</li>
                <li>Es probable que el sistema solicite una confirmación antes de proceder. Tenga en cuenta que si el cliente tiene Órdenes de Trabajo u otros registros asociados, es posible que el sistema no permita su eliminación o requiera pasos adicionales.</li>
                <li>Confirme la acción para eliminar el cliente, si procede.</li>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h3>Artículos relacionados&nbsp;</h3>
            <p><a href="{{ route('ayuda-ordenes-trabajo') }}">Gestión de Órdenes de Trabajo (OT)</a></p>
        </div>
    </div>
</div>

@endsection
