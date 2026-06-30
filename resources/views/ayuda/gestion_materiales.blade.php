@extends('layouts.enod.master')

@section('contenido')

<div id="app">
<div class="ayuda_enod">
    <div class="ayuda_panel">
        <h1>Gestionar materiales</h1>
        <p>
            Esta pantalla se usa para registrar y mantener actualizados los materiales del sistema.
            La informacion cargada aqui despues puede reutilizarse en informes, procedimientos y otros registros tecnicos.
        </p>
    </div>
</div>

<section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Como usar el listado</h2>
            <p>
                Al ingresar a la seccion se muestra una grilla con los materiales registrados. El buscador permite localizar
                rapidamente un material por codigo o descripcion.
            </p>
            
            <p>
                Desde las acciones del listado se puede editar un material o eliminarlo, segun los permisos disponibles.
            </p>
        </div>
    </section>

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Crear o editar un material</h2>
            <p>
                Para dar de alta un material debe usarse el boton <strong>Nuevo</strong>. El formulario es simple y permite cargar
                codigo y descripcion.
            </p>
            
            <p>
                Al editar un material se abre el mismo formulario con la informacion existente para actualizar los datos.
            </p>
            
        </div>
    </section>

    <section class="ayuda_section">
        <div class="ayuda_panel detalle_iconos">
            <h2>Importante</h2>
            <p><strong>Permite modificar la informacion del material seleccionado.</strong></p>
            <p><strong>Permite eliminar el registro, previa confirmacion.</strong></p>
            <p>
                Conviene mantener los codigos y descripciones normalizados para evitar duplicados o variantes innecesarias
                en otros modulos del sistema.
            </p>
            <h3>Articulos relacionados</h3>
            <ul class="ayuda_links">
                <li><a href="{{ route('ayuda-generar-informes-ri') }}">Informes RI</a></li>
                <li><a href="{{ route('ayuda-generar-informes-us') }}">Informes US</a></li>
                <li><a href="{{ route('ayuda-gestion-documentaciones') }}">Gestionar documentacion</a></li>
            </ul>
        </div>
    </section>
    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Ejemplo en pantalla</h2>
            <p>Asi se ve este maestro en el sistema. Probá el buscador y mirá los iconos de accion en cada fila.</p>
            <ayuda-demo-abm-tabla entidad="material"></ayuda-demo-abm-tabla>
            <ayuda-demo-abm-form entidad="material"></ayuda-demo-abm-form>
        </div>
    </section>
</div>
</div>

@endsection
