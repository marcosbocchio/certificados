@extends('layouts.enod.master')

@section('contenido')

<div class="ayuda_enod">
    <div class="ayuda_panel">
        <h1>Visualizacion general de una orden de trabajo</h1>
        <p>
            La OT es el registro principal del trabajo operativo. Desde esta pantalla se puede revisar la informacion general
            de cada orden y entrar a los modulos asociados.
        </p>
        <p>
            El listado principal muestra solo la informacion que el usuario puede consultar. Un usuario cliente no ve cualquier
            OT del sistema: solo accede a las que le fueron asociadas.
        </p>
    </div>

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Que se ve en el listado</h2>
            <p>
                Las OT se listan en orden descendente de alta. Desde esta pantalla se puede identificar rapidamente
                el cliente, la fecha, el estado y las acciones disponibles sobre cada registro.
            </p>
            <div class="ayuda_media">
                <img src="{{ asset('img/ayuda/Listado_OT.PNG') }}" class="img-responsive" alt="Listado de ordenes de trabajo" />
            </div>
            <h3>Estados de la OT</h3>
            <ul>
                <li><strong>Editando:</strong> la OT todavia puede ajustarse antes de quedar formalmente activa.</li>
                <li><strong>Activa:</strong> la OT ya fue firmada y habilita el circuito operativo normal.</li>
                <li><strong>Cerrada:</strong> la OT ya no sigue en proceso operativo y queda como antecedente consultable.</li>
            </ul>
        </div>
    </section>

    <section class="ayuda_section">
        <div class="ayuda_panel detalle_iconos">
            <h2>Botones y acciones disponibles</h2>
            <p>Desde el listado y desde la barra superior de modulos se accede al resto del circuito documental.</p>
            <p><img class="img-responsive" src="{{ asset('img/ayuda/Boton_editar.PNG') }}" alt="Editar" /> Permite modificar los datos generales de la OT mientras el usuario tenga permisos.</p>
            <p><img class="img-responsive" src="{{ asset('img/ayuda/Boton_usuarios.PNG') }}" alt="Usuarios" /> Abre la asignacion de usuarios cliente y soldadores asociados.</p>
            <p><img class="img-responsive" src="{{ asset('img/ayuda/Boton_pdf.PNG') }}" alt="PDF OT" /> Genera o visualiza el PDF de la OT.</p>
            <p>
                <img class="img-responsive" src="{{ asset('img/ayuda/Boton_firmar.PNG') }}" alt="Firmar OT" />
                <img class="img-responsive" src="{{ asset('img/ayuda/Boton_ot_activa.PNG') }}" alt="OT activa" />
                <img class="img-responsive" src="{{ asset('img/ayuda/Boton_ot_cerrada.PNG') }}" alt="OT cerrada" />
                La firma cambia la OT a estado activa. Cuando el trabajo termina, puede cerrarse para dejar el circuito concluido.
            </p>
            <div class="ayuda_media">
                <img src="{{ asset('img/ayuda/Tablero_iconos_grandes.PNG') }}" class="img-responsive" alt="Accesos de la OT" />
            </div>
            <ul>
                <li><strong>Operadores:</strong> documentacion y personal operativo vinculado a la OT.</li>
                <li><strong>Equipos / fuentes:</strong> internos, trazabilidad y documentacion tecnica asociada.</li>
                <li><strong>Procedimientos:</strong> procedimientos propios o del cliente necesarios para informar.</li>
                <li><strong>Vehiculos / documentacion:</strong> vehiculos asignados y soporte documental complementario.</li>
                <li><strong>Remitos:</strong> movimiento de productos o equipos entre frentes.</li>
                <li><strong>Informes:</strong> registro tecnico por metodo de ensayo.</li>
                <li><strong>Partes:</strong> consolidacion diaria de la actividad de la OT.</li>
                <li><strong>Certificados:</strong> documento final armado a partir de partes ya registrados.</li>
            </ul>
        </div>
    </section>

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Importante</h2>
            <p>La OT se relaciona con cliente, contactos, ubicacion, responsable y otros datos tecnicos que despues se usan en el resto del circuito.</p>
            <ul>
                <li>Cliente y datos de contacto.</li>
                <li>Servicios que despues habilitan metodos e informes.</li>
                <li>Productos, EPP y riesgos si forman parte del alcance.</li>
                <li>Responsable de OT y ubicacion de obra.</li>
            </ul>
            <p>
                Cuanto mejor quede definida la OT al inicio, mas ordenado sera despues el trabajo en informes, partes,
                certificados y remitos.
            </p>
        </div>
    </section>

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Articulos relacionados</h2>
            <ul class="ayuda_links">
                <li><a href="{{ route('ayuda-crear-ot') }}">Como crear una OT</a></li>
                <li><a href="{{ route('ayuda-visualizar-doc-operadores') }}">Visualizar documentacion de operadores</a></li>
                <li><a href="{{ route('ayuda-visualizar-procedimientos') }}">Visualizar procedimientos asignados</a></li>
                <li><a href="{{ route('ayuda-visualizar-vehiculos') }}">Visualizar vehiculos y documentacion complementaria</a></li>
                <li><a href="{{ route('ayuda-visualizar-informes') }}">Visualizar informes de la OT</a></li>
                <li><a href="{{ route('ayuda-visualizar-parte-diario') }}">Visualizar partes diarios</a></li>
                <li><a href="{{ route('ayuda-visualizar-certificados') }}">Visualizar certificados</a></li>
                <li><a href="{{ route('ayuda-creacion-remito') }}">Remitos</a></li>
            </ul>
        </div>
    </section>
</div>

@endsection
