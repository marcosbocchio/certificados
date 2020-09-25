@extends('layouts.enod.master')

@section('contenido')


<div class="ayuda_enod">
       <div class="row">
        <div class="col-sm-12">
          <h2>Cómo crear una Orden de trabajo (OT)&nbsp;</h2>
            <p>Debes seguir estos pasos:</p>
            <ol>
              <li>Hacer click en el Menú <strong>Tablero Principal</strong></li>
              <li>Hacer click en botón <strong>Nueva OT</strong></li>
              <li><strong>Completar el formulario</strong> con la información solicitada. Puedes ver la explicación más abajo</li>
              <li>Hacer click en <strong>Guardar</strong>&nbsp;</li>
            </ol>
			<p>En el punto tres debes completar el formulario de la siguiente manera:</p>
			<ul>
				<li><strong>Proyecto:</strong> Nombre del proyecto</li>
				<li><strong>FST Nº:</strong> Nº de presupuesto</li>
				<li><strong>OT Nº:</strong> Nº de OT</li>
				<li><strong>Fecha:</strong> Fecha de creación de la OT</li>
				<li><strong>Obra Nº / OC:</strong> Nº de obra asignada por el cliente. Debe ingresarse siempre para OT de obras únicas. En caso de ser una OT para múltiples obras, este campo debe quedar vacío.</li>
				<li><strong>Fecha estimada:</strong> Fecha que se estima comenzará el ensayo </li>
				<li><strong>Hora:</strong> Hora que se estima comenzará el ensayo</li>
				<li><strong>Cliente:</strong> Cliente que solicita el ensayo</li>
				<li><strong>Mostrar logo:</strong> Debe seleccionarse, si se desea que el logo sea visualizado en los informes</li>
				<li><strong>Comitente:</strong> Comitente que solicita el ensayo </li>
				<li><strong>Contacto n:</strong> Son los contactos del cliente que se desea aparezcan sus datos en la OT. El contacto 1 es obligato</li>
				<li><strong>Responsable OT:</strong> Es el responsable Enod. Debe estar asignado como <a href="Asignar_operador.html"><strong>Operador de la OT</strong></a></li>
				<li><strong>Lugar de ensayo:</strong> Es la sección donde se especifica el lugar de ensayo. El campo<strong> Lugar de ensayo</strong> es descriptivo. El resto de los campos situan la ubicación en el mapa. Tener en cuenta que si se especifica latitud y longidtud, se reubicará la ubicación en el mapa independientemente de los valores seleccionados arriba.</li>
				<li><strong>Servicios:</strong> Ingrese cada servicio presupuestado agregandolos con el boton <strong>"+".</strong> Es posible indicar norma de evaluación y de ensayo de ser necesario</li>
				<li><strong>Productos:</strong> Ingrese cada producto presupuestado, indicando la medida correspondiente, agregandolos con el boton <strong>"+".</strong></li>
				<li><strong>Elementos de seguridad:</strong> Son los EPP requeridos para el ensayo</li>
				<li><strong>Riesgos:</strong> Son los Riegos detectados para el ensayo  </li>
				<li><strong>Observaciones:</strong> Son las Observaciones de la OT</li>
			</ul>
			<p>Mirá un ejemplo:&nbsp;</p>

			 <div class="col-sm-8 col-md-offset-2">
            	<img  class="img-responsive" src="{{ asset('img/ayuda/Nueva_ot.gif') }}" />
         	 </div>
			<div class="col-sm-12">
			  <h3>Artículos relacionados&nbsp;</h3>
			  <p><a href="gestionar_clientes.html"> Gestionar clientes&nbsp;</a></p>
			  <p><a href="gestionar_comitentes.html"> Gestionar comitentes&nbsp;</a></p>
			  <p><a href="gestionar_servicios.html"> Gestionar servicios&nbsp;</a></p>
			  <p><a href="gestionar_productos.html"> Gestionar productos&nbsp;</a></p>
			</div>
        </div>
      </div>
  </div>

@endsection
