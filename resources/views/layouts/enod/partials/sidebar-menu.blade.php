<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar" style="height: auto;">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="{{asset('img/user.png')}}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>{{ $user->name}}</p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu tree" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>       
        <li><a href="{{ route('dashboard')}}" ><i class="fa fa-dashboard"></i> <span>TABLERO PRINCIPAL</span></a></li>   
        @can('OT')  
          <li class="treeview">
            <a href="#">
              <i class="fa fa-laptop"></i>
              <span>OT</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="{{ route('ots.create') }}"> Alta</a></li>                      
            </ul>
          </li>
        @endcan
        @can('MAESTROS')
          <li class="treeview">
            <a href="#">
              <i class="fa fa-th"></i> <span>MAESTROS</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
         
              <li><a href="{{ route('usuarios') }}">Usuarios</a></li>
          
              <li><a href="{{ route('clientes') }}">Clientes</a></li>
        
              <li><a href="{{ route('contratistas') }}">Contratistas</a></li>
          
              <li><a href="{{ route('materiales')}}">Materiales</a></li>
          
              <li><a href="{{ route('norma-ensayos') }}">Norma ensayos</a></li>
              <li><a href="{{ route('norma-evaluaciones') }}">Norma Evaluaciones</a></li>
              <li><a href="{{ route('documentaciones')}}">Documentaciones</a></li>
              <li><a href="{{ route('unidades-medidas') }}">Unidades de Medidas</a></li>
              <li><a href="{{ route('medidas') }}">Medidas</a></li>
              <li><a href="{{ route('productos') }}">Productos</a></li>
              <li><a href="{{ route('servicios') }}">Servicios</a></li>
              <li><a href="{{ route('soldadores') }}">Soldadores</a></li>
              <li><a href="{{ route('equipos') }}">Equipos</a></li>
              <li><a href="{{ route('Interno-equipos') }}">Interno Equipos</a></li>
              <li><a href="{{ route('fuentes') }}">Fuentes</a></li>
              <li><a href="{{ route('Interno-fuentes') }}">Interno Fuentes</a></li>
              @can('roles')
                  <li><a href="{{ route('roles') }}">Roles</a></li>
              @endcan
              @can('permisos')
                  <li><a href="{{ route('permisos') }}">Permisos</a></li>
              @endcan
            </ul>
          </li>
        @endcan

        @can('DOSIMETRIA')
          <li class="treeview">
            <a href="#">
              <i class="fa fa-bar-chart"></i> <span>DOSIMETRIA</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              @can('D_activa-operador')
                  <li><a href="{{ route('operador-periodo-rx') }}">Activar Operador</a></li> 
              @endcan
              @can('D_operador')
                  <li><a href="{{ route('dosimetria-operador') }}">Operador</a></li>
              @endcan
              @can('D_rx')
                  <li><a href="{{ route('dosimetria-rx') }}">RX</a></li>
              @endcan
              @can('D_estados')
                  <li><a href="{{ route('dosimetria-estados') }}">Estados</a></li>
              @endcan
              @can('D_resumen')
                  <li><a href="{{ route('dosimetria-resumen') }}">Resumen</a></li>
              @endcan
              @can('D_reporte_alta_baja')
                  <li><a href="{{ route('pdfDosimetriaPeriodos') }}" target="_blank" >Reporte Alta/Baja</a></li>
              @endcan

            </ul>
          </li>
        @endcan

        <li class="treeview">
          <a href="#">
            <i class="fa fa-book"></i> <span>INSTITUCIONALES</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">

            @foreach ( $documentos as $documento )

                @if ($documento->tipo == 'INSTITUCIONAL')

                <li><a href="{{ route('institucionales',$documento->id)  }}" target='_blank' ><i class="fa fa-file-pdf-o"></i> {{ $documento->titulo }}</a></li>

                @endif
            @endforeach     
            
          </ul>
        </li>   
       
        <li class="treeview">
          <a href="#">
            <i class="fa  fa-cloud-download"></i>
            <span>DOWNLOAD</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ route('software_download','INDUSTREX V4.2 Lite Setup.exe') }}"><i class="fa fa-download"></i>INDUSTREX V4.2 Lite</a></li>                      
          </ul>
        </li>
       

      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>