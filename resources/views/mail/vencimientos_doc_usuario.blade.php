<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notificación : Vencimientos de documentación</title>
</head>
<body>
    <h3 style="color: ">Se notifica que el siguiente documento está proxímo a vencer.</h3>
    <p><strong>Usuario:</strong> {{ $item->name }}</p>
    <p><strong>Documento:</strong>  {{ $item->titulo }} </p>
    <p><strong>Fecha vencimiento:</strong> {{ date("d-m-Y", strtotime($item->fecha_caducidad)) }}</p>
</body>
</html>
