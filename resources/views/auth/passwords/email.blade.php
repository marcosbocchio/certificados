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
    <p class="login-box-msg" >Recupear contraseña</p>

     <form method="POST" action="{{ route('password.email') }}" autocomplete="off">
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
    <div class="row">
      <div class="form-group">
        <div class="col-md-4"  style="text-align: center;margin-top: 8px;" >
            <button type="submit" class="btn btn-primary">
                {{ __('Send Password Reset Link') }}
            </button>
        </div>
      </div>
      </div>

     </form>
@endsection
