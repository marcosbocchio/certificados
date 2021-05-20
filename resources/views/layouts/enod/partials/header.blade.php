<div class="wrapper">

    <!-- Main Header -->
    <header class="main-header">

        <!-- Logo -->
        <a href="{{ route('dashboard') }}" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>E</b>nod</span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg">
                 <img src="{{asset('img/logo-enod.png')}}" style="margin-top: -10px;" height="70px" alt="Logo Enod">
            </span>
        </a>

        <!-- Header Navbar -->
        <nav class="navbar navbar-static-top" role="navigation">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
            <!-- Navbar Right Menu -->
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">

                    <!-- Notifications Menu -->



                    <li class="dropdown notifications-menu">
                        <!-- Menu toggle button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-bell-o"></i>
                            @php
                                 $total_notificaciones =  0;
                                 foreach ($user->notificaciones_resumen as $item){
                                        $total_notificaciones +=$item->total;
                                 }
                            @endphp

                            <span class="label label-warning notificacion_total" >{{ $total_notificaciones}}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">Tienes <span class="notificacion_total"> {{ $total_notificaciones }} </span> notificaciones</li>
                            <li>
                                <!-- Inner Menu: contains the notifications -->
                                <ul class="menu" id="menu-notificaciones">

                                    @foreach ($user->notificaciones_resumen as $notificacion)

                                        <li><!-- start notification -->
                                            <a href="#">
                                                <i class="fa fa-bell-o text-red"></i>
                                               <span>{{ $notificacion->total }}</span> notificaciones de <span>{{ $notificacion->tipo }}</span>
                                            </a>
                                        </li>

                                    @endforeach
                                    <!-- end notification -->
                                </ul>
                            </li>
                            <li class="footer"><a href="{{ route('notificaciones') }}">Ver detalle</a></li>
                        </ul>
                    </li>

                    <li class="dropdown user user-menu">
                        @if (config('country.app_country')=='ARGENTINA')
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" >
                                <img src="{{asset('img/flags/argentina.png')}}" width="23" alt="Logo Argentina">
                            </a>
                        @elseif (config('country.app_country')=='BRASIL')
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <img style="vertical-align:middle" src="{{asset('img/flags/BR.png')}}" width="23" alt="Logo Brasil">
                            </a>
                        @elseif (config('country.app_country')=='URUGUAY')
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <img style="vertical-align:middle" src="{{asset('img/flags/uruguay.png')}}" width="23"alt="Logo Uruguay">
                            </a>
                        @endif
                        </a>
                    </li>

                    <!-- User Account Menu -->
                    <li class="dropdown user user-menu">
                        <!-- Menu Toggle Button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <!-- The user image in the navbar-->
                            <img src="{{asset('img/user.png')}}" class="user-image" alt="User Image">
                            <!-- hidden-xs hides the username on small devices so only the image appears. -->
                            <span class="hidden-xs">{{ $user->name}}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- The user image in the menu -->
                            <li class="user-header">
                                <img src="{{asset('img/user.png')}}" class="img-circle" alt="User Image">

                                <p>
                                    {{ $user->name }}
                                    <small>Miembro desde el {{ date('d-m-Y',strtotime($user->created_at)) }} </small>
                                </p>
                            </li>

                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="{{ route('perfil') }}" class="btn btn-default btn-flat">Perfil</a>
                                </div>
                                <div class="pull-right">
                                    <a class="btn btn-default btn-flat" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">
                                        <i class="fa fa-power -off"></i>
                                        {{ __('Cerrar sesión') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
