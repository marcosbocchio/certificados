@extends('layouts.enod.master')

@section('contenido')

<div class="ayuda_enod">
    <div class="ayuda_panel">
        <h1>Gestionar usuarios</h1>
        <p>
            Esta pantalla permite crear, editar y administrar los usuarios del sistema.
            Desde aqui tambien pueden revisarse roles, estados de acceso y opciones vinculadas al perfil de cada usuario.
        </p>
    </div>

    @include('ayuda.partials.functional_summary')

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Como usar el listado</h2>
            <p>
                Al ingresar a la seccion se muestra una grilla con los usuarios registrados y un buscador para localizar rapidamente
                un nombre, email o dato asociado.
            </p>
            <div class="ayuda_media">
                <img class="img-responsive" src="{{ asset('img/ayuda/usuarios/empresa_usuarios.gif') }}" alt="Listado de usuarios" />
            </div>
            <p>
                Desde las acciones del listado se puede editar un usuario, revisar su asignacion de EPP o eliminarlo, segun los permisos disponibles.
            </p>
        </div>
    </section>

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Crear o editar un usuario</h2>
            <p>
                Para dar de alta un nuevo usuario debe usarse el boton <strong>Nuevo</strong>. El formulario cambia segun el tipo de usuario
                seleccionado, por ejemplo usuarios internos o usuarios cliente.
            </p>
            <div class="ayuda_media">
                <img class="img-responsive" src="{{ asset('img/ayuda/usuarios/empresa_nuevo_usuario.gif') }}" alt="Alta de usuario interno" />
            </div>
            <p>
                En usuarios internos se cargan datos como nombre, DNI, email, contrasena, firma digital y configuraciones adicionales.
                En usuarios cliente el formulario es mas simple y se vincula directamente con el cliente correspondiente.
            </p>
            <div class="ayuda_media">
                <img class="img-responsive" src="{{ asset('img/ayuda/usuarios/empresa_nuevo_cliente.gif') }}" alt="Alta de usuario cliente" />
            </div>
            <p>
                Al editar un usuario ya existente se abre el mismo formulario con los datos cargados para poder actualizarlos.
            </p>
            <div class="ayuda_media">
                <img class="img-responsive" src="{{ asset('img/ayuda/usuarios/empresa_editar_usuario.gif') }}" alt="Edicion de usuario" />
            </div>
        </div>
    </section>

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Articulos relacionados</h2>
            <ul class="ayuda_links">
                <li><a href="{{ route('ayuda-perfil') }}">Perfil de usuario</a></li>
                <li><a href="{{ route('ayuda-gestion-cliente') }}">Gestionar clientes</a></li>
                <li><a href="{{ route('ayuda-asignar-soldadores-y-usuarios') }}">Asignar soldadores y usuarios de cliente</a></li>
            </ul>
        </div>
    </section>
</div>

@endsection
