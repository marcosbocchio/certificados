@extends('layouts.enod.master')

@section('contenido')

<div class="ayuda_enod">
    <div class="ayuda_panel">
        <h1>Gestionar equipos</h1>
        <p>
            Esta pantalla se usa para registrar y mantener actualizados los equipos del sistema.
            La informacion cargada aqui despues se reutiliza en informes, internos de equipos y documentacion asociada.
        </p>
    </div>

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Como usar el listado</h2>
            <p>
                Al ingresar a la seccion se muestra una grilla con los equipos registrados. El buscador permite localizar
                rapidamente un equipo por codigo, descripcion o datos relacionados.
            </p>
            <div class="ayuda_media">
                <img class="img-responsive" src="{{ asset('img/ayuda/equipos/Listado_equipos.PNG') }}" alt="Listado de equipos" />
            </div>
            <p>
                Desde las acciones del listado se puede editar un equipo o eliminarlo, segun los permisos disponibles.
            </p>
        </div>
    </section>

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Crear o editar un equipo</h2>
            <p>
                Para dar de alta un equipo debe usarse el boton <strong>Nuevo</strong>. El formulario permite cargar
                codigo, descripcion, metodo de ensayo, tipo de equipamiento e instrumento de medicion.
            </p>
            <div class="ayuda_media">
                <img class="img-responsive" src="{{ asset('img/ayuda/equipos/Formulario_nuevo_equipo.PNG') }}" alt="Alta de equipo" />
            </div>
            <p>
                Si el equipo corresponde al metodo <strong>US</strong>, el sistema tambien permite marcarlo como palpador.
            </p>
            <p>
                Al editar un equipo se abre el mismo formulario con la informacion existente para actualizar sus datos.
            </p>
            <div class="ayuda_media">
                <img class="img-responsive" src="{{ asset('img/ayuda/equipos/Formulario_editar_equipo.PNG') }}" alt="Edicion de equipo" />
            </div>
        </div>
    </section>

    <section class="ayuda_section">
        <div class="ayuda_panel detalle_iconos">
            <h2>Importante</h2>
            <p><img class="img-responsive" src="{{ asset('img/ayuda/usuarios/Icono_editar_usuario.PNG') }}" alt="Editar equipo" /> Permite modificar la informacion del equipo seleccionado.</p>
            <p><img class="img-responsive" src="{{ asset('img/ayuda/usuarios/Icono_eliminar_usuario.PNG') }}" alt="Eliminar equipo" /> Permite eliminar el registro, previa confirmacion.</p>
            <p>
                Conviene revisar bien el metodo de ensayo y el tipo de equipamiento antes de guardar, porque esos datos despues
                afectan las selecciones disponibles en informes y otros modulos.
            </p>
            <h3>Articulos relacionados</h3>
            <ul class="ayuda_links">
                <li><a href="{{ route('ayuda-gestion-internoequipos') }}">Gestionar internos de equipos</a></li>
                <li><a href="{{ route('ayuda-gestion-documentaciones') }}">Gestionar documentacion</a></li>
                <li><a href="{{ route('ayuda-generar-informes') }}">Creacion de informes</a></li>
            </ul>
        </div>
    </section>
</div>

@endsection
