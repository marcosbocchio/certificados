@extends('layouts.enod.master')

@section('contenido')

<div id="app">
<div class="ayuda_enod">
    <div class="ayuda_panel">
        <h1>Gestionar usuarios</h1>
        <p>
            Esta pantalla permite crear, editar y administrar los usuarios del sistema.
            Desde aqui tambien pueden revisarse roles, estados de acceso y opciones vinculadas al perfil de cada usuario.
        </p>
    </div>
</div>

@include('ayuda.partials.functional_summary')

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Como usar el listado</h2>
            <p>
                Al ingresar a la seccion se muestra una grilla con los usuarios registrados y un buscador para localizar rapidamente
                un nombre, email o dato asociado.
            </p>
            
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
            
            <p>
                En usuarios internos se cargan datos como nombre, DNI, email, contrasena, firma digital y configuraciones adicionales.
                En usuarios cliente el formulario es mas simple y se vincula directamente con el cliente correspondiente.
            </p>
            
            <p>
                Al editar un usuario ya existente se abre el mismo formulario con los datos cargados para poder actualizarlos.
            </p>
            
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
    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Ejemplo en pantalla</h2>
            <p>Asi se ve este maestro en el sistema. Probá el buscador y mirá los iconos de accion en cada fila.</p>
            <ayuda-demo-abm-tabla entidad="usuario"></ayuda-demo-abm-tabla>
            <ayuda-demo-abm-form entidad="usuario"></ayuda-demo-abm-form>
        </div>
    </section>
</div>
</div>

@endsection
