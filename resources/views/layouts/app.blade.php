<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Enod') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{asset('adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('adminlte/bower_components/font-awesome/css/font-awesome.min.css')}}">
    <!-- Ionicons -->
    <link  rel="stylesheet" href="{{asset('adminlte/bower_components/Ionicons/css/ionicons.min.css')}}">
    <link href="{{ asset('css/AdminLTE.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">
    <link href="{{ asset('adminlte/plugins/iCheck/square/yellow.css')}}" rel="stylesheet">

    <style>

          input:focus {
            border-color:#F9CA33 !important;
        }

        button {
            border-color:  #F9CA33 !important;
            background-color: #F9CA33 !important;
        }
        .login-box-body {

              border : solid 1px;
          }

        .login-box {
            margin-top: 10%;
            padding-bottom: 0px;
            margin-bottom: 0px;
        }

    </style>
</head>
<body class="{{ Request::path() == 'login' || strpos(Request::path(),'password/reset') !== false  ? 'background-image hold-transition login-page' : '' }} ">

    <div id="app">

        <div class="navbar-custom-menu" style="padding: 5px; float: right;margin-right:50px">
            <ul class="nav navbar-nav">
                <!-- Notifications Menu -->
                <li class="dropdown notifications-menu" >
                        @if (config('country.app_country')=='ARGENTINA')
                            <img style="vertical-align:middle" src="{{asset('img/flags/AR.png')}}" alt="Logo Argentina" readonly>
                            <span class="label" style="color:black" readonly>Argentina</span>
                        @elseif (config('country.app_country')=='BRASIL')
                            <img style="vertical-align:middle" src="{{asset('img/flags/BR.png')}}" alt="Logo Brasil" readonly>
                            <span class="label" style="color:black" readonly >Brasil</span>
                        @elseif (config('country.app_country')=='URUGUAY')
                            <img style="vertical-align:middle" src="{{asset('img/flags/UR.png')}}" alt="Logo Uruguay" readonly>
                            <span class="label" style="color:black" readonly>Uruguay</span>
                        @endif
                </li>
            </ul>
        </div>

        @yield('content')

    </div>

<!-- jQuery 3 -->
<script src="{{asset('adminlte/bower_components/jquery/dist/jquery.min.js')}}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{asset('adminlte/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('adminlte/plugins/iCheck/icheck.min.js')}}"></script>

<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-yellow',
      radioClass: 'iradio_square-yellow',
      increaseArea: '20%' /* optional */
    });
  });

</script>

<script>
    $(document).ready(function () {
        $("#btnsendlink").bind("click", function (evt) {
            $( "#active" ).addClass( "fa-refresh" );
        });
    });
</script>
</body>
</html>
