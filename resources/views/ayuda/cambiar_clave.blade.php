@extends('layouts.enod.master')

@section('contenido')

<div id="app">
<div class="ayuda_enod">
    <div class="ayuda_panel">
        <h1>Como cambiar o restablecer la contrasena de tu cuenta</h1>
        <p>
            Para iniciar sesion en tu cuenta debes usar el correo y la contrasena con la que estas registrado en la aplicacion.
            Esta informacion se puede cambiar cuando sea necesario.
        </p>
    </div>

    @include('ayuda.partials.functional_summary')

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Cambiar la contrasena de tu cuenta</h2>
            <p>Si deseas cambiar la contrasena de tu cuenta, sigue estos pasos:</p>
            <ol>
                <li>Dirigete al nombre de tu usuario en la parte superior derecha y haz click.</li>
                <li>Haz click en <strong>Perfil</strong>.</li>
                <li>Ubica la seccion de cambio de contrasena.</li>
                <li>Ingresa tu contrasena actual, luego la nueva contrasena y repitela para confirmar.</li>
                <li>Haz click en <strong>Guardar</strong>.</li>
            </ol>
            <ayuda-demo-cambio-clave></ayuda-demo-cambio-clave>
        </div>
    </section>

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Olvidaste tu contrasena</h2>
            <p>Si olvidaste tu contrasena, puedes restablecerla siguiendo estos pasos:</p>
            <ol>
                <li>Ingresa a la pantalla de acceso.</li>
                <li>Haz click en <strong>Olvido su contrasena</strong>.</li>
                <li>Introduce tu correo y haz click en <strong>Restablecer</strong>.</li>
                <li>Recibiras un correo con el link y las instrucciones para restablecer tu contrasena.</li>
                <li>Ingresa una nueva contrasena y completa el proceso.</li>
            </ol>
            <h3>Articulos relacionados</h3>
            <ul class="ayuda_links">
                <li><a href="{{ route('ayuda-perfil') }}">Perfil de usuario</a></li>
            </ul>
        </div>
    </section>
</div>
</div>

@endsection
