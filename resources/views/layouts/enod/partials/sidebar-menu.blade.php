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

                @can('M_frentes')
                  <li><a href="{{ route('frentesAsignacion') }}">Frentes</a></li>
                @endcan

                @can('M_clientes')
                  <li><a href="{{ route('clientes') }}">Clientes</a></li>
                @endcan

                @can('M_proveedores')
                    <li><a href="{{ route('proveedor') }}">Proveedores</a></li>
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

                @can('M_plantas')
                <li><a href="{{ route('plantas') }}">Plantas</a></li>
                @endcan

                @can('M_campanas')
                <li><a href="{{ route('campanas') }}">Campanas</a></li>
                @endcan

                @can('M_bombas')
                <li><a href="{{ route('bombas') }}">Bombas</a></li>
                @endcan

                @can('M_equipos')
                  <li><a href="{{ route('equipos') }}">Equipos</a></li>
                @endcan

                @can('M_interno_equipos')
                  <li><a href="{{ route('tipo-equipamiento') }}">Tipos Equipamiento</a></li>
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

        @can('REMITOS')
          <li class="treeview">
            <a href="#">
              <i class="fa fa-file-text-o"></i> <span>REMISIONES</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              @can('REMITOS')
                <li><a href="{{ route('RemitosTable') }}">Listado</a></li>
              @endcan
            </ul>
          </li>
        @endcan

        @can('STOCK'){{-- Nueva opción de menú agregada --}}
        <li class="treeview">
          <a href="#">
            <i class="fa fa-cubes"></i> <span>STOCK</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            @can('STOCK')
              <li><a href="{{ route('stock-table') }}">Compras</a></li>
              <li><a href="{{ route('stock-total') }}">Stock</a></li> 
            @endcan
          </ul>
        </li>
      @endcan
       
      @can('ASISTENCIA'){{-- Nueva opción de menú agregada --}}
        <li class="treeview">
          <a href="#">
          <i class="fas fa-calendar-alt"></i> <span>ASISTENCIAS</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            @can('A_asistencia_acceder')
              <li><a href="{{ route('asistencia-horas') }}">Carga Horas Extras</a></li>
            @endcan
            @can('A_asistencia_acceder')
              <li><a href="{{ route('asistencia-servicios') }}">Carga Servicios Extras</a></li>
            @endcan
            @can('A_resumen_view')
              <li><a href="{{ route('asistencia-resumen') }}">Resumen Horas Extras</a></li>
            @endcan
            @can('A_resumen_view')
              <li><a href="{{ route('asistencia-resumen-servicio') }}">Resumen Servicios Extras</a></li>
            @endcan
            @can('A_asistencia_acceder')
              <li><a href="{{ route('asistencia-pagos') }}">Pagar Horas Extras</a></li>
            @endcan
            @can('A_asistencia_acceder')
              <li><a href="{{ route('asistencia-pagos-servicios') }}">Pagar Servicios Extras</a></li>
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
                  <li><a href="{{ route('historial-operadores') }}">Historial Operadores</a></li>
                  <li><a href="{{ route('dosimetria-resumen') }}">Resumen</a></li>
              @endcan
              @can('D_reporte_alta_baja')
                  <li><a href="{{ route('pdfDosimetriaPeriodos') }}" target="_blank" >Reporte Alta/Baja</a></li>
              @endcan

            </ul>
          </li>
        @endcan

        @can('NOTIFICACIONES')
          <li class="treeview">
            <a href="#">
              <i class="fa fa-bell-o"></i> <span>NOTIFICACIONES</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              @can('NOTIFICACIONES')
                <li><a href="{{ route('notificaciones') }}">Ver notificaciones</a></li>
              @endcan
              @can('N_alarmas')
                  <li><a href="{{ route('alarmas') }}">Alarmas</a></li>
              @endcan
              @can('N_asignar_alarma')
                  <li><a href="{{ route('alarma-receptor') }}">Asignar Alarmas</a></li>
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

              @can('R_estadisticas_soldaduras')
                  <li><a href="{{ route('reporte-estadisticas-soldaduras','0') }}">Estadísticas soldaduras</a></li>
              @endcan

              @can('R_interno_equipos')
                   <li><a href="{{ route('reporte-interno-equipos-ri') }}">Interno equipos</a></li>
              @endcan

              @can('R_costuras')
                   <li><a href="{{ route('reporte-costuras','0') }}">Costuras</a></li>
              @endcan
              @can('R_elementos')
                   <li><a href="{{ route('reporte-elementos','0') }}">Elementos</a></li>
              @endcan
              @can('R_placas')
                   <li><a href="{{ route('reporte-placas-repetidas-testigos') }}">Placas</a></li>
              @endcan

              @can('R_resumen_certificado')
                   <li><a href="{{ route('reporte-resumen-certificado') }}">Resumen certificado</a></li>
              @endcan

              @can('R_certificados_partes')
                   <li><a href="{{ route('reporte-certificados') }}">Certificados</a></li>
              @endcan

              @can('R_certificados_partes')
                   <li><a href="{{ route('reporte-partes') }}">Partes</a></li>
              @endcan

              @can('R_resumen_epp')
                   <li><a href="{{ route('reporte-resumen-epp') }}">Entrega EPP</a></li>
              @endcan
              @can('R_resumen_epp')
                   <li><a href="{{ route('reporte-resumen-placasU') }}">placas entregas</a></li>
              @endcan


            </ul>
          </li>
        @endcan

        @can('QR')

        <li class="treeview">
          <a href="#">
            <i class="glyphicon glyphicon-qrcode"></i> <span>QR CODE</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            @can('QR_interno_equipos')
                <li><a href="{{ route('qr-interno-equipos') }}">Interno equipos</a></li>
            @endcan
            @can('QR_interno_equipos')
              <li><a href="{{ route('qr-vehiculos') }}">Vehiculos</a></li>
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
            
                <li title="Formato Importación Soldadores CSV"><a href="{{ route('software_download','Importacion_soldadores.csv') }}"><i class="fa fa-download"></i>SOLDADORES CSV</a></li>
            
            
                <li title="Importación Medición de espesores"><a href="{{ route('software_download','importacion_me.xlsx') }}"><i class="fa fa-download"></i>MEDICION DE ESPESORES</a></li>
            
          </ul>

        </li>

        <li>
            <a href="{{ route('ayuda-general') }}">
              <i class="fa fa-question-circle"></i> <span>AYUDA GENERAL</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
                <li><a href="#-tablero-principal"></i>Tablero principal</a></li>
                @can('enod')
                    <li><a href="#-maestros"></i>Maestros</a></li>
                @endcan
                <li><a href="#-dosimetria"></i>Dosimetría</a></li>
                <li><a href="#-multimedia"></i>multimedia</a></li>
            </ul>
        </li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
