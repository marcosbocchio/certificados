@extends('layouts.enod.master')

@section('contenido')

<div class="ayuda_enod">
    <div class="row">
        <div class="col-sm-12">
            <h1>Generar informes LP<br></h1>
            <p></p>
            <h2>Encabezados<br></h2>
            <p>Al ingresar a generar el informe, si es que la OT está generada como <strong>Multiobra</strong>, es necesario especificar a que obra corresponde el informe en el encabezado principal: </p>
        </div>

            <div class="col-sm-8 col-sm-offset-2">
                <img  class="img-responsive" src="{{ asset('img/ayuda/Encabezado_principal.PNG') }}" />
        </div>
        <div class="col-sm-12">
            <p>Ahora es momento de completar cada uno de los campos del siguiente cuadro teniendo en cuenta que los que tienen un asterisco (*), son datos obligatorios:<br></p>
        </div>
        <div class="col-sm-8 col-sm-offset-2">
                <img  class="img-responsive" src="{{ asset('img/ayuda/Encabezado_LP.PNG') }}"/>
        </div>
        <div class="col-sm-12">
        <p>Tener en cuenta:</p>
        <ul>
            <li><strong>Espesor:</strong> Si el espesor deseado, no está disponible en la lista, es posible editar y colocar el deseado. </li>
            <li><strong>EPS:</strong> Seleccionar uno de los <strong>EPS</strong> definidos para <strong>OT/Obra</strong>. Se completará automáticamente <strong>PQR.</strong>.
            </li>
            <li><strong>PQR:</strong> Existe la posibilidad de seleccionar uno de los <strong>PQR</strong> definidos para <strong>OT/Obra</strong>.  Se completará automáticamente <strong>EPS</strong>.</li>
            <li><strong>Método Trabajo:</strong> De acuerdo a su selección, el sistema filtra las posibilidades de elección de los tipos de <strong>Inst. Medición</strong> (definidos como equipos de medicion PM), <strong>líquidos penetrantes, reveladores y removedores</strong> ya que se encuentran directamente relacionados al <strong>Tipo Penetrante</strong> que es univocamente identificado por el método.</li>
            <li><strong>Ins. Medición:</strong> De acuerdo al <strong>Método Trabajo</strong> elegido, se podrá seleccionar un <strong>Luxómetro luz blanca</strong> o una <strong>Lámpara luz UV</strong>.</li>
        </ul>
        <h2>Modelos 3D<br></h2>
        <p>Esta sección permite seleccionar uno o mas modelos 3D, que deben existir en el repositorio de modelos. En los informes pdf, se visualiza una captura de imagen y la posibilidad de visualizar el modelo en el visualizador 3D</p>
        </div>
        <div class="col-sm-8 col-sm-offset-2">
            <img  class="img-responsive" src="{{ asset('img/ayuda/Modelo_3d.PNG') }}" />
        </div>
        <div class="col-sm-12">
        <h2>Elemento<br></h2>
        <p>En esta sección es donde se cargan cada uno de los elementos/piezas ensayadas con la obligación de cargar el tamaño en cm (valor tenido en cuanta en los partes diarios). Por cada uno, es posible agregar una descripción, rechazarlo y/o asociarle un archivo de referencia para una mayor grado de detalle, como se muestra a continuación:</p>
        </div>
        <div class="col-sm-8 col-sm-offset-2">
            <img  class="img-responsive" src="{{ asset('img/ayuda/Elementos_LP.gif') }}" />
        </div>

        <div class="col-sm-12">
            <p>Por último, es posible ingresar una observacion y guardar el informe.</p>
        </div>
        <div class="col-sm-12">
            <h3>Artículos relacionados&nbsp;</h3>
            <p><a href="Ayuda_nueva_ot.html">Cómo crear una Orden de trabajo (OT)&nbsp;</a></p>
            <p><a href="{{ route('ayuda-asignar-soldadores-y-usuarios') }}">Asignar soldadores y usuarios de clientes a Orden de trabajo (OT)&nbsp;</a></p>
            <p><a href="{{ route('ayuda-generar-informes') }}"> Creación de informes&nbsp;</a></p>
        </div>

    </div>
</div>

@endsection
