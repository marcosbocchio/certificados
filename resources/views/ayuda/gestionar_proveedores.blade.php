@extends('layouts.enod.master')

@section('contenido')

<div class="ayuda_enod">
    <div class="row">
        <div class="col-sm-12">
            <h4>Gestionar Proveedores</h4>
            <p>Para administrar los proveedores en la plataforma, sigue los siguientes pasos:</p>
            <ol>
                <li>Desde el panel lateral izquierdo, selecciona <strong>Maestros > Proveedores</strong>.</li>
                <li>A continuación, verás una tabla con los proveedores existentes. Para agregar un nuevo proveedor, haz clic en el botón <strong>'Nuevo'</strong> situado en la parte superior.</li>
                <li>Rellena los campos requeridos con los datos del nuevo proveedor.</li>
                <li>Para finalizar y registrar al proveedor en el sistema, haz clic en <strong>'Guardar'</strong>.</li>
            </ol>
            <p>Consulta el siguiente video para ver cómo se añade un nuevo proveedor:</p>
        </div>

        <!-- Incluir GIF de creación de proveedor -->
        <div class="col-md-6 col-md-offset-3">
            <img class="img-responsive" src="{{ asset('img/ayuda/crear_proveedor.gif') }}" alt="Crear proveedor"/>
        </div>

        <div class="col-sm-12">
            <h4>Editar un Proveedor</h4>
            <p>Si necesitas modificar la información de un proveedor:</p>
            <ol>
                <li>Dirígete al final de la tabla de proveedores y haz clic en el ícono de edición <img class="icon-inline" src="{{ asset('img/ayuda/Boton_editar.PNG') }}" alt="Editar"></li>
                <li>Edita la información necesaria en el formulario.</li>
                <li>Guarda los cambios clicando en <strong>'Guardar'</strong>.</li>
            </ol>
            <p>Este video ilustra el proceso para editar los datos de un proveedor:</p>
        </div>

        <!-- Incluir GIF de edición de proveedor -->
        <div class="col-md-6 col-md-offset-3">
            <img class="img-responsive" src="{{ asset('img/ayuda/editar_proveedor.gif') }}" alt="Editar proveedor"/>
        </div>

        <div class="col-sm-12">
            <h4>Eliminar un Proveedor</h4>
            <p>Para eliminar un proveedor de la plataforma:</p>
            <ol>
                <li>Encuentra al proveedor que deseas eliminar en la tabla y haz clic en el ícono de eliminar <img class="icon-inline" src="{{ asset('img/ayuda/boton_borrado.PNG') }}" alt="Eliminar"></li>
                <li>Confirma la acción seleccionando <strong>'Aceptar'</strong> en el diálogo de confirmación. Recuerda, esta acción es irreversible.</li>
            </ol>
        </div>

        <!-- Incluir GIF de eliminación de proveedor -->
        <div class="col-md-6 col-md-offset-3">
            <img class="img-responsive" src="{{ asset('img/ayuda/eliminar_proveedor.gif') }}" alt="Eliminar proveedor"/>
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