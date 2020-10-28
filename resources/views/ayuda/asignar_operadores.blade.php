@extends('layouts.enod.master')

@section('contenido')

<div class="ayuda_enod">
    <div class="row">
        <div class="col-sm-12">
            <h2>Asignar operadores a una Orden de trabajo (OT)</h2>
            <p>La asignación de operadores y ayudantes que realizarán los ensayos de la OT, permite que estos puedan ser seleccionandos en los informes y partes diarios. Además posibilita a que los clientes visualicen toda la documentación que estos tienen asociada.<br> A continuación, se muestra un ejemplo de asignación de operadores y ayudantes a una OT: </p>
           </div>

           <div class="col-sm-8 col-sm-offset-2">
                <img  class="img-responsive" src="{{ asset('img/ayuda/Asignar_operador.gif') }}"/>
           </div>
             <div class="col-sm-12">
              <h4>Importante:</h4>
              <p>La documentación de cada operador, se visualiza después de hacer click en el botón actualizar.<br></p>
                <h3>Artículos relacionados&nbsp;</h3>
                <p><a href="gestionar_soldadores.html"> Gestionar soldadores&nbsp;</a></p>
                <p><a href="gestionar_usuarios.html"> Gestionar usuarios&nbsp;</a></p>
                <p><a href="{{ route('ayuda-generar-informes') }}"> Creación de informes&nbsp;</a></p>
            </div>
    </div>
</div>
@endsection
