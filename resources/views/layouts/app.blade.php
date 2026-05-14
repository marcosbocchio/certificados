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
            border-color: #4F8CFF !important;
            outline: none;
        }
        button, .btn-primary {
            border-color: #4F8CFF !important;
            background-color: #4F8CFF !important;
            color: #fff !important;
        }
        button:hover, .btn-primary:hover {
            background-color: #3a7ae8 !important;
            border-color: #3a7ae8 !important;
        }
        .login-box-body {
            background: rgba(255,255,255,0.82) !important;
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border: 1px solid rgba(255,255,255,0.5) !important;
            border-radius: 10px;
            box-shadow: 0 8px 32px rgba(31,45,70,0.18);
        }
        .login-box {
            margin-top: 10%;
            padding-bottom: 0px;
            margin-bottom: 0px;
        }
        #nav_pais {
            position: absolute;
            overflow: hidden;
            right:24px;
        }
        .redes-card {
            background: rgba(255,255,255,0.75);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.4);
            border-radius: 10px;
            padding: 10px;
            margin-top: 8px;
            text-align: center;
            box-shadow: 0 4px 16px rgba(31,45,70,0.12);
        }
        .logos-soft {
            background: rgba(255,255,255,0.75) !important;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.4) !important;
            border-radius: 10px !important;
            padding: 8px !important;
            margin-top: 8px !important;
            box-shadow: 0 4px 16px rgba(31,45,70,0.12);
        }
    </style>
</head>
<body class="{{ Request::path() == 'login' || strpos(Request::path(),'password/reset') !== false  ? 'background-image hold-transition login-page' : '' }} ">

    <div id="app">
            <div id='nav_pais' class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <li class="dropdown notifications-menu" >
                            @if (config('country.app_country')=='ARGENTINA')
                                <img style="vertical-align:middle" src="{{asset('img/flags/argentina.png')}}" width="23" alt="Logo Argentina" readonly>
                                <span class="label" style="color:black" readonly>Argentina</span>
                            @elseif (config('country.app_country')=='BRASIL')
                                <img style="vertical-align:middle" src="{{asset('img/flags/BR.png')}}" alt="Logo Brasil" readonly>
                                <span class="label" style="color:black" readonly >Brasil</span>
                            @elseif (config('country.app_country')=='URUGUAY')
                                <img style="vertical-align:middle" src="{{asset('img/flags/uruguay.png')}}" width="23" alt="Logo Uruguay" readonly>
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
