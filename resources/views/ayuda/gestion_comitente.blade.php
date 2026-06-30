@extends('layouts.enod.master')

@section('contenido')

<div id="app">
<div class="ayuda_enod">
    <div class="ayuda_panel">
        <h1>Gestionar comitentes</h1>
        <p>
            Esta pantalla se usa para registrar y mantener actualizados los comitentes.
            La informacion cargada aqui puede reutilizarse despues en OT, certificados y otros documentos del sistema.
        </p>
    </div>
</div>

<section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Como usar el listado</h2>
            <p>
                Al ingresar a la seccion se muestra una grilla con los comitentes registrados. Desde las acciones del listado
                se puede editar un registro existente o eliminarlo, segun los permisos disponibles.
            </p>
            
        </div>
    </section>

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Crear o editar un comitente</h2>
            <p>
                Para dar de alta un comitente debe usarse el boton <strong>Nuevo</strong>. El formulario permite cargar nombre,
                razon social y logo.
            </p>
            
            <p>
                Al editar un comitente se abre el mismo formulario con la informacion existente para actualizar datos o reemplazar el logo.
            </p>
            
        </div>
    </section>

    <section class="ayuda_section">
        <div class="ayuda_panel detalle_iconos">
            <h2>Importante</h2>
            <p><strong>Permite modificar la informacion del comitente.</strong></p>
            <p><strong>Permite eliminar el registro, previa confirmacion.</strong></p>
            
            <p>
                Si el comitente ya esta vinculado a otros registros, el sistema puede impedir su eliminacion o requerir una revision previa.
            </p>
            <h3>Articulos relacionados</h3>
            <ul class="ayuda_links">
                <li><a href="{{ route('ayuda-gestion-cliente') }}">Gestionar clientes</a></li>
                <li><a href="{{ route('ayuda-crear-ot') }}">Como crear una orden de trabajo (OT)</a></li>
                <li><a href="{{ route('ayuda-visualizar-ot') }}">Visualizacion general de una OT</a></li>
            </ul>
        </div>
    </section>
    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Ejemplo en pantalla</h2>
            <p>Asi se ve este maestro en el sistema. Probá el buscador y mirá los iconos de accion en cada fila.</p>
            <ayuda-demo-abm-tabla entidad="comitente"></ayuda-demo-abm-tabla>
            <ayuda-demo-abm-form entidad="comitente"></ayuda-demo-abm-form>
        </div>
    </section>
</div>
</div>

@endsection
