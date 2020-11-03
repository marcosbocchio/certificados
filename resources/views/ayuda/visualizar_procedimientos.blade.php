@extends('layouts.enod.master')

@section('contenido')

<div class="ayuda_enod">
       <div class="row">
            <div class="col-sm-12">
                <h2>Visualizar procedimientos asignados a Orden de trabajo (OT) </h2>
                <p>Un usuario con acceso al sistema, tiene la posibilidad de visualizar e incluso bajar la documentación asociada a todos los procedimientos asignados a la OT. Estos procedimientos son los que se emplean en los informes.<br> A continuación, se muestra un ejemplo de visualización de documentación: </p>
            </div>

            <div class="col-sm-8 col-sm-offset-2">
                <img src="{{ asset('img/ayuda/Visualizar_procedimiento.gif') }}"  class="img-responsive" alt="img"/><br>
            </div>
        </div>
    </div>
@endsection
