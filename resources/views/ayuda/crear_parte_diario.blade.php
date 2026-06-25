@extends('layouts.enod.master')

@section('contenido')

<div id="app">
<div class="ayuda_enod">
    <div class="ayuda_panel">
        <h1>Creacion de partes diarios</h1>
        <p>
            El parte diario consolida lo ejecutado en una jornada para una OT. No reemplaza al informe tecnico:
            toma los informes disponibles, agrega responsables, servicios, vehiculos y observaciones, y deja una salida diaria formal.
        </p>
    </div>

    @include('ayuda.partials.functional_summary')

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Antes de crear un parte</h2>
            <ul>
                <li>Una OT existente.</li>
                <li>Informes cargados que todavia no esten vinculados a otro parte.</li>
                <li>Responsables u operadores definidos para la jornada.</li>
                <li>Obra, fecha y tipo de servicio claros.</li>
            </ul>
            <p>
                El formulario usa la fecha y la obra para traer informes pendientes y despues los guarda como parte del parte diario.
            </p>
        </div>
    </section>

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Flujo recomendado</h2>
            <ol>
                <li>Entrar a la OT correcta y abrir el bloque de <strong>Partes</strong>.</li>
                <li>Definir fecha, obra y tipo de servicio de la jornada.</li>
                <li>Revisar los informes pendientes que el sistema trae para ese contexto.</li>
                <li>Completar responsables, vehiculos, servicios u observaciones que complementan el trabajo del dia.</li>
                <li>Guardar el parte y validar que quede disponible para PDF, consulta y eventual certificacion.</li>
            </ol>
        </div>
    </section>

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Que se carga en la pantalla</h2>
            <ul>
                <li><strong>Datos generales:</strong> OT, obra, fecha, tipo de servicio, horario y observaciones.</li>
                <li><strong>Responsables:</strong> operadores o personas vinculadas a la actividad del dia.</li>
                <li><strong>Vehiculos:</strong> si hubo movilidad propia, con kilometraje inicial y final.</li>
                <li><strong>Informes:</strong> RI, PM, LP, RD, US, DZ, CV, PMI, RG, TT e importados, segun corresponda.</li>
                <li><strong>Servicios:</strong> detalle adicional de tareas o cantidades no cubiertas solo por el informe.</li>
            </ul>
            <ayuda-demo-form-parte></ayuda-demo-form-parte>
            <ayuda-demo-tabla-operarios-horas></ayuda-demo-tabla-operarios-horas>
            <p>
                El resultado no es solo administrativo: despues el parte puede alimentar certificados y reportes.
            </p>
        </div>
    </section>

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Parte normal y parte manual</h2>
            <p>
                El sistema tiene un circuito normal de parte diario y otro de parte manual. El parte manual se usa cuando la jornada
                necesita registrarse con una estructura mas libre, incluyendo detalles por tecnica, plantas, operadores, inspectores
                e incluso asociando informes al registro manual.
            </p>
            <p>
                Conviene usar el parte normal cuando la OT ya tiene informes y estructura suficiente para consolidar la jornada
                con el flujo estandar. El parte manual sirve como salida alternativa cuando el negocio necesita una carga especial.
            </p>
        </div>
    </section>

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Que revisar antes de guardar</h2>
            <ul>
                <li>Que la fecha y la obra elegidas sean las correctas, porque eso define que informes pendientes se ofrecen para asociar.</li>
                <li>Que no falten responsables, vehiculos o servicios relevantes para representar correctamente la jornada.</li>
                <li>Que los informes seleccionados correspondan realmente al trabajo del dia y no a otra fecha o contexto.</li>
                <li>Que las observaciones cierren la lectura del parte sin reemplazar datos estructurados del formulario.</li>
            </ul>
        </div>
    </section>

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Resultado esperado</h2>
            <p>
                Al guardar, el parte queda disponible en el listado de la OT, puede generar su PDF y pasa a formar parte del
                historial diario de trabajo. Si luego se emite un certificado, ese proceso tomara partes ya registrados.
            </p>
            <p>
                El parte debe dejar consolidada la jornada con suficiente claridad como para servir despues en certificados, consultas y reportes sin rearmar informacion manualmente.
            </p>
            <h3>Articulos relacionados</h3>
            <ul class="ayuda_links">
                <li><a href="{{ route('ayuda-visualizar-parte-diario') }}">Visualizacion de partes diarios</a></li>
                <li><a href="{{ route('ayuda-generar-informes') }}">Creacion de informes</a></li>
                <li><a href="{{ route('ayuda-crear-certificados') }}">Creacion de certificados</a></li>
                <li><a href="{{ route('ayuda-visualizar-ot') }}">Visualizacion general de la OT</a></li>
            </ul>
        </div>
    </section>
</div>
</div>

@endsection
