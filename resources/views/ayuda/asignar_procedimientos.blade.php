@extends('layouts.enod.master')

@section('contenido')

<div class="ayuda_enod">
       <div class="row">
            <div class="col-sm-12">
                <h2>Asignar procedimientos a la Orden de trabajo (OT)</h2>
                <p>Aquí es donde se asocian tanto los procedimientos específicos de <strong>Enod</strong> para la Obra, como así también los procedimientos de los <strong>clientes</strong>. Los procedimientos de <strong>Enod</strong>, podrán ser visualizados y bajados por los clientes. <br>
                Tener en cuenta que para asociar procedimientos de <strong>Enod</strong>, estos, previamente deben ser creados desde la generación de documentos. <br>
                A continuación, se muestra un ejemplo de esta asignación a una OT: </p>
            </div>

            <div class="col-sm-8 col-sm-offset-2">
                <img  class="img-responsive" src="{{ asset('img/ayuda/Asignar_procedimiento.gif') }}" />
            </div>
            <div class="col-sm-12">
                <h4>Importante:</h4>
                <p>La <strong>no</strong> asignación de procedimientos de <strong>enod</strong>, hace que en la generación de informes, sólo sea posible de seleccionar los procedimientos standard de cada método de ensayo.<br></p>
                <p>La <strong>no</strong> asignación de al menos un procedimiento de <strong>cliente</strong>, hace que <strong>no</strong> sea posible la generación de informes<br></p>
                <h3>Artículos relacionados&nbsp;</h3>
                <p><a  href="{{ route('ayuda-visualizar-procedimientos') }}"> Visualizar Procedimientos de la OT &nbsp;</a></p>
                <p><a href="nada.html"> Gestionar Documentación&nbsp;</a></p>
            </div>
        </div>
    </div>
@endsection
