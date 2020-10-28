@extends('layouts.enod.master')

@section('contenido')

<div class="ayuda_enod">
       <div class="row">
        <div class="col-sm-12">
            <h1>Generar informes US<br></h1>
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
                <img  class="img-responsive" src="{{ asset('img/ayuda/Encabezado_US.PNG') }}" />
           </div>
          <div class="col-sm-12">
          <p>Tener en cuenta:</p>
          <ul>
              <li><strong>Espesor:</strong> Si el espesor deseado, no está disponible en la lista, es posible editar y colocar el deseado. </li>
              <li><strong>EPS:</strong> Seleccionar uno de los <strong>EPS</strong> definidos para <strong>OT/Obra</strong>. Se completará automáticamente <strong>PQR.</strong>.
              </li>
              <li><strong>PQR:</strong> Existe la posibilidad de seleccionar uno de los <strong>PQR</strong> definidos para <strong>OT/Obra</strong>.  Se completará automáticamente <strong>EPS</strong>.</li>
              <li><strong>Técnica:</strong> Son  <strong>US convencional </strong>,<strong> Phase array</strong> y <strong>Medición de Espesores</strong>. De acuerdo a la técnica seleccionada, el informe solicita diferenctes calibraciones y mediciones.</li>
              <li><strong>Equipo:</strong> se podrá seleccionar alguno de los equipos creados para US y que no están creados como equipos palpadores.</li>

          </ul>
          <h2>Modelos 3D<br></h2>
          <p>Esta sección permite seleccionar uno o mas modelos 3D, que deben existir en el repositorio de modelos. En los informes pdf, se visualiza una captura de imagen y la posibilidad de visualizar el modelo en el visualizador 3D</p>
          </div>
          <div class="col-sm-8 col-sm-offset-2">
                <img  class="img-responsive" src="{{ asset('img/ayuda/Modelo_3d.PNG') }}" />
           </div>
         <div class="col-sm-12">
             <h4>US Convencional y Phase Array<br></h4>
          <p>Ambas técnicas solicitan los mismos datos de calibracion que se muestran a continuación:</p>
          </div>
          <div class="col-sm-8 col-sm-offset-2">
                <img  class="img-responsive" src="{{ asset('img/ayuda/Calibraciones_us_pa.PNG') }}" />
           </div>

             <div class="col-sm-12">
              <p>Tener en cuanta que se pueden ingresar hasta cuatro calibraciones distintas, haciendo Click en el botón <img src="{{ asset('img/ayuda/Boton_agregar.PNG') }}" /> y que los <strong>palpadores</strong> ofrecidos, son los equipos creados como equipos de <strong>US</strong> y especificados como <strong>palpador</strong>. <br> Las calibraciones pueden ser acompañadas por imagenes que se visualizarán en el informe.<br><br> Ahora es momento de ingresar el registro de todas las mediciones en la seguiente pantalla:</p>
          </div>
          <div class="col-sm-8 col-sm-offset-2">
                <img  class="img-responsive" src="{{ asset('img/ayuda/Mediciones_us_pa.PNG') }}" />
           </div>
             <div class="col-sm-12">
              <p>Como puede observarse, se deben completar todos los datos y agregarlos con el botón <img src="{{ asset('img/ayuda/Boton_agregar.PNG') }}" />. Esto permite <strong>Aceptar</strong> o <strong>Rechazar</strong> la medición y agregar un archivo de referencia específico por medición con hasta cuatro imagenes ilustrativas.<br> Luego, es posible incorporar al informe, cuatro imagenes más a nivel general para todas las mediciones en caso de ser necesario.</p>
          </div>
             <div class="col-sm-12">
              <h4>Medicion de espesores<br></h4>
              <p>Esta técnica requiere informar los siguientes datos de calibracion:</p>
          </div>
          <div class="col-sm-8 col-sm-offset-2">
                <img  class="img-responsive" src="{{ asset('img/ayuda/Calibraciones_me.PNG') }}" />
           </div>

             <div class="col-sm-12">
              <p>De igual manera que para <strong>US</strong> y <strong>PA</strong>, se permite ingresar hasta cuatro calibraciones distintas, haciendo Click en el botón <img src="{{ asset('img/ayuda/Boton_agregar.PNG') }}" />. Los <strong>palpadores</strong> ofrecidos, son los equipos creados como equipos de <strong>US</strong> y especificados como <strong>palpador</strong>. <br> Las calibraciones, también pueden ser acompañadas por imágenes que se visualizarán en el informe.<br><br> Ahora, es momento de ingresar el registro de todas las mediciones como se muestra el en siguiente video:</p>
          </div>
                     <div class="col-sm-8 col-sm-offset-2">
                <img  class="img-responsive" src="{{ asset('img/ayuda/Mediciones_me.gif') }}" />
           </div>
          <div class="col-sm-12">
              <p>Como puede observarse en el video, por cada elemento agregado con el botón <img src="{{ asset('img/ayuda/Boton_agregar.PNG') }}" /> se crea una matriz de <strong>Posición</strong> x <strong>Generatrices</strong>, en la cual hay que completar cada casillero con el valor medido.<br> Es importante resaltar que si el valor ingresado es menor al <strong>Espesor mínimo</strong> el reporte resaltará dicho valor en color rojo.<br>
              Luego, es posible agregar hasta cuatro imagenes ilustrativas.</p>
              <h3>Artículos relacionados&nbsp;</h3>
              <p><a href="Ayuda_nueva_ot.html">Cómo crear una Orden de trabajo (OT)&nbsp;</a></p>
              <p><a href="Asignar_soldador.html">Asignar soldadores y usuarios de clientes a Orden de trabajo (OT)&nbsp;</a></p>
              <p><a href="crear_informes.html"> Creación de informes&nbsp;</a></p>
          </div>
        </div>
    </div>
@endsection
