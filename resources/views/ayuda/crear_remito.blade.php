@extends('layouts.enod.master')

@section('contenido')

<div class="ayuda_enod">
    <div class="row">
        <div class="col-sm-12">
            <h2>Visualizar documentación de vehículos y documentación complementaria asignados a Orden de trabajo (OT) </h2>
            <p>Un usuario con acceso al sistema, tiene la posibilidad de visualizar e incluso bajar la documentación asociada a todos los vehículos asignados a la OT. Además podrá visualizar y bajar información complementaria asociada a la OT.<br> A continuación, se muestra un ejemplo de visualización de documentación: </p>
        </div>

        <div class="col-sm-8 col-sm-offset-2">
            <img  class="img-responsive" src="{{ asset('img/ayuda/Visualizar_vehiculo.gif') }}" />
        </div>
    </div>
</div>
@endsection
