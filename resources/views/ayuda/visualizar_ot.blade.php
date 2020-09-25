@extends('layouts.enod.master')

@section('contenido')

<div class="ayuda_enod">
       <div class="row">
			<div class="col-sm-12">
			  <h2>Visualización general de una Orden de trabajo (OT)</h2>
			  <p>A medida que se van creando en el sistema las Ordenes de trabajo, se van listando en el Tablero principal por orden de creación en forma descendiente. Es importante aclarar, que la visualización depende del usuario conectado y nunca será posible que un cliente acceda ni visualice  una Orden de trabajo que no le corresponde.<br>
			  Cuando seleccionamos en el listado una determinada Orden de trabajo, en los ocho íconos de la parte superior del tablero, se puede acceder y visualizar (según permisos) a la informacion específica de dicha Orden.</p>
			  <p>Íconos de acceso a la información de la OT seleccionada:<br></p>
			</div>

			 <div class="col-sm-8 col-sm-offset-2">
            	  <img src="{{ asset('img/ayuda/Tablero_iconos_grandes.PNG') }}"  class="img-responsive" alt="img"/><br>
		 	 </div>
			<div class="col-sm-12">
			  	<ul>
				<li><strong>Operadores:</strong> Asignación y visualización de documentación de cada operador asignado a la OT</li>
				<li><strong>Equipos:</strong> Visualización de documentación de cada Equipo/Fuente asignada a la OT</li>
				<li><strong>Procedimientos:</strong> Creación y visualización de documentación de los procedimientos de la OT</li>
				<li><strong>Vehículo | Doc:</strong> Asignacion y visualización de documentación de cada vehículo asignado a la OT y documentación complementaria</li>
				<li><strong>Remitos:</strong> Generación y visualizacion de remitos de la OT</li>
				<li><strong>Informes:</strong> Generación y visualizacion de informes de la OT</li>
				<li><strong>Partes:</strong> Generación y visualizacion de partes diarios de la OT</li>
				<li><strong>Certificados:</strong>Generación y visualizacion de certificados de la OT</li>
				</ul> <br>
				<h3>Artículos relacionados&nbsp;</h3>
				<p><a href="Visualizar_operador.html">Visualizar documentación de operadores asignados a una Orden de trabajo (OT) &nbsp;</a></p>
				<p><a href="Visualizar_equipo.html">Visualizar documentación de equipos y fuentes asignadas a una Orden de trabajo (OT) &nbsp;</a></p>
				<p><a href="Visualizar_procedimientos.html"> Visualizar documentación de procedimientos asignados a una Orden de trabajo (OT)&nbsp;</a></p>
				<p><a href="Visualizar_vehiculo.html"> Visualizar documentación de vehículos y documentación complementaria asignados a Orden de trabajo (OT) &nbsp;</a></p>
				<p><a href="Visualizar_remito.html">Visualizar remitos generados en una Orden de trabajo (OT) &nbsp;</a></p>
				<p><a href="Visualizar_informe.html">Visualizar informes generados en una Orden de trabajo (OT) &nbsp;</a></p>
				<p><a href="Visualizar_parte.html"> Visualizar partes diarios generados en una Orden de trabajo (OT)&nbsp;</a></p>
				<p><a href="Visualizar_certificado.html"> Visualizar certificados generados en una Orden de trabajo (OT) &nbsp;</a></p>
			</div>
        </div>
    </div>

@endsection
