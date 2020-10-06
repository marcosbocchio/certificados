@extends('layouts.app')

@section('content')
<div class="container" style='height:100%'>

    <div class="grandParentContaniner">
        <div class="login-box" style="width: 400px !important">
      <!-- /.login-logo -->
      <div class="login-box-body">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @else
            <p class="login-box-msg" >Restablecimiento de contraseña</p>
        @endif

        <form method="POST" action="{{ route('password.email') }}" autocomplete="off" id="formEmail">
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
                        <button id="btnsendlink" type="submit" class="btn btn-primary">
                            <i id="active" class="fa fa-spin"></i>
                            &nbsp;  {{ __('Send Password Reset Link') }}
                        </button>
                    </div>
                </div>
            </div>
        </form>
      </div>
      <!-- /.login-box-body -->
      <div class="login-logo">
        <a href="http://www.enodndt.com.ar/"><img src="{{asset('img/redes.png')}}"  height="90px"  alt="Redes Enod"> </a>
      </div>
    </div>

    </div>
</div>

@endsection

