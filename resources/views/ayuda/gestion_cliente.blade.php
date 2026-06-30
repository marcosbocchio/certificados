@extends('layouts.enod.master')

@section('contenido')

<div id="app">
<div class="ayuda_enod">
    <div class="ayuda_panel">
        <h1>Gestionar clientes</h1>
        <p>
            Esta pantalla se usa para registrar y mantener actualizados los clientes del sistema.
            La informacion cargada aqui despues se utiliza en OT, usuarios cliente y documentacion asociada.
        </p>
    </div>
</div>

<section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Como usar el listado</h2>
            <p>
                Al ingresar a la seccion se muestra una grilla con los clientes registrados. Desde el buscador puede filtrarse por nombre,
                razon social, email u otros datos visibles.
            </p>
            
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
            
            <p>
                Entre los datos principales suelen completarse codigo, nombre, razon social, provincia, localidad, direccion,
                telefono, email y logo.
            </p>
            <p>
                En la seccion de <strong>Contacto</strong> pueden agregarse personas de referencia con nombre, cargo, telefono y email.
            </p>
            
            <p>
                Al editar un cliente se abre el mismo formulario con la informacion existente para actualizar datos o contactos.
            </p>
            
        </div>
    </section>

    <section class="ayuda_section">
        <div class="ayuda_panel detalle_iconos">
            <h2>Importante</h2>
            <p><strong>Permite modificar la informacion del cliente y sus contactos.</strong></p>
            <p><strong>Permite eliminar el cliente cuando no existan restricciones por registros asociados.</strong></p>
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
    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Ejemplo en pantalla</h2>
            <p>Asi se ve este maestro en el sistema. Probá el buscador y mirá los iconos de accion en cada fila.</p>
            <ayuda-demo-abm-tabla entidad="cliente"></ayuda-demo-abm-tabla>
            <ayuda-demo-abm-form entidad="cliente"></ayuda-demo-abm-form>
        </div>
    </section>
</div>
</div>

@endsection
