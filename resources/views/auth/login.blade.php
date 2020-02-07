@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
    <div class="login-box">
      <div class="login-logo" style="margin-bottom: -10px;">
        <a href="{{ route('login') }}"><img src="{{asset('img/logo-enod.png')}}"  height="120px"  alt="Logo Enod"> </a>
      </div>
   <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Login para iniciar sesión</p>

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
          <div class="checkbox icheck">
            <label class="">
              <div class="icheckbox_square-blue" aria-checked="false" aria-disabled="false" style="position: relative;">
    
              <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;">

              <ins class="iCheck-helper" style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;">
              </ins>
      
              </div> Remember Me</label>
          </div>
        </div>
       </div>
        <!-- /.col -->
        <div class="row">
        <div class="col-xs-4">
            <button type="submit" class="btn btn-primary btn-block btn-flat">
                {{ __('Login') }}
            </button>
        </div>
        <div class="col-xs-8">
            @if (Route::has('password.request'))
                <a class="btn btn-link" href="{{ route('password.request') }}">
                    {{ __('Forgot Your Password?') }}
                </a>
            @endif        
        </div>
        <!-- /.col -->
      </div>
    </form>

  </div>
  <!-- /.login-box-body -->
</div>

    </div>
</div>

@endsection
