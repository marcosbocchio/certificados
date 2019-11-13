<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar" style="height: auto;">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="{{asset('img/user.png')}}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>{{ $user}}</p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu tree" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>       
        <li><a href="{{ route('dashboardO')}}"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>   
        @can('enod')  
          <li class="treeview">
            <a href="#">
              <i class="fa fa-laptop"></i>
              <span>OT</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="{{ route('ots.create') }}"><i class="fa fa-circle-o"></i> Alta</a></li>                      
            </ul>
          </li>
        @endcan
        @can('enod')
          <li class="treeview">
            <a href="#">
              <i class="fa fa-th"></i> <span>MAESTROS</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="{{ route('usuarios') }}"><i class="fa fa-circle-o"></i>Usuarios</a></li>
              <li><a href="{{ route('clientes') }}"><i class="fa fa-circle-o"></i>Clientes</a></li>
              <li><a href="{{ route('materiales')}}"><i class="fa fa-circle-o"></i>Materiales</a></li>
              <li><a href="{{ route('documentaciones')}}"><i class="fa fa-circle-o"></i>Documentaciones</a></li>
              <li><a href="{{ route('unidades-medidas') }}"><i class="fa fa-circle-o"></i>Unidades de Medidas</a></li>
              <li><a href="{{ route('medidas') }}"><i class="fa fa-circle-o"></i>Medidas</a></li>
              <li><a href="{{ route('productos') }}"><i class="fa fa-circle-o"></i>Productos</a></li>
              <li><a href="{{ route('servicios') }}"><i class="fa fa-circle-o"></i>Servicios</a></li>
              <li><a href="{{ route('soldadores') }}"><i class="fa fa-circle-o"></i>Soldadores</a></li>
              <li><a href="{{ route('equipos') }}"><i class="fa fa-circle-o"></i>Equipos</a></li>
              <li><a href="{{ route('Interno-equipos') }}"><i class="fa fa-circle-o"></i>Interno Equipos</a></li>
              <li><a href="{{ route('fuentes') }}"><i class="fa fa-circle-o"></i>Fuentes</a></li>
              <li><a href="{{ route('Interno-fuentes') }}"><i class="fa fa-circle-o"></i>Interno Fuentes</a></li>
              @can('roles')
              <li><a href="{{ route('roles') }}"><i class="fa fa-circle-o"></i>Roles</a></li>
              @endcan
               @can('permisos')
               <li><a href="{{ route('permisos') }}"><i class="fa fa-circle-o"></i>Permisos</a></li>
               @endcan
            </ul>
          </li>
        @endcan

        <li class="treeview">
          <a href="#">
            <i class="fa fa-book"></i> <span>Institucionales</span>
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

      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>