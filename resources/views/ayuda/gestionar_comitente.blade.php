@extends('layouts.enod.master')

@section('contenido')

<div class="ayuda_enod">
    <div class="row">
        <div class="col-sm-12">
            <h4>Gestionar Comitentes</h4>
            <p>La gestión de comitentes te permite administrar a los clientes o mandantes para los cuales tu empresa trabaja. A continuación, se detallan los pasos para gestionarlos eficientemente dentro de la plataforma:</p>
            <ol>
                <li>Para comenzar, accede al <strong>panel lateral izquierdo</strong> y selecciona <strong>Maestros > Comitente</strong>.</li>
                <li>Para añadir un nuevo comitente, haz clic en el botón <strong>'Nuevo'</strong>. Esta acción te permitirá ingresar la información relevante del comitente.</li>
                <li>Tienes la opción de agregar un logo para facilitar la identificación del comitente. Llena los campos requeridos con la información del nuevo comitente.</li>
                <li>Una vez que hayas ingresado toda la información necesaria, haz clic en <strong>'Guardar'</strong> para registrar al comitente en el sistema.</li>
            </ol>
            <p>Mira el siguiente video para ver cómo agregar un nuevo comitente:</p>
        </div>

        <!-- Incluir GIF de creación de comitente -->
        <div class="col-md-6 col-md-offset-3">
            <img class="img-responsive" src="{{ asset('img/ayuda/crear_comitente.gif') }}" alt="Crear comitente"/>
        </div>

        <div class="col-sm-12">
            <h4>Editar un Comitente</h4>
            <p>Para editar la información de un comitente existente:</p>
            <ol>
                <li>Encuentra al comitente que deseas editar en la tabla y haz clic en el ícono de edición, ubicado al final de la fila. <img class="icon-inline" src="{{ asset('img/ayuda/Boton_editar.PNG') }}" alt="Editar"></li>
                <li>Modifica la información del comitente según sea necesario.</li>
                <li>Para aplicar y guardar los cambios, haz clic en <strong>'Guardar'</strong>.</li>
            </ol>
            <p>Este video muestra cómo editar la información de un comitente:</p>
        </div>

        <!-- Incluir GIF de edición de comitente -->
        <div class="col-md-6 col-md-offset-3">
            <img class="img-responsive" src="{{ asset('img/ayuda/editar_comitente.gif') }}" alt="Editar comitente"/>
        </div>

        <div class="col-sm-12">
            <h4>Eliminar un Comitente</h4>
            <p>Para eliminar un comitente de la plataforma:</p>
            <ol>
                <li>Localiza al comitente que deseas eliminar en la tabla y haz clic en el ícono de eliminar, también situado al final de la fila. <img class="icon-inline" src="{{ asset('img/ayuda/boton_borrado.PNG') }}" alt="Eliminar"></li>
                <li>Confirma la acción seleccionando <strong>'Aceptar'</strong> en el mensaje de confirmación. Ten en cuenta que esta acción es irreversible y debe realizarse con precaución.</li>
            </ol>
        </div>

        <!-- Incluir GIF de eliminación de comitente -->
        <div class="col-md-6 col-md-offset-3">
            <img class="img-responsive" src="{{ asset('img/ayuda/eliminar_comitente.gif') }}" alt="Eliminar comitente"/>
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