@extends('layouts.enod.master')

@section('contenido')

<div class="ayuda_enod">
    <div class="ayuda_panel">
        <h1>Gestionar internos de equipos</h1>
        <p>
            Esta pantalla se usa para registrar las unidades fisicas de cada equipo.
            A diferencia del maestro de equipos, aqui se carga cada interno con su numero de serie, numero interno, estado y datos propios.
        </p>
    </div>

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Como usar el listado</h2>
            <p>
                Al ingresar a la seccion se muestra una grilla con los internos registrados. El listado permite revisar numero interno,
                equipo asociado, metodo, fuente asignada, actividad, ubicacion y estado.
            </p>
            <div class="ayuda_media">
                <img class="img-responsive" src="{{ asset('img/ayuda/interno_equipos/Listado_interno_equipos.PNG') }}" alt="Listado de internos de equipos" />
            </div>
            <p>
                Puede filtrarse por activos y usar el buscador para localizar rapidamente un interno.
            </p>
        </div>
    </section>

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Crear o editar un interno</h2>
            <p>
                Para dar de alta un interno debe usarse el boton <strong>Nuevo</strong>. El formulario permite cargar numero de serie,
                numero interno, equipo, estado y otros campos segun el tipo de equipo seleccionado.
            </p>
            <div class="ayuda_media">
                <img class="img-responsive" src="{{ asset('img/ayuda/interno_equipos/Formulario_nuevo_interno_equipo_1.PNG') }}" alt="Alta de interno de equipo" />
            </div>
            <p>
                Segun el equipo elegido pueden habilitarse campos adicionales como fuente asignada, foco, voltaje, amperaje,
                probeta o dureza de calibracion.
            </p>
            <div class="ayuda_media">
                <img class="img-responsive" src="{{ asset('img/ayuda/interno_equipos/Formulario_nuevo_interno_equipo_2.PNG') }}" alt="Campos adicionales del interno de equipo" />
            </div>
            <p>
                Al crear un interno nuevo el sistema lo vincula a un frente inicial y registra su trazabilidad.
            </p>
        </div>
    </section>

    <section class="ayuda_section">
        <div class="ayuda_panel detalle_iconos">
            <h2>Importante</h2>
            <p><img class="img-responsive" src="{{ asset('img/ayuda/interno_equipos/Icono_historial_fuentes.PNG') }}" alt="Historial de fuentes" /> Permite consultar el historial de fuentes vinculadas al equipo.</p>
            <div class="ayuda_media">
                <img class="img-responsive" src="{{ asset('img/ayuda/interno_equipos/Modal_historial_fuentes.PNG') }}" alt="Historial de fuentes del interno de equipo" />
            </div>
            <p><img class="img-responsive" src="{{ asset('img/ayuda/usuarios/Icono_editar_usuario.PNG') }}" alt="Editar interno de equipo" /> Permite modificar la informacion del interno seleccionado.</p>
            <p><img class="img-responsive" src="{{ asset('img/ayuda/usuarios/Icono_eliminar_usuario.PNG') }}" alt="Dar de baja interno de equipo" /> Permite dar de baja o eliminar el registro, segun el caso.</p>
            <p>
                Conviene revisar bien el equipo asociado, la fuente asignada y el estado activo antes de guardar, porque esos datos
                despues impactan en informes, trazabilidad y disponibilidad operativa.
            </p>
            <h3>Articulos relacionados</h3>
            <ul class="ayuda_links">
                <li><a href="{{ route('ayuda-gestion-equipos') }}">Gestionar equipos</a></li>
                <li><a href="{{ route('ayuda-gestion-internofuente') }}">Gestionar internos de fuente</a></li>
                <li><a href="{{ route('ayuda-gestion-documentaciones') }}">Gestionar documentacion</a></li>
            </ul>
        </div>
    </section>
</div>

@endsection
