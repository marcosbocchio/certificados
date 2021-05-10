@extends('layouts.enod.master')

@section('contenido')

<div class="ayuda_enod">
       <div class="row">
        <div class="col-md-12">
            <h1>Cómo cambiar o restablecer la contraseña de tu cuenta</h1>
            <p>Para iniciar sesión en tu cuenta debes usar el <strong>correo</strong> y la <strong>contraseña</strong>&nbsp;con la que estas registrado en la aplicacion de&nbsp;&nbsp;<a href="http://sigoenod.com/" target="_blank" ><strong>Enod</strong></a>. Esta información la puedes cambiar en cualquier momento.</p>
            <h2>Cambia la contraseña de tu cuenta</h2>
            <p>Si deseas cambiar la contraseña de tu cuenta de <a href="http://sigoenod.com" target="_blank"><strong>Enod</strong>&nbsp;</a>, sigue estos pasos:</p>
            <ol>
              <li>Dirígete al nombre de tu usuario en la parte superior derecha y haz click</li>
              <li>Haz click en <strong>Perfil</strong></li>
              <li>Haz click en <strong>cambiar contraseña</strong></li>
              <li>Ingresa tu contraseña actual, luego la nueva contraseña y repite esta última</li>
              <li>Haz click en <strong>Guardar</strong>&nbsp;</li>
            </ol>

          </div>
          <div class="col-md-12">
            <p>Así:</p>
          </div>

          <div class="col-md-6 col-md-offset-3">
            <img  class="img-responsive" src="{{ asset('img/ayuda/Cambiar_clave.gif') }}"  alt="img-clave"/>

          </div>

          <div class="col-md-12">
            <h2>¿Olvidate tu contraseña ?&nbsp;</h2>
            <p>Si olvidaste tu contraseña no te preocupes, puedes restablecerla siguiendo estos pasos:</p>
            <ol>
              <li>Ingresa a <a href="http://sigoenod.com" target="_blank"><strong>Enod</strong> </a></li>
              <li>Haz Click en <strong>¿Olvidó su contraseña?</strong></li>
              <li>Introduzca su correo y has click en <strong>Restablecer</strong></li>
              <li>Le enviaremos un correo con el link y las instrucciones para restrablecer su contraseña</li>
              <li>Ingrese una nueva contraseña y has click en restablecer </li>
            </ol>
          </div>
      </div>
</div>

@endsection
