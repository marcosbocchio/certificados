@extends('layouts.enod.master')

@section('contenido')

<div id="amb" class="row">
    <div class="col-sm-12">
        <table class="table table-hover table-striped">
            <thead>
            <tr>
                <th>ID</th>
                <th>Usuario</th>
                <th>Nombre</th>
                <th>Email</th>
                <th colspan="2">&nbsp;</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="registro in registros">
                <td width="10px">@{{ registro.id }}</td>
                <td>@{{ registro.codigo }}</td>
                <td>@{{ registro.name }}</td>
                <td>@{{ registro.email }}</td>
                <td><a href="#" class="btn btn-warning btn-sm" title="Editar" v-on:click.prevent="editKeep(keep)"><span class="fa fa-edit"></span></a>
                    <a href="#" class="btn btn-danger btn-sm" title="Eliminar "v-on:click.prevent="confirmDeleteKeep(keep)"><span class="fa fa-trash"></span></a>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="col-sm-5">
		<pre>
			@{{ $data }}
		</pre>
    </div>
</div>
@endsection


@section('script')
<script type="text/javascript" src="{{asset('js/app.js')}}"></script>
<script type="text/javascript" src="{{asset('js/vue/app.js')}}"></script>

@endsection