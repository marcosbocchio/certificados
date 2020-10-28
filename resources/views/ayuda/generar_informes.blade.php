@extends('layouts.enod.master')

@section('contenido')

<div class="ayuda_enod">

<div class="ayuda_enod">
    <div class="row">
        <div class="col-sm-12">
            <h2>Creación de informes</h2>
            <p>A partir de una OT generada, y de acuerdo a los <strong>servicios especificados</strong> en la misma, el sistema ofrecerá qué informes pueden generarse.<br> Es muy recomentable, antes de comenzar a generar informes, asegurarse que esten los datos necesarios asociados a a la OT:</p>
            <ul>
                <li><strong>Operadores:</strong> Se solicitará el ejecutor de ensayo del informe</li>
                <li><strong>Soldadores:</strong> Cuando se trate de informes de RI. Existe la alternativa de no agregarlos manualmente e importarlos desde archivo.</li>
                <li><strong>Procedimientos:</strong>
                    <ul>
                        <li>Procedimientos Enod: En caso de no asociar un procedimiento particular para el ensayo, solo podrá seleccionarse el procedimiento standard del tipo de ensayo correspondiente.</li>
                        <li>Procedimientos Clientes: Corresponde a EPS y PQR. No es posible generar ningún tipo de informe si al menos no existe un procedimeinto asociado para la obra que se desee informar.&nbsp;</li>
                    </ul>
                </li>
            </ul>
            <p>Mirá el siguiente video para ver como ingresar a generar informes:<br></p>
        </div>

            <div class="col-sm-8 col-sm-offset-2">
            <img  class="img-responsive" src="{{ asset('img/ayuda/Generar_informe.gif') }}" alt="informe.png"/><br>
        </div>

        <div class="col-sm-12">
            <p>A medida que se van generando los informes, aparecen listados todos los informes de la OT, como se muestra en la siguiente pantalla:</p>
        </div>
        <div class="col-sm-8 col-sm-offset-2">
            <img  class="img-responsive" src="{{ asset('img/ayuda/Listado_informes.PNG') }}" alt="informe.png"/><br>

        </div>
        <div class="col-sm-12 detalle_iconos" >
            <strong>Detalle de íconos </strong><br>
            <p><img  class="img-responsive" src="{{ asset('img/ayuda/Boton_editar.PNG') }}" />&nbsp;&nbsp;Permite editar un informe ya creado. Tener en cuenta que si el informe está firmado, se creará una nueva revisión. Para la generación de partes diarios, siempre se tiene en cuenta la última revisión, esté firmada o no.</p>
            <p><img  class="img-responsive" src="{{ asset('img/ayuda/Boton_clonar.PNG') }}"  />&nbsp;&nbsp; Clona el encabezado del informe en un nuevo informe para evitar el ingreso repetitivo de datos.</p>
            <p><img  class="img-responsive" src="{{ asset('img/ayuda/Boton_placa_diginal.PNG') }}" />
               <img  class="img-responsive" src="{{ asset('img/ayuda/Boton_us_digital.PNG') }}" />&nbsp;&nbsp; Sólo aparecen en informes RI y US respectivamente. El primero permite subir placas digitalizadas y el segundo modelos US.</p>
            <p><img  class="img-responsive" src="{{ asset('img/ayuda/Boton_pdf.PNG') }}" />&nbsp;&nbsp;Permite acceder al pdf de la revisión actual.</p>
            <p><img  class="img-responsive" src="{{ asset('img/ayuda/Boton_escaneados.PNG') }}" />&nbsp;&nbsp;Permite subir pdf escaneados del informe.</p>
            <p><img  class="img-responsive" src="{{ asset('img/ayuda/Boton_firmar.PNG') }}" />
               <img  class="img-responsive"  src="{{ asset('img/ayuda/Boton_firmado.PNG') }}"  />&nbsp;&nbsp; El primero permite firmar la revisión actual y automaticamente se muestra el segundo. </p>
            <p><img  class="img-responsive" src="{{ asset('img/ayuda/Boton_revisiones_anteriores.PNG') }}" />&nbsp;&nbsp;Permite acceder a todas las revisiones anteriores a la actual.</p>
            <p><strong>Tipos de informes </strong><br></p>
            <ul>
                <li><a href="{{ route('ayuda-generar-informes-ri') }}">Generar informes RI</a></li>
                <li><a href="{{ route('ayuda-generar-informes-pm') }}">Generar informes PM</a></li>
                <li><a href="{{ route('ayuda-generar-informes-lp') }}">Generar informes LP</a></li>
                <li><a href="{{ route('ayuda-generar-informes-us') }}">Generar informes US</a></li>
                <li><a href="Ayuda_generar_informesImportados.html">Importar informes externos</a></li>
            </ul>
            <h3>Artículos relacionados&nbsp;</h3>
            <p><a href="Asignar_operador.html"> Asignar operadores&nbsp;</a></p>
            <p><a href="Asignar_procedimientos.html"> Asignar procedimientos&nbsp;</a></p>
            <p><a href="Asignar_soldador.html"> Asignar soldadores&nbsp;</a></p>
        </div>
    </div>
</div>

@endsection
