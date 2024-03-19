@extends('layouts.enod.master')

@section('contenido')

<div class="ayuda_enod">
    <div class="row">
        <div class="col-sm-12">
            <h4>Gestionar Materiales</h4>
            <p>Administrar los materiales es fundamental para mantener actualizada la lista de recursos disponibles para tus proyectos. A continuación, se describen los pasos para gestionar los materiales dentro de la plataforma:</p>
            <ol>
                <li>Navega al <strong>panel lateral izquierdo</strong> y selecciona <strong>Maestros > Materiales</strong>.</li>
                <li>Para ingresar un nuevo material, haz clic en el botón <strong>'Nuevo'</strong>.</li>
                <li>Introduce el <strong>código</strong> y la <strong>descripción</strong> del material. Estos datos ayudarán a identificarlo claramente dentro de la plataforma.</li>
                <li>Una vez completada la información, confirma la operación haciendo clic en <strong>'Guardar'</strong>.</li>
            </ol>
            <p>Consulta el siguiente video para ver cómo añadir un nuevo material:</p>
        </div>

        <!-- Incluir GIF de creación de material -->
        <div class="col-md-6 col-md-offset-3">
            <img class="img-responsive" src="{{ asset('img/ayuda/crear_material.gif') }}" alt="Crear material"/>
        </div>

        <div class="col-sm-12">
            <h4>Editar un Material</h4>
            <p>Modificar la información de un material es sencillo:</p>
            <ol>
                <li>Localiza el material que necesitas editar, ubicado al final de cada fila en la tabla, y haz clic en el ícono de edición <img src="{{ asset('img/ayuda/Boton_editar.PNG') }}" alt="Icono de editar">
.</li>
                <li>Ajusta el <strong>código</strong> o la <strong>descripción</strong> según sea necesario.</li>
                <li>Guarda los cambios seleccionando <strong>'Guardar'</strong>.</li>
            </ol>
            <p>Mira este video para entender cómo se edita la información de un material:</p>
        </div>

        <!-- Incluir GIF de edición de material -->
        <div class="col-md-6 col-md-offset-3">
            <img class="img-responsive" src="{{ asset('img/ayuda/editar_material.gif') }}" alt="Editar material"/>
        </div>

        <div class="col-sm-12">
            <h4>Eliminar un Material</h4>
            <p>Si necesitas eliminar un material, simplemente sigue estos pasos:</p>
            <ol>
                <li>En la tabla, busca el material que deseas eliminar y haz clic en el ícono de eliminar <img src="{{ asset('img/ayuda/boton_borrado.PNG') }}" alt="Icono de eliminar">
, ubicado también al final de la fila.</li>
                <li>Confirma la eliminación cuando se te solicite, teniendo en cuenta que esta acción es definitiva y no puede deshacerse.</li>
            </ol>
        </div>

        <!-- Incluir GIF de eliminación de material -->
        <div class="col-md-6 col-md-offset-3">
            <img class="img-responsive" src="{{ asset('img/ayuda/eliminar_material.gif') }}" alt="Eliminar material"/>
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