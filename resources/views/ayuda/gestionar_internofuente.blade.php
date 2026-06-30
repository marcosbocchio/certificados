@extends('layouts.enod.master')

@section('contenido')

<div id="app">
<div class="ayuda_enod">
    <div class="ayuda_panel">
        <h1>Gestionar internos de fuente</h1>
        <p>
            Esta pantalla se usa para registrar las fuentes fisicas del sistema.
            A diferencia del maestro de fuentes, aqui se carga cada unidad con su numero de serie, fecha de evaluacion,
            actividad, foco y estado.
        </p>
    </div>
</div>

<section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Como usar el listado</h2>
            <p>
                Al ingresar a la seccion se muestra una grilla con los internos de fuente registrados. El listado permite revisar
                numero de serie, fuente asociada, actividad actual y estado activo.
            </p>
            
            <p>
                El sistema calcula y muestra la actividad actual a partir de la actividad inicial, la fecha de evaluacion y la fuente seleccionada.
            </p>
        </div>
    </section>

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Crear o editar un interno de fuente</h2>
            <p>
                Para dar de alta un interno de fuente debe usarse el boton <strong>Nuevo</strong>. El formulario permite cargar
                numero de serie, estado, fecha de evaluacion, actividad inicial, foco y tipo de fuente.
            </p>
            
            <p>
                Al editar un registro existente se abre el mismo formulario con la informacion cargada para actualizar los datos.
            </p>
            
            <p>
                En la edicion pueden mostrarse campos de actividad inicial y actividad actual para facilitar el control del estado de la fuente.
            </p>
        </div>
    </section>

    <section class="ayuda_section">
        <div class="ayuda_panel detalle_iconos">
            <h2>Importante</h2>
            <p><strong>Permite modificar la informacion del registro seleccionado.</strong></p>
            <p><strong>Permite dar de baja o eliminar el registro, segun el caso.</strong></p>
            <p>
                Conviene revisar bien fecha de evaluacion, actividad inicial y tipo de fuente antes de guardar, porque esos datos
                afectan el calculo posterior de la actividad actual.
            </p>
            <h3>Articulos relacionados</h3>
            <ul class="ayuda_links">
                <li><a href="{{ route('ayuda-gestion-fuentes') }}">Gestionar fuentes</a></li>
                <li><a href="{{ route('ayuda-gestion-internoequipos') }}">Gestionar internos de equipos</a></li>
                <li><a href="{{ route('ayuda-gestion-documentaciones') }}">Gestionar documentacion</a></li>
            </ul>
        </div>
    </section>
    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Ejemplo en pantalla</h2>
            <p>Asi se ve este maestro en el sistema. Probá el buscador y mirá los iconos de accion en cada fila.</p>
            <ayuda-demo-abm-tabla entidad="internofuente"></ayuda-demo-abm-tabla>
            <ayuda-demo-abm-form entidad="internofuente"></ayuda-demo-abm-form>
        </div>
    </section>
</div>
</div>

@endsection
