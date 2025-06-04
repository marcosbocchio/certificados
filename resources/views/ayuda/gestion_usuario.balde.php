@extends('layouts.enod.master')

@section('contenido')

<div class="ayuda_enod">
    <div class="row">
        <div class="col-sm-12">
            <h2>Gestión de Usuarios</h2>
            <p>Este módulo permite administrar integralmente los usuarios del sistema, incluyendo su creación, edición, asignación de roles y permisos, y gestión de notificaciones.</p>

            <h3>1. Acceso a la Gestión de Usuarios</h3>
            <p>Para acceder al módulo de gestión de usuarios, diríjase al menú principal y seleccione la opción <strong>Maestros</strong> y luego, dentro del submenú desplegado, haga clic en <strong>Usuarios</strong>.</p>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h3>2. Vista Principal de Usuarios</h3>
            <p>Al acceder a la sección de Usuarios, se presentará una tabla con el listado de todos los usuarios registrados en el sistema. Por cada usuario, se mostrará información relevante como <strong>Nombre</strong>, <strong>Email</strong> y, si aplica, <strong>Cliente</strong> asociado.</p>
        </div>
        <div class="col-sm-8 col-sm-offset-2">
            <img class="img-responsive" src="{{ asset('img/ayuda/usuarios/Listado_usuarios.PNG') }}" alt="Listado de Usuarios"/><br>
            <p class="text-center help-block"><em>Fig. 1: Vista principal del listado de usuarios.</em></p>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h4>Buscar Usuarios</h4>
            <p>En la parte superior derecha de la tabla, encontrará un campo de <strong>Buscar...</strong>. Ingrese el nombre, email u otro dato relevante del usuario que desea localizar y presione Enter o haga clic en el icono de la lupa (🔍) para filtrar la lista.</p>

            <h4>Acciones Disponibles por Usuario</h4>
            <p>A la derecha de cada fila de usuario en la tabla, encontrará iconos de acción:</p>
        </div>
        <div class="col-sm-12 detalle_iconos">
            <p><img class="img-responsive" src="{{ asset('img/ayuda/usuarios/Icono_editar_usuario.PNG') }}" alt="Editar Usuario"/>&nbsp;&nbsp;<strong>Editar Usuario:</strong> Icono naranja con un lápiz. Permite modificar los datos del usuario seleccionado.</p>
            <p><img class="img-responsive" src="{{ asset('img/ayuda/usuarios/Icono_eep_usuario.PNG') }}" alt="Asignación EEP"/>&nbsp;&nbsp;<strong>Asignación EEP:</strong> Icono gris con un portapapeles. Permite ver y gestionar los Equipos de Protección Personal asignados al usuario.</p>
            <p><img class="img-responsive" src="{{ asset('img/ayuda/usuarios/Icono_eliminar_usuario.PNG') }}" alt="Eliminar Usuario"/>&nbsp;&nbsp;<strong>Eliminar Usuario:</strong> Icono rojo con un cesto de basura. Permite eliminar el usuario del sistema (esta acción generalmente requiere confirmación).</p>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h3>3. Crear un Nuevo Usuario</h3>
            <p>Para agregar un nuevo usuario al sistema, haga clic en el botón amarillo <strong>"+ Nuevo"</strong> ubicado en la esquina superior izquierda de la pantalla de listado de usuarios.</p>
        </div>
        <div class="col-sm-8 col-sm-offset-2">
            <img class="img-responsive" src="{{ asset('img/ayuda/usuarios/Boton_nuevo_usuario.PNG') }}" alt="Botón Nuevo Usuario"/><br>
            <p class="text-center help-block"><em>Fig. 2: Botón para iniciar la creación de un nuevo usuario.</em></p>
        </div>
        <div class="col-sm-12">
            <p>Esto abrirá el formulario de creación de usuarios. Primero, deberá seleccionar el tipo de usuario.</p>
            <h4>Selección de Tipo de Usuario</h4>
            <p>En la parte superior del formulario, deberá seleccionar el tipo de usuario que desea crear:</p>
            <ul>
                <li><strong>Enod:</strong> Para usuarios internos de la empresa.</li>
                <li><strong>Cliente:</strong> Para usuarios que son clientes de Enod.</li>
                <li><strong>Local Neuquén:</strong> Para usuarios internos específicos de la localidad de Neuquén (o una categoría similar).</li>
            </ul>
            <p>La selección del tipo de usuario determinará los campos disponibles en el formulario.</p>
        </div>
        <div class="col-sm-8 col-sm-offset-2">
            <img class="img-responsive" src="{{ asset('img/ayuda/usuarios/Formulario_crear_usuario_enod.PNG') }}" alt="Formulario Crear Usuario Enod/Local Neuquén"/><br>
            <p class="text-center help-block"><em>Fig. 3: Ejemplo de formulario de creación para usuario tipo "Enod".</em></p>
        </div>
        <div class="col-sm-12">
            <h4>Formulario de Creación para "Enod" o "Local Neuquén"</h4>
            <p>Si selecciona "Enod" o "Local Neuquén", deberá completar los siguientes campos (los campos con * son obligatorios):</p>
            <ul>
                <li><strong>Nombre *:</strong> Nombre completo del usuario.</li>
                <li><strong>ACTIVO:</strong> Marque esta casilla si el usuario estará activo en el sistema.</li>
                <li><strong>DNI *:</strong> Número de Documento Nacional de Identidad del usuario.</li>
                <li><strong>Film:</strong> Casilla de verificación (propósito específico del sistema).</li>
                <li><strong>Habilitado Arn:</strong> Casilla de verificación (propósito específico del sistema).</li>
                <li><strong>Email *:</strong> Dirección de correo electrónico del usuario.</li>
                <li><strong>Informes a firmar:</strong> Campo de selección para los tipos de informes que puede firmar.</li>
                <li><strong>Contraseña *:</strong> Establezca una contraseña para el acceso.</li>
                <li><strong>Repetir Contraseña *:</strong> Confirme la contraseña.</li>
                <li><strong>Firma Digital:</strong> Permite cargar una imagen de la firma digital.
                    <ul>
                        <li><em>Formatos soportados: .png, .bmp, .jpg.</em></li>
                        <li><em>Relación 2:1 Ej: 400x200 Píxeles.</em></li>
                    </ul>
                </li>
            </ul>

            <h4>Formulario de Creación para "Cliente"</h4>
            <p>Si selecciona "Cliente", el formulario será más simplificado:</p>
             <ul>
                <li><strong>Nombre *:</strong> Nombre completo del contacto del cliente.</li>
                <li><strong>ACTIVO:</strong> Marque si el usuario cliente estará activo.</li>
                <li><strong>Cliente *:</strong> Seleccione la empresa cliente.</li>
                <li><strong>Email *:</strong> Dirección de correo electrónico del usuario cliente.</li>
                <li><strong>Contraseña *:</strong> Establezca una contraseña.</li>
                <li><strong>Repetir Contraseña *:</strong> Confirme la contraseña.</li>
            </ul>
        </div>
        <div class="col-sm-8 col-sm-offset-2">
            <img class="img-responsive" src="{{ asset('img/ayuda/usuarios/Formulario_crear_usuario_cliente.PNG') }}" alt="Formulario Crear Usuario Cliente"/><br>
            <p class="text-center help-block"><em>Fig. 4: Ejemplo de formulario de creación para usuario tipo "Cliente".</em></p>
        </div>

        <div class="col-sm-12">
            <h4>Configuración de Alarmas</h4>
            <p>En la sección "Alarmas", puede configurar notificaciones automáticas para este usuario:</p>
            <ul>
                <li><strong>Exceptuar vencimiento doc.:</strong> No enviar alarmas de vencimiento de documentación.</li>
                <li><strong>Notificar por web.:</strong> Mostrar notificaciones dentro del sistema.</li>
                <li><strong>Exceptuar demora dosimetría.:</strong> No enviar alarmas por demoras en dosimetría.</li>
                <li><strong>Notificar por mail.:</strong> Enviar notificaciones al correo electrónico.</li>
            </ul>

            <h4>Asignación de Roles</h4>
            <p>En la sección "Roles", asigne los permisos específicos marcando las casillas correspondientes. Cada rol define el acceso a diferentes módulos y funcionalidades.</p>

            <h4>Guardar o Cancelar</h4>
            <p>Una vez completados todos los campos necesarios:</p>
            <ul>
                <li>Haga clic en <strong>"Guardar"</strong> para crear el nuevo usuario.</li>
                <li>Haga clic en <strong>"Cancelar"</strong> para descartar los cambios.</li>
            </ul>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h3>4. Editar un Usuario Existente</h3>
            <p>Para modificar la información de un usuario ya creado:</p>
            <ol>
                <li>Localice el usuario en la tabla y haga clic en el icono naranja de editar (✏️).</li>
                <li>Se abrirá un formulario pre-cargado con los datos actuales del usuario.</li>
                <li>Realice las modificaciones necesarias. Si desea cambiar la contraseña, ingrésela en los campos "Contraseña" y "Repetir Contraseña". Si los deja vacíos, la contraseña actual no se modificará.</li>
                <li>Haga clic en <strong>"Guardar"</strong> para aplicar los cambios o <strong>"Cancelar"</strong>.</li>
            </ol>
        </div>
        <div class="col-sm-8 col-sm-offset-2">
            <img class="img-responsive" src="{{ asset('img/ayuda/usuarios/Formulario_editar_usuario.PNG') }}" alt="Formulario Editar Usuario"/><br>
            <p class="text-center help-block"><em>Fig. 5: Ejemplo del formulario de edición de un usuario.</em></p>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h3>5. Eliminar un Usuario</h3>
            <p>Para eliminar un usuario del sistema:</p>
            <ol>
                <li>Localice el usuario en la tabla y haga clic en el icono rojo de eliminar (🗑️).</li>
                <li>El sistema solicitará una confirmación. Asegúrese antes de confirmar, ya que esta acción suele ser irreversible.</li>
            </ol>

            <h3>6. Gestionar Asignación EEP (Equipos de Protección Personal)</h3>
            <p>Para ver o modificar los Equipos de Protección Personal (EEP) asignados a un usuario:</p>
            <ol>
                <li>Localice el usuario en la tabla y haga clic en el icono gris con el portapapeles (📋).</li>
                <li>Se abrirá una nueva pantalla o sección para gestionar la asignación de EEP.</li>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h3>Artículos relacionados&nbsp;</h3>
            <p><a href="{{ route('ayuda-configuracion-roles') }}">Configuración de Roles y Permisos</a></p>
            <p><a href="{{ route('ayuda-gestion-clientes') }}">Gestión de Clientes (Maestro)</a></p>
            <p><a href="{{ route('ayuda-gestion-eep') }}">Gestión de EEP</a></p>
            <p><a href="{{ route('ayuda-notificaciones-sistema') }}">Configuración General de Notificaciones</a></p>
        </div>
    </div>
</div>

@endsection
