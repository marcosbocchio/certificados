<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notificación : Demora carga dosimetría</title>
</head>
<body>
    <p>Se notifica que el usuario {{ $user->name }} tiene demoras en las cargas de dosimetría en las siguientes fechas : </p>
    <ul>
        @foreach ($fechas_demoras as $fecha)
            <li>
                {{ date("d-m-Y", strtotime( $fecha)) }}
            </li>
        @endforeach
    </ul>

</body>
</html>
