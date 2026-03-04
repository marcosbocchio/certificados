@extends('layouts.enod.master')

@section('contenido')

<div class="ayuda_enod">
    <div class="ayuda_panel">
        <h1>Gestionar medidas</h1>
        <p>
            Esta pantalla se usa para registrar y mantener actualizadas las medidas del sistema.
            Cada medida puede vincularse a una unidad de medida y despues reutilizarse en productos, servicios o informes.
        </p>
    </div>

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Como usar el listado</h2>
            <p>
                Al ingresar a la seccion se muestra una grilla con las medidas registradas. El listado permite revisar
                codigo, descripcion y unidad de medida asociada.
            </p>
            <div class="ayuda_media">
                <img class="img-responsive" src="{{ asset('img/ayuda/medidas/Listado_medidas.PNG') }}" alt="Listado de medidas" />
            </div>
            <p>
                Desde las acciones del listado se puede editar una medida o eliminarla, segun los permisos disponibles.
            </p>
        </div>
    </section>

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Crear o editar una medida</h2>
            <p>
                Para dar de alta una medida debe usarse el boton <strong>Nuevo</strong>. El formulario permite cargar
                codigo, descripcion y la unidad de medida correspondiente.
            </p>
            <div class="ayuda_media">
                <img class="img-responsive" src="{{ asset('img/ayuda/medidas/Formulario_nueva_medida.PNG') }}" alt="Alta de medida" />
            </div>
            <p>
                Al editar una medida se abre el mismo formulario con la informacion existente para actualizar los datos.
            </p>
            <div class="ayuda_media">
                <img class="img-responsive" src="{{ asset('img/ayuda/medidas/Formulario_editar_medida.PNG') }}" alt="Edicion de medida" />
            </div>
        </div>
    </section>

    <section class="ayuda_section">
        <div class="ayuda_panel detalle_iconos">
            <h2>Importante</h2>
            <p><img class="img-responsive" src="{{ asset('img/ayuda/usuarios/Icono_editar_usuario.PNG') }}" alt="Editar medida" /> Permite modificar la informacion de la medida seleccionada.</p>
            <p><img class="img-responsive" src="{{ asset('img/ayuda/usuarios/Icono_eliminar_usuario.PNG') }}" alt="Eliminar medida" /> Permite eliminar el registro, previa confirmacion.</p>
            <p>
                Conviene revisar que la unidad de medida elegida sea la correcta, porque despues impacta en productos,
                remitos, certificados y otros modulos.
            </p>
            <h3>Articulos relacionados</h3>
            <ul class="ayuda_links">
                <li><a href="{{ route('ayuda-gestion-unidades-de-medida') }}">Gestionar unidades de medida</a></li>
                <li><a href="{{ route('ayuda-gestion-productos') }}">Gestionar productos</a></li>
                <li><a href="{{ route('ayuda-gestion-servicios') }}">Gestionar servicios</a></li>
            </ul>
        </div>
    </section>
</div>

@endsection
