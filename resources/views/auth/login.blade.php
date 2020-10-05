@extends('layouts.app')

@section('content')
<div class="container"style='height:100%'>
  <div class="grandParentContaniner">
    <div class="login-box">
      <!-- /.login-logo -->
      <div class="login-box-body">
        <div class="login-logo" >
          <a href="{{ route('login') }}"><img src="{{asset('img/logo-enod-web.jpg')}}"  height="60px"  alt="Logo Enod"> </a>
        </div>
        <p class="login-box-msg" >Login para iniciar sesión</p>

        <form method="POST" action="{{ route('login') }}">
          @csrf
          <div class="form-group has-feedback">
          <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                @error('email')
                    <span class="invalid-feedback" role="alert" >
                        <strong style="color: red;">{{ $message }}</strong>
                    </span>
                @enderror

            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="contraseña" required autocomplete="current-password">

            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong style="color: red;">{{ $message }}</strong>
                </span>
            @enderror
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="row">
            <div class="col-xs-12">
              <div class="checkbox icheck" >
                <label>
                  <div class="icheckbox_square-yellow" aria-checked="false" aria-disabled="false" style="position: relative;">
                  <input name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}  type="checkbox" style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;">
                  <ins class="iCheck-helper" style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div>
                Remember Me
                </label>
              </div>
            </div>
          </div>

          <div class="row" style="margin-top:10px">
              <div class="col-xs-12">
                  <button type="submit" class="btn btn-primary btn-block btn-flat">
                    <strong> {{ __('iniciar sesión') }}</strong>
                  </button>
              </div>
            </div>
            <div class="row" style="padding-bottom: 0;">
              <div class="col-xs-12"  style="text-align: center;margin-top: 11px;" >
                  @if (Route::has('password.request'))
                      <a class="btn btn-link" href="{{ route('password.request') }}">
                          {{ __('Olvidó su contraseña?') }}
                      </a>
                  @endif
              </div>
          </div>
        </form>
      </div>
      <div class="logos-soft" style="margin-top: 8px !important;">
          <img src="{{asset('img/logos-soft-ram.png')}}" width="100%" alt="...">
      </div>
      <!-- /.login-box-body -->
      <div class="login-logo">
        <a href="http://www.enodndt.com.ar/"><img src="{{asset('img/redes.png')}}"  height="90px"  alt="Redes Enod"> </a>
      </div>
    </div>

    </div>
  </div>

@endsection
