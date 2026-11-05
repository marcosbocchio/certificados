<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sin acceso</title>
    <style>
        html, body { margin: 0; height: 100%; background: #f6f7f9; font-family: 'Montserrat', 'Segoe UI', Arial, sans-serif; color: #1a1a1a; }
        .caja { min-height: 100%; display: flex; align-items: center; justify-content: center; padding: 16px; box-sizing: border-box; }
        .tarjeta { background: #fff; border: 1px solid #eef0f3; border-top: 3px solid #FFCC00; border-radius: 4px; box-shadow: 0 1px 3px rgba(0,0,0,.06); max-width: 520px; width: 100%; padding: 28px 30px; }
        h1 { font-size: 20px; margin: 0 0 10px; }
        p { font-size: 14px; line-height: 1.6; color: #4c5661; margin: 0 0 10px; }
        .acciones { margin-top: 18px; display: flex; gap: 10px; flex-wrap: wrap; }
        a.btn { display: inline-block; padding: 9px 18px; border-radius: 6px; font-size: 13px; font-weight: 700; text-decoration: none; border: 1px solid #FFCC00; background: #FFCC00; color: #1a1a1a; }
        a.btn.sec { background: #fff; border-color: #d6dce3; }
        a.btn:hover { box-shadow: 0 2px 8px rgba(255,204,0,.45); }
    </style>
</head>
<body>
<div class="caja">
    <div class="tarjeta">
        <h1>No tenés acceso a esta pantalla</h1>
        <p>{{ $exception->getMessage() ?: 'Tu usuario no tiene habilitada esta pantalla.' }}</p>
        <p>Si lo necesitás para trabajar, pedile a quien administra los accesos que te asigne a la OT o que revise tus roles.</p>
        <div class="acciones">
            <a class="btn" href="{{ url('/area/enod') }}">Volver al tablero</a>
            <a class="btn sec" href="javascript:history.back()">Volver atrás</a>
            @if(auth()->check() && auth()->user()->canany(['M_roles', 'M_roles_edita', 'M_usuarios', 'M_usuarios_edita']))
                <a class="btn sec" href="{{ route('ayuda-guia-no-veo') }}">Ver guía de roles</a>
            @endif
        </div>
    </div>
</div>
</body>
</html>
