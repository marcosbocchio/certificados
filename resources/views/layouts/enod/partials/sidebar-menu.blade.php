<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
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
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        <li><a href="{{ route('dashboard')}}" ><i class="fa fa-dashboard"></i> <span>TABLERO PRINCIPAL</span></a></li>
        <!--
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

             @can('O_alta')
              <li><a href="{{ route('ots.create') }}"> Alta</a></li>
             @endcan

            </ul>
          </li>
        @endcan
        -->
        @can('MAESTROS')
          <li class="treeview">
            <a href="#">
              <i class="fa fa-th"></i> <span>MAESTROS</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
                @can('M_usuarios')
                  <li><a href="{{ route('usuarios') }}">Usuarios</a></li>
                @endcan

                @can('M_clientes')
                  <li><a href="{{ route('clientes') }}">Clientes</a></li>
                @endcan

                @can('M_contratistas')
                  <li><a href="{{ route('contratistas') }}">Comitente</a></li>
                @endcan

                @can('M_materiales')
                  <li><a href="{{ route('materiales')}}">Materiales</a></li>
                @endcan

                @can('M_normas_ensayo')
                  <li><a href="{{ route('norma-ensayos') }}">Norma ensayos</a></li>
                @endcan

                @can('M_normas_eval')
                  <li><a href="{{ route('norma-evaluaciones') }}">Norma Evaluaciones</a></li>
                @endcan

                @can('M_documentaciones')
                  <li><a href="{{ route('documentaciones')}}">Documentaciones</a></li>
                @endcan

                @can('M_unidades_medida')
                  <li><a href="{{ route('unidades-medidas') }}">Unidades de Medidas</a></li>
                @endcan

                @can('M_medidas')
                  <li><a href="{{ route('medidas') }}">Medidas</a></li>
                @endcan

                @can('M_productos')
                  <li><a href="{{ route('productos') }}">Productos</a></li>
                @endcan

                @can('M_servicios')
                  <li><a href="{{ route('servicios') }}">Servicios</a></li>
                @endcan

                @can('M_soldadores')
                  <li><a href="{{ route('soldadores') }}">Soldadores</a></li>
                @endcan

                @can('M_equipos')
                  <li><a href="{{ route('equipos') }}">Equipos</a></li>
                @endcan

                @can('M_interno_equipos')
                  <li><a href="{{ route('Interno-equipos') }}">Interno Equipos</a></li>
                @endcan

                @can('M_fuentes')
                  <li><a href="{{ route('fuentes') }}">Fuentes</a></li>
                @endcan

                @can('M_interno_fuentes')
                  <li><a href="{{ route('Interno-fuentes') }}">Interno Fuentes</a></li>
                @endcan

                @can('M_agente_ac')
                  <li><a href="{{ route('agente-acoplamiento') }}">Agente Acoplamiento</a></li>
                @endcan

                @can('M_vehiculos')
                  <li><a href="{{ route('vehiculos') }}">Vehiculos</a></li>
                @endcan

                @can('M_modelos_3d')
                   <li><a href="{{ route('modelos-3d') }}">Modelos 3D</a></li>
                @endcan

                @can('M_roles')
                  <li><a href="{{ route('roles') }}">Roles</a></li>
                @endcan

                @can('M_permisos')
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
              @can('D_activa_operador')
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

        @can('REPORTES')
          <li class="treeview">
            <a href="#">
              <i class="glyphicon glyphicon-stats"></i> <span>REPORTES</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              @can('D_soldaduras')
                  <li><a href="{{ route('reporte-estadisticas-soldaduras') }}">Estadísticas soldaduras</a></li>
              @endcan
              @can('D_soldaduras')
                   <li><a href="{{ route('reporte-costuras') }}">Costuras</a></li>
              @endcan

              @can('D_soldaduras')
                   <li><a href="{{ route('reporte-placas-repetidas-testigos') }}">Placas</a></li>
              @endcan

            </ul>
          </li>
        @endcan

        @can('CURSOS')
          <li class="treeview">
            <a href="#">
              <i class="glyphicon glyphicon-film"></i> <span>MULTIMEDIA</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              @can('C_edita')
                  <li><a href="{{ route('crear-contenido') }}">Gestionar contenido</a></li>
              @endcan
              @can('C_visualiza_cursos')
                <li><a href="{{ route('multimedia') }}">Visualizar contenido</a></li>
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
            @can('enod')
                <li title="Formato Importación Soldadores CSV"><a href="{{ route('software_download','Importacion_soldadores.csv') }}"><i class="fa fa-download"></i>SOLDADORES CSV</a></li>
            @endcan
          </ul>

        </li>

        <li class="treeview">
            <a href="#">
              <i class="fa fa-question-circle"></i>
              <span>AYUDA</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="{{ route('ayuda-tablero-principal') }}"><i class="fa fa-download"></i>GENERAL</a></li>
            </ul>
        </li>

      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
