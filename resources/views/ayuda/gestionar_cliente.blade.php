@extends('layouts.enod.master')

@section('contenido')

<div class="ayuda_enod">
    <div class="row">
        <div class="col-sm-12">
            <h4>Gestionar Clientes</h4>
            <p>Para gestionar los clientes dentro de la plataforma, sigue estos pasos:</p>
            <ol>
                <li>Accedemos al panel lateral izquierdo y seleccionamos <strong>Maestros > Clientes</strong>.</li>
                <li>Visualizaremos una tabla con los clientes existentes. Para agregar un nuevo cliente, hacemos clic en el botón <strong>'Nuevo'</strong>.</li>
                <li>Procedemos a cargar los campos necesarios en el formulario. Tenemos la posibilidad de agregar un logo para facilitar el reconocimiento del cliente.</li>
                <li>En la sección <strong>'Contacto'</strong>, podemos agregar información de varios contactos, añadiéndolos con el botón <strong>'+'</strong>.</li>
                <li>Una vez completado el formulario, hacemos clic en <strong>'Guardar'</strong> para finalizar el registro del cliente.</li>
            </ol>
            <p>Mira el siguiente video para ver cómo agregar un nuevo cliente:</p>
        </div>

        <!-- Incluir GIF de creación de cliente -->
        <div class="col-md-6 col-md-offset-3">
            <img class="img-responsive" src="{{ asset('img/ayuda/crear_cliente.gif') }}" alt="Crear cliente"/>
        </div>

        <div class="col-sm-12">
            <h4>Editar un Cliente</h4>
            <p>Para editar la información de un cliente existente:</p>
            <ol>
                <li>Busca al cliente que deseas editar en la tabla de clientes y haz clic en el ícono de edición <img class="icon-inline" src="{{ asset('img/ayuda/Boton_editar.PNG') }}" alt="Editar"></li>
                <li>Se abrirán los datos del cliente. Una vez modificada la información necesaria, haz clic en <strong>'Guardar'</strong> para aplicar los cambios.</li>
            </ol>
            <p>Este video muestra el proceso de edición de un cliente:</p>
        </div>

        <!-- Incluir GIF de edición de cliente -->
        <div class="col-md-6 col-md-offset-3">
            <img class="img-responsive" src="{{ asset('img/ayuda/editar_cliente.gif') }}" alt="Editar cliente"/>
        </div>

        <div class="col-sm-12">
            <h4>Eliminar un Cliente</h4>
            <p>Para eliminar un cliente:</p>
            <ol>
                <li>Localiza al cliente que deseas eliminar en la tabla y haz clic en el ícono de eliminar <img class="icon-inline" src="{{ asset('img/ayuda/boton_borrado.PNG') }}" alt="Eliminar"></li>
                <li>Confirma la acción seleccionando <strong>'Aceptar'</strong> en el mensaje de confirmación. Recuerda que esta acción es irreversible.</li>
            </ol>
        </div>

        <!-- Incluir GIF de eliminación de cliente -->
        <div class="col-md-6 col-md-offset-3">
            <img class="img-responsive" src="{{ asset('img/ayuda/eliminar_cliente.gif') }}" alt="Eliminar cliente"/>
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
</div>

@endsection