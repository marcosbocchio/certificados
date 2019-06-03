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
<div class="container">
      <h2>Edit Glyph</h2>
      <p>Edit icon: <span class="glyphicon glyphicon-edit"></span></p>
      <p>Edit icon as a link:
        <a href="#">
          <span class="glyphicon glyphicon-edit"></span>
        </a>
      </p>
      <p>Edit icon on a button:
        <button type="button" class="btn btn-default btn-sm">
          <span class="glyphicon glyphicon-edit"></span> Edit
        </button>
      </p>
      <p>Edit icon on a styled link button:
        <a href="#" class="btn btn-info btn-lg">
          <span class="glyphicon glyphicon-edit"></span> Edit
        </a>
      </p>
      <p>Unicode:
        <span class="glyphicon">&#xe065;</span>
      </p>
    </div>
@endsection


@section('script')
  <script type="text/javascript" src="{{asset('js/vue/vue.js')}}"></script>
  <script type="text/javascript" src="{{asset('js/vue/axios.js')}}"></script>
  <script type="text/javascript" src="{{asset('js/vue/app.js')}}"></script>

@endsection
