@extends('layouts.enod.master')

@section('contenido')

<div class="ayuda_enod">
    <div class="ayuda_panel">
        <h1>Visualizacion de informes</h1>
        <p>
            Esta pantalla concentra todos los informes de una OT y permite revisar rapidamente el avance documental del trabajo.
            Cada fila representa un informe tecnico con su metodo, numero, revision, obra y fecha.
        </p>
    </div>

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Como leer el listado</h2>
            <p>
                El listado se arma por OT y permite buscar por numero u otros datos visibles.
                Tambien muestra el numero de revision, que es clave para entender si el informe tuvo correcciones posteriores.
            </p>
            <div class="ayuda_media">
                <img src="{{ asset('img/ayuda/Listado_informes.PNG') }}" class="img-responsive" alt="Listado de informes" />
            </div>
            <ul>
                <li><strong>Tipo:</strong> metodo de ensayo del informe.</li>
                <li><strong>Numero:</strong> identificador del informe.</li>
                <li><strong>N rev:</strong> revision actual disponible.</li>
                <li><strong>Obra:</strong> obra o sector al que refiere.</li>
                <li><strong>Usuario alta y fecha:</strong> trazabilidad de generacion.</li>
            </ul>
        </div>
    </section>

    <section class="ayuda_section">
        <div class="ayuda_panel detalle_iconos">
            <h2>Acciones desde el listado</h2>
            <p><img class="img-responsive" src="{{ asset('img/ayuda/Boton_pdf.PNG') }}" alt="PDF" /> Abre el PDF de la revision actual.</p>
            <p><img class="img-responsive" src="{{ asset('img/ayuda/Boton_editar.PNG') }}" alt="Editar" /> Reabre el informe para corregir o continuar la carga. Si la revision ya esta firmada, la edicion genera una nueva revision.</p>
            <p><img class="img-responsive" src="{{ asset('img/ayuda/Boton_clonar.PNG') }}" alt="Clonar" /> Replica el encabezado para agilizar informes similares.</p>
            <p><img class="img-responsive" src="{{ asset('img/ayuda/Boton_revisiones_anteriores.PNG') }}" alt="Revisiones" /> Permite consultar el historial documental del mismo informe.</p>
            <p><img class="img-responsive" src="{{ asset('img/ayuda/Boton_escaneados.PNG') }}" alt="Escaneados" /> Da acceso a documentos escaneados vinculados.</p>
        </div>
    </section>

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Importante</h2>
            <ul>
                <li>Para revisar si una OT ya tiene toda su documentacion tecnica cargada.</li>
                <li>Para identificar que metodo o revision esta vigente.</li>
                <li>Para abrir el PDF correcto antes de emitir o compartir documentacion.</li>
                <li>Para detectar informes pendientes de incluir en partes diarios.</li>
            </ul>
            <h3>Articulos relacionados</h3>
            <ul class="ayuda_links">
                <li><a href="{{ route('ayuda-generar-informes') }}">Creacion de informes</a></li>
                <li><a href="{{ route('ayuda-crear-parte-diario') }}">Creacion de partes diarios</a></li>
                <li><a href="{{ route('ayuda-visualizar-ot') }}">Visualizacion general de la OT</a></li>
            </ul>
        </div>
    </section>
</div>

@endsection
