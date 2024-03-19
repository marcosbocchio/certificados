@extends('layouts.enod.master')

@section('contenido')

<div class="ayuda_enod">
    <div class="row">
        <div class="col-sm-12">
            <h2>Gestión de Usuarios</h2>

            <!-- Sección Crear un Nuevo Usuario -->
            <div class="section">
                <h4>Crear un Nuevo Usuario</h4>
                <p>Para dar de alta un nuevo usuario:</p>
                <ol>
                    <li>Utilizamos el menú lateral izquierdo y seleccionamos <strong>Maestro > Usuario</strong>.</li>
                    <li>Hacemos clic en el botón <strong>'Nuevo'</strong>.</li>
                    <li>Llenamos los campos requeridos en el formulario.</li>
                    <li>Finalmente, hacemos clic en <strong>'Guardar'</strong> para completar el registro del usuario.</li>
                </ol>
                <div class="col-md-6 col-md-offset-3">
                    <img class="img-responsive" src="{{ asset('img/ayuda/generar_usuario.gif') }}" alt="Crear usuario"/>
                </div>
            </div>

            <div class="section-separator"></div> <!-- Separador entre secciones -->

            <!-- Sección Editar un Usuario -->
            <div class="section">
                <h4>Editar un Usuario</h4>
                <p>Para editar la información de un usuario existente:</p>
                <ol>
                    <li>Busca al usuario que deseas editar en la tabla de usuarios.</li>
                    <li>Clic en el ícono de edición <img class="icon-inline" src="{{ asset('img/ayuda/Boton_editar.PNG') }}" alt="Editar"></li>
                    <li>Modifica la información necesaria en el formulario que aparece.</li>
                    <li>Guarda los cambios haciendo clic en <strong>'Guardar'</strong>.</li>
                </ol>
                <div class="col-md-6 col-md-offset-3">
                    <img class="img-responsive" src="{{ asset('img/ayuda/editar_usuario.gif') }}" alt="Editar usuario"/>
                </div>
            </div>

            <div class="section-separator"></div> <!-- Separador entre secciones -->

            <!-- Sección Eliminar un Usuario -->
            <div class="section">
                <h4>Eliminar un Usuario</h4>
                <p>Para eliminar un usuario:</p>
                <ol>
                    <li>En la tabla de usuarios, localiza al usuario que deseas eliminar.</li>
                    <li>Haz clic en el ícono de eliminar <img class="icon-inline" src="{{ asset('img/ayuda/boton_borrado.PNG') }}" alt="Borrar"></li>
                    <li>Confirma la acción seleccionando <strong>'Aceptar'</strong> en el mensaje de confirmación que aparece.</li>
                </ol>
            </div>

            <div class="section-separator"></div> <!-- Separador entre secciones -->

        </div>

        <div class="col-sm-12">
            <h3>Artículos relacionados</h3>
            <ul>
                <li><a href="#">Políticas de seguridad para la gestión de usuarios</a></li>
                <li><a href="#">Cómo restaurar un usuario eliminado</a></li>
                <!-- Incluir otros artículos relacionados según sea necesario -->
            </ul>
        </div>
    </div>
</div>

@endsection