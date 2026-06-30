@extends('layouts.enod.master')

@section('contenido')

<div id="app">
<div class="ayuda_enod">
    <div class="ayuda_panel">
        <h1>Gestionar fuentes</h1>
        <p>
            Esta pantalla se usa para registrar y mantener actualizados los tipos de fuentes del sistema.
            La informacion cargada aqui despues se reutiliza en internos de fuente, documentacion y trazabilidad asociada.
        </p>
    </div>
</div>

<section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Como usar el listado</h2>
            <p>
                Al ingresar a la seccion se muestra una grilla con las fuentes registradas. Desde las acciones del listado
                se puede editar un registro existente o eliminarlo, segun los permisos disponibles.
            </p>
            
        </div>
    </section>

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Crear o editar una fuente</h2>
            <p>
                Para dar de alta una fuente debe usarse el boton <strong>Nuevo</strong>. El formulario permite cargar
                codigo, descripcion y la constante o vida media asociada.
            </p>
            
            <p>
                Al editar una fuente se abre el mismo formulario con la informacion existente para actualizar sus datos.
            </p>
            
        </div>
    </section>

    <section class="ayuda_section">
        <div class="ayuda_panel detalle_iconos">
            <h2>Importante</h2>
            <p><strong>Permite modificar la informacion de la fuente seleccionada.</strong></p>
            <p><strong>Permite eliminar el registro, previa confirmacion.</strong></p>
            <p>
                Si la fuente ya esta vinculada a internos o documentacion, puede ser necesario revisar esas relaciones antes de eliminarla.
            </p>
            <h3>Articulos relacionados</h3>
            <ul class="ayuda_links">
                <li><a href="{{ route('ayuda-gestion-internofuente') }}">Gestionar internos de fuente</a></li>
                <li><a href="{{ route('ayuda-gestion-documentaciones') }}">Gestionar documentacion</a></li>
                <li><a href="{{ route('ayuda-gestion-equipos') }}">Gestionar equipos</a></li>
            </ul>
        </div>
    </section>
    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Ejemplo en pantalla</h2>
            <p>Asi se ve este maestro en el sistema. Probá el buscador y mirá los iconos de accion en cada fila.</p>
            <ayuda-demo-abm-tabla entidad="fuente"></ayuda-demo-abm-tabla>
            <ayuda-demo-abm-form entidad="fuente"></ayuda-demo-abm-form>
        </div>
    </section>
</div>
</div>

@endsection
