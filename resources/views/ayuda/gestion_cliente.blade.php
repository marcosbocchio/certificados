@extends('layouts.enod.master')

@section('contenido')

<div class="ayuda_enod">
    <div class="ayuda_panel">
        <h1>Gestionar clientes</h1>
        <p>
            Esta pantalla se usa para registrar y mantener actualizados los clientes del sistema.
            La informacion cargada aqui despues se utiliza en OT, usuarios cliente y documentacion asociada.
        </p>
    </div>

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Como usar el listado</h2>
            <p>
                Al ingresar a la seccion se muestra una grilla con los clientes registrados. Desde el buscador puede filtrarse por nombre,
                razon social, email u otros datos visibles.
            </p>
            <div class="ayuda_media">
                <img class="img-responsive" src="{{ asset('img/ayuda/clientes/Listado_clientes.PNG') }}" alt="Listado de clientes" />
            </div>
            <p>
                Desde las acciones del listado se puede editar un cliente o eliminarlo, segun los permisos disponibles.
            </p>
        </div>
    </section>

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Crear o editar un cliente</h2>
            <p>
                Para dar de alta un cliente debe usarse el boton <strong>Nuevo</strong>. El formulario permite cargar datos generales
                del cliente y uno o mas contactos.
            </p>
            <div class="ayuda_media">
                <img class="img-responsive" src="{{ asset('img/ayuda/clientes/Formulario_nuevo_cliente.PNG') }}" alt="Formulario de alta de cliente" />
            </div>
            <p>
                Entre los datos principales suelen completarse codigo, nombre, razon social, provincia, localidad, direccion,
                telefono, email y logo.
            </p>
            <p>
                En la seccion de <strong>Contacto</strong> pueden agregarse personas de referencia con nombre, cargo, telefono y email.
            </p>
            <div class="ayuda_media">
                <img class="img-responsive" src="{{ asset('img/ayuda/clientes/Formulario_nuevo_cliente_contacto.PNG') }}" alt="Contactos del cliente" />
            </div>
            <p>
                Al editar un cliente se abre el mismo formulario con la informacion existente para actualizar datos o contactos.
            </p>
            <div class="ayuda_media">
                <img class="img-responsive" src="{{ asset('img/ayuda/clientes/Formulario_editar_cliente.PNG') }}" alt="Edicion de cliente" />
            </div>
        </div>
    </section>

    <section class="ayuda_section">
        <div class="ayuda_panel detalle_iconos">
            <h2>Importante</h2>
            <p><img class="img-responsive" src="{{ asset('img/ayuda/usuarios/Icono_editar_usuario.PNG') }}" alt="Editar cliente" /> Permite modificar la informacion del cliente y sus contactos.</p>
            <p><img class="img-responsive" src="{{ asset('img/ayuda/usuarios/Icono_eliminar_usuario.PNG') }}" alt="Eliminar cliente" /> Permite eliminar el cliente cuando no existan restricciones por registros asociados.</p>
            <p>
                Conviene mantener actualizados los datos de contacto porque despues pueden reutilizarse en OT, usuarios cliente
                y otros documentos del sistema.
            </p>
            <h3>Articulos relacionados</h3>
            <ul class="ayuda_links">
                <li><a href="{{ route('ayuda-crear-ot') }}">Como crear una orden de trabajo (OT)</a></li>
                <li><a href="{{ route('ayuda-gestion-usuario') }}">Gestionar usuarios</a></li>
                <li><a href="{{ route('ayuda-visualizar-ot') }}">Visualizacion general de una OT</a></li>
            </ul>
        </div>
    </section>
</div>

@endsection
