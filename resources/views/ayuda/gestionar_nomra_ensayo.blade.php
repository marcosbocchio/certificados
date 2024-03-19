@extends('layouts.enod.master')

@section('contenido')

<div class="ayuda_enod">
    <div class="row">
        <div class="col-sm-12">
            <h4>Gestionar Normas de Ensayos</h4>
            <p>La gestión de Normas de Ensayos es crucial para asegurar que los procedimientos y productos cumplan con los estándares de calidad requeridos. A continuación, se detallan los pasos para añadir, editar y eliminar normas de ensayos en la plataforma:</p>
            <ol>
                <li>Accede a <strong>Maestros > Normas Ensayos</strong> desde el panel lateral izquierdo.</li>
                <li>Para agregar una nueva norma, haz clic en el botón <strong>'Nuevo'</strong>. Esto te permitirá introducir la información relevante de la norma.</li>
                <li>Completa los campos de <strong>código</strong> y <strong>descripción</strong> para la nueva norma. Estos detalles ayudan a identificarla adecuadamente dentro del sistema.</li>
                <li>Después de llenar la información, presiona <strong>'Guardar'</strong> para registrar la norma.</li>
            </ol>
            <p>Revisa el siguiente video para ver cómo se agrega una nueva norma de ensayo:</p>
        </div>

        <!-- Incluir GIF de creación de norma de ensayo -->
        <div class="col-md-6 col-md-offset-3">
            <img class="img-responsive" src="{{ asset('img/ayuda/crear_norma_ensayo.gif') }}" alt="Crear norma de ensayo"/>
        </div>

        <div class="col-sm-12">
            <h4>Editar una Norma de Ensayo</h4>
            <p>Modificar la información de una norma de ensayo es un proceso simple:</p>
            <ol>
                <li>En la lista de normas, ubica la que deseas editar y haz clic en el ícono de edición <img src="{{ asset('img/ayuda/Boton_editar.PNG') }}" alt="Icono de editar"> al final de la fila.</li>
                <li>Realiza los cambios necesarios en los campos de código y descripción.</li>
                <li>Para concluir, selecciona <strong>'Guardar'</strong> y actualiza la información de la norma.</li>
            </ol>
            <p>Este video muestra el procedimiento para editar una norma de ensayo:</p>
        </div>

        <!-- Incluir GIF de edición de norma de ensayo -->
        <div class="col-md-6 col-md-offset-3">
            <img class="img-responsive" src="{{ asset('img/ayuda/editar_norma_ensayo.gif') }}" alt="Editar norma de ensayo"/>
        </div>

        <div class="col-sm-12">
            <h4>Eliminar una Norma de Ensayo</h4>
            <p>Si es necesario eliminar una norma de ensayo, sigue estos pasos:</p>
            <ol>
                <li>Localiza la norma de ensayo que quieres eliminar en la tabla y haz clic en el ícono de eliminar <img src="{{ asset('img/ayuda/boton_borrado.PNG') }}" alt="Icono de eliminar"> al final de la fila.</li>
                <li>Confirma tu decisión para proceder con la eliminación. Recuerda, esta acción es definitiva y no se puede revertir.</li>
            </ol>
        </div>

        <!-- Incluir GIF de eliminación de norma de ensayo -->
        <div class="col-md-6 col-md-offset-3">
            <img class="img-responsive" src="{{ asset('img/ayuda/eliminar_norma_ensayo.gif') }}" alt="Eliminar norma de ensayo"/>
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