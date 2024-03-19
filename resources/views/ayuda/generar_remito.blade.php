@extends('layouts.enod.master')

@section('contenido')

<div class="ayuda_enod">
    <div class="row">
        <div class="col-sm-12">
            <h2>Creación de Remitos</h2>
            <p>Los remitos pueden ser creados por usuarios que cuenten con el permiso <strong>'T_remitos_edita'</strong>. Para crear un remito, ubicados en el inicio, debemos dirigirnos a <strong>Remisiones</strong> (en la barra de navegación lateral izquierda), seleccionar <strong>Listado</strong>. Aquí visualizaremos una tabla con todos los remitos ya realizados. En esta sección, podremos generar uno nuevo mediante el botón mostrado en el video</p>
            <div>
                <p>Para crear un remito, debemos llenar los inputs con la información correspondiente y luego dar clic en guardar.</p>
            </div>

            <p>A continuación, se muestra un video explicativo de cómo proceder para la creación de un remito:</p>
            
            <div class="col-md-6 col-md-offset-3">
                <img  class="img-responsive" src="{{ asset('img/ayuda/crear_remito.gif') }}"  alt="img-clave"/>
            </div>

        </div>

        <!-- Sección para incluir íconos o pasos adicionales, si es necesario -->
        
        <div class="col-sm-12">
            <h3>Artículos relacionados</h3>
            <ul>
                <li><a href="#">-</a></li>
                <li><a href="#">-</a></li>
                <!-- Incluir otros artículos relacionados según sea necesario -->
            </ul>
        </div>
    </div>
</div>

@endsection
