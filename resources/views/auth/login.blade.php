@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
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
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Password" required autocomplete="current-password">

        @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror     
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-12">
          <div class="checkbox icheck" >
            <label>
              <input style="background-color: chartreuse;" class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} >
             Remember Me</label>
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
  <!-- /.login-box-body -->
  <div class="login-logo">
    <a href="{{ route('login') }}"><img src="{{asset('img/redes.png')}}"  height="90px"  alt="Redes Enod"> </a>
  </div>
</div>

    </div>
</div>

@endsection
