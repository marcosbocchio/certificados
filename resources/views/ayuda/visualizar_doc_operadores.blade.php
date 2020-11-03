@extends('layouts.enod.master')

@section('contenido')

<div class="ayuda_enod">
       <div class="row">
            <div class="col-sm-12">
                <h2>Visualizar documentación de operadores y ayudantes de Orden de la trabajo</h2>
                <p>Un usuario con acceso al sistema, tiene la posibilidad de visualizar e incluso bajar la documentación asociada a todos los operadores asignados a la OT. La documentación listada, es documentación general que no está asociada a ningún método de ensayo y también documentación específica de los métodos de ensayo, según los servicios a realizar en la Orden de trabajo. Por ejemplo, si la OT abarca servicios de RI y US, sólo se podrán visualizar los certificados relacionados a dichas técnicas.<br> A continuación, se muestra un ejemplo de visualización de documentación: </p>
            </div>

            <div class="col-sm-8 col-sm-offset-2">
                <img class="img-responsive" src="{{ asset('img/ayuda/Visualizar_operador.gif') }}" />
            </div>
                <div class="col-sm-12">
                    <h3>Artículos relacionados&nbsp;</h3>
                    <p><a href="gestionar_soldadores.html"> Gestionar soldadores&nbsp;</a></p>
                    <p><a href="gestionar_usuarios.html"> Gestionar usuarios&nbsp;</a></p>
                    <p><a href="{{ route('ayuda-generar-informes') }}"> Creación de informes&nbsp;</a></p>
                </div>
        </div>
    </div>
@endsection
