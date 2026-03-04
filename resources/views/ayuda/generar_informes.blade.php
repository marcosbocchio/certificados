@extends('layouts.enod.master')

@section('contenido')

<div class="ayuda_enod">
    <div class="ayuda_panel">
        <h1>Creacion de informes</h1>
        <p>
            El modulo de informes permite registrar la evidencia tecnica del trabajo realizado en una OT.
            El sistema no ofrece cualquier informe de forma libre: habilita solo los metodos que se desprenden de los servicios cargados en esa OT.
        </p>
        <p>
            Segun el metodo elegido, el formulario puede pedir operadores, soldadores, procedimientos, tecnicas,
            plantas, placas, modelos o informacion adicional. Por eso conviene entrar a esta pantalla cuando la OT ya tiene
            bien definidos sus datos base.
        </p>
    </div>

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Antes de ingresar a informes</h2>
            <ul>
                <li><strong>Servicios:</strong> definen que metodos de ensayo se habilitan.</li>
                <li><strong>Operadores:</strong> suelen intervenir como ejecutores del ensayo.</li>
                <li><strong>Procedimientos:</strong> segun el metodo, pueden ser obligatorios para informar.</li>
                <li><strong>Soldadores y usuarios cliente:</strong> son especialmente relevantes en RI y en circuitos donde el cliente necesita acceso posterior.</li>
            </ul>
            <p>
                Si un metodo no aparece, lo primero a revisar es que la OT tenga cargado el servicio correspondiente y sus asignaciones basicas.
            </p>
        </div>
    </section>

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Metodos disponibles</h2>
            <p>El flujo comun concentra RI, PM, LP y US, pero la OT tambien puede habilitar otros metodos segun su configuracion.</p>
            <ul>
                <li>RI</li>
                <li>PM</li>
                <li>LP</li>
                <li>US</li>
                <li>TT</li>
                <li>CV</li>
                <li>DZ</li>
                <li>RG</li>
                <li>PMI</li>
                <li>RD</li>
            </ul>
            <p>Todos estos se enrutan desde un mismo punto de entrada y despues abren el formulario especifico de cada metodo.</p>
        </div>
    </section>

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Como trabajar en esta pantalla</h2>
            <p>Desde la OT seleccionada se ingresa al bloque de Informes y se trabaja sobre el listado de esa OT.</p>
            <div class="ayuda_media">
                <img src="{{ asset('img/ayuda/Generar_informe.gif') }}" class="img-responsive" alt="Acceso a informes" />
            </div>
            <p>En ese listado se ven los informes ya creados, su metodo, numero, revision, obra, usuario y fecha.</p>
            <div class="ayuda_media">
                <img src="{{ asset('img/ayuda/Listado_informes.PNG') }}" class="img-responsive" alt="Listado de informes" />
            </div>
        </div>
    </section>

    <section class="ayuda_section">
        <div class="ayuda_panel detalle_iconos">
            <h2>Acciones principales</h2>
            <p><img class="img-responsive" src="{{ asset('img/ayuda/Boton_editar.PNG') }}" alt="Editar informe" /> Editar un informe firmado no pisa la version anterior: genera una nueva revision.</p>
            <p><img class="img-responsive" src="{{ asset('img/ayuda/Boton_clonar.PNG') }}" alt="Clonar informe" /> Clonar acelera la carga cuando el siguiente informe repite buena parte del encabezado.</p>
            <p>
                <img class="img-responsive" src="{{ asset('img/ayuda/Boton_placa_diginal.PNG') }}" alt="Placa digital" />
                <img class="img-responsive" src="{{ asset('img/ayuda/Boton_us_digital.PNG') }}" alt="Modelo US" />
                Algunos metodos agregan material complementario, como placas digitalizadas o modelos US.
            </p>
            <p><img class="img-responsive" src="{{ asset('img/ayuda/Boton_pdf.PNG') }}" alt="PDF informe" /> Permite ver la revision actual en PDF.</p>
            <p><img class="img-responsive" src="{{ asset('img/ayuda/Boton_escaneados.PNG') }}" alt="Escaneados" /> Permite adjuntar documentacion escaneada relacionada con el informe.</p>
            <p>
                <img class="img-responsive" src="{{ asset('img/ayuda/Boton_firmar.PNG') }}" alt="Firmar informe" />
                <img class="img-responsive" src="{{ asset('img/ayuda/Boton_firmado.PNG') }}" alt="Informe firmado" />
                La firma cierra formalmente la revision actual.
            </p>
            <p><img class="img-responsive" src="{{ asset('img/ayuda/Boton_revisiones_anteriores.PNG') }}" alt="Revisiones" /> Se pueden consultar revisiones anteriores para trazabilidad.</p>
            <p>
                Para partes diarios, el sistema toma siempre la ultima revision disponible del informe, este firmada o no.
                Por eso revision y trazabilidad son conceptos centrales del modulo.
            </p>
        </div>
    </section>

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Importante</h2>
            <p>
                Al finalizar este proceso, la OT queda con informes tecnicos listos para consulta, PDF, revisiones posteriores
                y uso en otros modulos, especialmente partes diarios y reportes.
            </p>
            <h3>Articulos relacionados</h3>
            <ul class="ayuda_links">
                <li><a href="{{ route('ayuda-visualizar-informes') }}">Visualizacion de informes</a></li>
                <li><a href="{{ route('ayuda-asignar-operadores') }}">Asignar operadores</a></li>
                <li><a href="{{ route('ayuda-asignar-procedimientos') }}">Asignar procedimientos</a></li>
                <li><a href="{{ route('ayuda-asignar-soldadores-y-usuarios') }}">Asignar soldadores y usuarios de cliente</a></li>
                <li><a href="{{ route('ayuda-crear-parte-diario') }}">Creacion de partes diarios</a></li>
            </ul>
        </div>
    </section>
</div>

@endsection
