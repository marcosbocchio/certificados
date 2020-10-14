@extends('layouts.enod.master')

@section('contenido')



<div class="row">

    <div class="col-md-8 col-md-offset-2">
        @include('flash-message')
        <div class="box box-custom-enod">
            <div class="box-body">

                <form class="form-horizontal" method="POST" action="{{ route('users.updatePerfil', $user->id) }}">

                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Nombre</label>

                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="name" placeholder="Name" value="{{ $user->name }}" maxlength="30">
                        </div>
                    </div>

                    <div class="form-group">
                    <label for="email" class="col-sm-2 control-label">Email</label>

                    <div class="col-sm-10">
                        <input type="email" class="form-control" name="email" placeholder="Email" value="{{ $user->email }}">
                    </div>
                    </div>

                    <div class="form-group">
                    <label for="dni" class="col-sm-2 control-label">DNI</label>

                    <div class="col-sm-10">
                        <input type="number" class="form-control" name="dni" placeholder="Dni" value="{{ $user->dni }}">
                    </div>
                    </div>

                    @if (!$user->cliente)

                        <div class="form-group">
                            <label for="film" class="col-sm-2 control-label">Film</label>

                            <div class="col-sm-10">
                                <input type="number" class="form-control" name="film" placeholder="" value="{{ $user->film }}" disabled>
                            </div>
                        </div>

                    @endif

                    @if ($user->cliente)

                            <div class="form-group">
                                <label for="cliente" class="col-sm-2 control-label">Cliente</label>

                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="cliente" placeholder="" value="{{ $cliente->nombre_fantasia }}" disabled>
                                </div>
                            </div>

                      @endif

                    <div class="form-group">
                        <label for="password" class="col-sm-2 control-label">Contraseña</label>

                        <div class="col-sm-10">
                        <input type="password" class="form-control" name="password" value="********">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation" class="col-sm-2 control-label">Repetir contraseña</label>

                        <div class="col-sm-10">
                        <input type="password" class="form-control" name="password_confirmation" value="********">
                        </div>
                    </div>

                    <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>
@endsection



