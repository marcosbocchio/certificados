@extends('layouts.enod.master')

@section('contenido')

<div class="ayuda_enod">
    <div class="ayuda_panel">
        <h1>Gestionar unidades de medida</h1>
        <p>
            Esta pantalla se usa para registrar y mantener actualizadas las unidades de medida del sistema.
            Las unidades cargadas aqui despues pueden reutilizarse en medidas, productos, servicios y otros registros.
        </p>
    </div>

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Como usar el listado</h2>
            <p>
                Al ingresar a la seccion se muestra una grilla con las unidades registradas. El listado permite revisar
                codigo y descripcion.
            </p>
            <div class="ayuda_media">
                <img class="img-responsive" src="{{ asset('img/ayuda/unidades_medida/Listado_unidades_medida.PNG') }}" alt="Listado de unidades de medida" />
            </div>
            <p>
                Desde las acciones del listado se puede editar una unidad o eliminarla, segun los permisos disponibles.
            </p>
        </div>
    </section>

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Crear o editar una unidad</h2>
            <p>
                Para dar de alta una unidad de medida debe usarse el boton <strong>Nuevo</strong>. El formulario permite cargar
                codigo y descripcion.
            </p>
            <div class="ayuda_media">
                <img class="img-responsive" src="{{ asset('img/ayuda/unidades_medida/Formulario_nueva_unidad_medida.PNG') }}" alt="Alta de unidad de medida" />
            </div>
            <p>
                Al editar una unidad se abre el mismo formulario con la informacion existente para actualizar los datos.
            </p>
            <div class="ayuda_media">
                <img class="img-responsive" src="{{ asset('img/ayuda/unidades_medida/Formulario_editar_unidad_medida.PNG') }}" alt="Edicion de unidad de medida" />
            </div>
        </div>
    </section>

    <section class="ayuda_section">
        <div class="ayuda_panel detalle_iconos">
            <h2>Importante</h2>
            <p><img class="img-responsive" src="{{ asset('img/ayuda/usuarios/Icono_editar_usuario.PNG') }}" alt="Editar unidad de medida" /> Permite modificar la informacion de la unidad seleccionada.</p>
            <p><img class="img-responsive" src="{{ asset('img/ayuda/usuarios/Icono_eliminar_usuario.PNG') }}" alt="Eliminar unidad de medida" /> Permite eliminar el registro, previa confirmacion.</p>
            <p>
                Conviene mantener codigos y descripciones normalizados para evitar duplicados y facilitar su reutilizacion
                en medidas, productos y servicios.
            </p>
            <h3>Articulos relacionados</h3>
            <ul class="ayuda_links">
                <li><a href="{{ route('ayuda-gestion-medidas') }}">Gestionar medidas</a></li>
                <li><a href="{{ route('ayuda-gestion-productos') }}">Gestionar productos</a></li>
                <li><a href="{{ route('ayuda-gestion-servicios') }}">Gestionar servicios</a></li>
            </ul>
        </div>
    </section>
</div>

@endsection
