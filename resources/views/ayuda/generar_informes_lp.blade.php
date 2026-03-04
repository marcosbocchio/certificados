@extends('layouts.enod.master')

@section('contenido')

<div class="ayuda_enod">
    <div class="ayuda_panel">
        <h1>Generar informes LP</h1>
        <p>
            Esta pantalla se utiliza para registrar informes de liquidos penetrantes dentro de una OT.
            El formulario combina un encabezado general, la configuracion tecnica del ensayo y la carga de los elementos inspeccionados.
        </p>
    </div>

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Encabezado del informe</h2>
            <p>
                Si la OT fue creada como multiobra, primero debe indicarse a que obra corresponde el informe.
            </p>
            <div class="ayuda_media">
                <img class="img-responsive" src="{{ asset('img/ayuda/Encabezado_principal.PNG') }}" alt="Encabezado principal de informe LP" />
            </div>
            <p>
                Despues se completa el encabezado propio del informe con los campos obligatorios y la informacion tecnica del ensayo.
            </p>
            <div class="ayuda_media">
                <img class="img-responsive" src="{{ asset('img/ayuda/Encabezado_LP.PNG') }}" alt="Campos principales del informe LP" />
            </div>
        </div>
    </section>

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Datos a revisar en la carga</h2>
            <ul>
                <li><strong>Espesor:</strong> si el valor no aparece en la lista, puede escribirse manualmente.</li>
                <li><strong>EPS y PQR:</strong> se seleccionan segun la configuracion disponible para la OT y se completan entre si.</li>
                <li><strong>Metodo de trabajo:</strong> define las opciones disponibles para instrumento de medicion, liquidos penetrantes, reveladores y removedores.</li>
                <li><strong>Ins. Medicion:</strong> segun el metodo elegido puede corresponder un luxometro de luz blanca o una lampara UV.</li>
            </ul>
        </div>
    </section>

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Modelos 3D y elementos</h2>
            <p>
                El informe puede vincular modelos 3D ya cargados en el sistema. En el PDF se muestra una captura y luego puede abrirse
                el modelo desde el visualizador 3D.
            </p>
            <div class="ayuda_media">
                <img class="img-responsive" src="{{ asset('img/ayuda/Modelo_3d.PNG') }}" alt="Modelos 3D en informe LP" />
            </div>
            <p>
                En la seccion de <strong>Elemento</strong> se cargan las piezas o sectores inspeccionados. Para cada uno puede registrarse
                la medida en centimetros, una descripcion, su estado y un archivo de referencia si hace falta mas detalle.
            </p>
            <div class="ayuda_media">
                <img class="img-responsive" src="{{ asset('img/ayuda/Elementos_LP.gif') }}" alt="Carga de elementos en informe LP" />
            </div>
        </div>
    </section>

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Importante</h2>
            <p>
                Antes de guardar conviene revisar encabezado, configuracion tecnica, elementos cargados y observaciones.
            </p>
            <p>
                Si algun dato no aparece en las listas, primero debe revisarse la configuracion de la OT y los maestros relacionados.
            </p>
            <h3>Articulos relacionados</h3>
            <ul class="ayuda_links">
                <li><a href="{{ route('ayuda-generar-informes') }}">Creacion de informes</a></li>
                <li><a href="{{ route('ayuda-crear-ot') }}">Como crear una orden de trabajo (OT)</a></li>
                <li><a href="{{ route('ayuda-asignar-procedimientos') }}">Asignar procedimientos</a></li>
            </ul>
        </div>
    </section>
</div>

@endsection
