@extends('layouts.enod.master')

@section('contenido')

<div class="ayuda_enod">
    <div class="row">
			<div class="col-sm-12">
                <h2>Asignar vehículos y documentación complementaria a la Orden de trabajo (OT)</h2>
                <p>La asignación de vehículos y demás doumentación complementaria a una OT, permite que los clientes visualicen toda la documentación de cada uno de los vehículos asignados y cualquier otra documentación no provista en ningun otro apartado,que se desee informar.<br> A continuación, se muestra un ejemplo de esta asignación a una OT: </p>
            </div>

            <div class="col-sm-8 col-sm-offset-2">
                <img  class="img-responsive" src="{{ asset('img/ayuda/asignar_vehiculo.gif') }}" />
            </div>

            <div class="col-sm-12 top-buffer">
                <p>La documentación queda asignada después de hacer click en el botón actualizar.<br></p>
                <h3>Artículos relacionados&nbsp;</h3>
                <p><a href="{{ route('ayuda-visualizar-vehiculos') }}"> Visualizar documentación de vehículos y documentación complementaria asignados a Orden de trabajo (OT) &nbsp;</a></p>
                <p><a href="nada.html"> Gestionar Documentación&nbsp;</a></p>
           </div>
    </div>
</div>
@endsection
