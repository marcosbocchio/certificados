@extends('layouts.enod.master')

@section('contenido')

<div class="ayuda_enod">
    <div class="ayuda_panel">
        <h1>Gestionar comitentes</h1>
        <p>
            Esta pantalla se usa para registrar y mantener actualizados los comitentes.
            La informacion cargada aqui puede reutilizarse despues en OT, certificados y otros documentos del sistema.
        </p>
    </div>

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Como usar el listado</h2>
            <p>
                Al ingresar a la seccion se muestra una grilla con los comitentes registrados. Desde las acciones del listado
                se puede editar un registro existente o eliminarlo, segun los permisos disponibles.
            </p>
            <div class="ayuda_media">
                <img class="img-responsive" src="{{ asset('img/ayuda/comitentes/Listado_comitentes.PNG') }}" alt="Listado de comitentes" />
            </div>
        </div>
    </section>

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Crear o editar un comitente</h2>
            <p>
                Para dar de alta un comitente debe usarse el boton <strong>Nuevo</strong>. El formulario permite cargar nombre,
                razon social y logo.
            </p>
            <div class="ayuda_media">
                <img class="img-responsive" src="{{ asset('img/ayuda/comitentes/Formulario_nuevo_comitente.PNG') }}" alt="Alta de comitente" />
            </div>
            <p>
                Al editar un comitente se abre el mismo formulario con la informacion existente para actualizar datos o reemplazar el logo.
            </p>
            <div class="ayuda_media">
                <img class="img-responsive" src="{{ asset('img/ayuda/comitentes/Formulario_editar_comitente.PNG') }}" alt="Edicion de comitente" />
            </div>
        </div>
    </section>

    <section class="ayuda_section">
        <div class="ayuda_panel detalle_iconos">
            <h2>Importante</h2>
            <p><img class="img-responsive" src="{{ asset('img/ayuda/usuarios/Icono_editar_usuario.PNG') }}" alt="Editar comitente" /> Permite modificar la informacion del comitente.</p>
            <p><img class="img-responsive" src="{{ asset('img/ayuda/usuarios/Icono_eliminar_usuario.PNG') }}" alt="Eliminar comitente" /> Permite eliminar el registro, previa confirmacion.</p>
            <div class="ayuda_media">
                <img class="img-responsive" src="{{ asset('img/ayuda/comitentes/Dialogo_eliminar_comitente.PNG') }}" alt="Confirmacion para eliminar comitente" />
            </div>
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
</div>

@endsection
