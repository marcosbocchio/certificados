@extends('layouts.enod.master')

@section('contenido')

<div class="ayuda_enod">
    <div class="row">
            <div class="col-sm-12">
                <h4>Crear un Nuevo Usuario</h4>
                <p>Para dar de alta un nuevo usuario:</p>
                <ol>
                    <li>Utilizamos el menú lateral izquierdo y seleccionamos <strong>Maestro > Usuario</strong>.</li>
                    <li>Hacemos clic en el botón <strong>'Nuevo'</strong>.</li>
                    <li>En la parte superior del formulario, seleccionamos si el usuario será parte del <strong>personal</strong> o un <strong>cliente</strong>. Esto determinará el nivel de acceso y las acciones que el usuario podrá realizar en la app.</li>
                    <li>En la sección de <strong>Roles</strong>, asignamos los permisos adecuados al usuario basándonos en la actividad que va a realizar dentro de la plataforma.</li>
                    <li>Llenamos los campos requeridos en el formulario con la información del usuario.</li>
                    <li>Finalmente, hacemos clic en <strong>'Guardar'</strong> para completar el registro del usuario.</li>
                </ol>
                <p>Mira el siguiente video para ver cómo crear un nuevo usuario:</p>
            </div>
        
            <!-- Incluir GIF de creación de usuario -->
        <div class="col-md-6 col-md-offset-3">
            <img  class="img-responsive" src="{{ asset('img/ayuda/generar_usuario.gif') }}" alt="Crear usuario"/>
        </div>
        <div class="col-sm-12">
            <h4>Editar un Usuario</h4>
            <p>Para editar la información de un usuario existente:</p>
            <ol>
                <li>Busca al usuario que deseas editar en la tabla de usuarios.</li>
                <li>Clic en el ícono de edición <img class="icon-inline" src="{{ asset('img/ayuda/Boton_editar.PNG') }}" alt="Editar"></li>
                <li>Modifica la información necesaria en el formulario que aparece.</li>
                <li>Guarda los cambios haciendo clic en <strong>'Guardar'</strong>.</li>
            </ol>
            <p>Este video muestra el proceso de edición de un usuario:</p>
        </div>
            
        <div class="col-md-6 col-md-offset-3">
            <img  class="img-responsive" src="{{ asset('img/ayuda/editar_usuario.gif') }}" alt="Editar usuario"/>
        </div>
        <div class="col-sm-12">
            <h4>Eliminar un Usuario</h4>
            <p>Para eliminar un usuario:</p>
            <ol>
                <li>En la tabla de usuarios, localiza al usuario que deseas eliminar.</li>
                <li>Haz clic en el ícono de eliminar <img class="icon-inline" src="{{ asset('img/ayuda/boton_borrado.PNG') }}" alt="Editar"></li>
                <li>Confirma la acción seleccionando <strong>'Aceptar'</strong> en el mensaje de confirmación que aparece.</li>
            </ol>
            <p>Nota: Ten en cuenta que esta acción es irreversible y debe realizarse con precaución.</p>
        </div>

        <div class="col-md-6 col-md-offset-3">
            <img  class="img-responsive" src="{{ asset('img/ayuda/eliminar_usuario.gif') }}" alt="Editar usuario"/>
        </div>

        <div class="col-sm-12">
            <h4>Artículos relacionados</h4>
            <ul>
                <li><a href="#">-</a></li>
                <li><a href="#">-</a></li>
                <!-- Incluir otros artículos relacionados según sea necesario -->
            </ul>
    </div>
</div>

@endsection