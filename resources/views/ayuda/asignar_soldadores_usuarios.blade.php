@extends('layouts.enod.master')

@section('contenido')

<div class="ayuda_enod">
       <div class="row">
			<div class="col-sm-12">
			  <h2>Asignar soldadores y usuarios de clientes a Orden de trabajo (OT)</h2>
			  <p>Para que un usuario de cliente, tenga acceso a visualizar la OT , los informes, partes diarios y certificados, es necesario indicarlo explicitamente.<br> En el caso de que la OT tenga servicios de RI, tambien hay que indicar que soldadores serán posibles de seleccionar en este tipo de informes. Para poder seleccionarlos, éstos, previamente deben pertenecer al conjunto de <a href="Gestionar_soldador.html"><strong>soldadores informados</strong></a> por el cliente.<br> A continuación, se muestra un ejemplo de asignación de soldadores y usuarios de clientes a una OT: </p>
			 </div>

			 <div class="col-sm-8 col-sm-offset-2">
            	  <img  class="img-responsive" src="{{ asset('img/ayuda/Asignar_soldador.gif') }}" />
 			</div>
		   	<div class="col-sm-12">
				<h4>Importante:</h4>
				<p>En el caso de que las pasadas en los informes RI, sean informadas por el cliente mediante achivo CSV, no es necesario indicar los soladores, ya que el sistema los agrega automáticamente.<br></p>
			  	<h3>Artículos relacionados&nbsp;</h3>
			  	<p><a href="gestionar_soldadores.html"> Gestionar soldadores&nbsp;</a></p>
			  	<p><a href="gestionar_usuarios.html"> Gestionar usuarios&nbsp;</a></p>
                <p><a href="{{ route('ayuda-generar-informes') }}"> Creación de informes&nbsp;</a></p>
			</div>
        </div>
    </div>
@endsection
