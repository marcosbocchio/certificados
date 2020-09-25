@extends('layouts.enod.master')

@section('contenido')
<div class="ayuda_enod">
       <div class="row">
			<div class="col-sm-12">
			  <h2>Buscar en los formularios de la Aplicación</h2>
			  <p>Cada formulario que contiene <img src="{{ asset('img/ayuda/Lupa.PNG') }}" /> arriba a la derecha de las tablas que muestran algún listado, brinda la posibilidad de filtrar el listado o buscar algún ítem en particular. <br> Hay que considerar que la búsqueda puede ser parcial y que se realiza por cualquiera de los ítems de la lista. <br> A continuación se muestra un ejemplo de búsqueda de una OT: </p>
			 </div>

			 <div class="col-sm-8 col-sm-offset-2">
            	  <img  class="img-responsive" src="{{ asset('img/ayuda/Buscar_ot.gif') }}" />
 			</div>
		    <div class="col-sm-12">
				<h4>Importante:</h4>
				<p>Cuando la búsqueda se realiza sobre el listado de OTs, los resultados no solo dependen del filtro de búsqueda, sino también del usuario actual. <br>Si el usuario actual, es un usuario perteneciente a un cliente, este sólo tendrá acceso a visualizar las OTs del cliente y además, a las cuales está autorizado.</p>
			</div>
        </div>
    </div>

@endsection
