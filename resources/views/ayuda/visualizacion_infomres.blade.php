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
        <div class="ayuda_panel">
            <h2>Cuando conviene revisar esta pantalla</h2>
            <ul>
                <li>Cuando se necesita confirmar si un metodo ya fue documentado dentro de la OT.</li>
                <li>Cuando se quiere saber que revision esta vigente antes de abrir el PDF o seguir con partes diarios.</li>
                <li>Cuando hace falta revisar antecedentes o detectar si un informe fue corregido mas de una vez.</li>
                <li>Cuando se prepara una consolidacion posterior y se necesita saber que informes siguen pendientes o utilizables.</li>
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
            <h2>Que conviene revisar</h2>
            <ul>
                <li>Que el PDF que se abra corresponda a la revision vigente y no a una version previa.</li>
                <li>Que los informes necesarios para la jornada ya esten disponibles antes de crear partes.</li>
                <li>Que una eventual edicion no arrastre una revision equivocada al circuito posterior.</li>
                <li>Que los documentos escaneados o antecedentes necesarios esten accesibles cuando el caso lo requiera.</li>
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
