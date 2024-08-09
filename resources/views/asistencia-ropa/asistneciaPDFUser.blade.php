<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Control Asistencia</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .header-table td {
            padding: 5px;
            vertical-align: top;
        }

        .logo img {
            width: 150px;
        }

        .title {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
        }

        .date {
            text-align: right;
            font-size: 16px;
        }

        .separator {
            height: 3px;
            background-color: rgb(255, 204, 0);
            margin-top: 10px;
        }

        .content-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .content-table th, .content-table td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        .content-table th {
            background-color: #f4f4f4;
            text-align: left;
        }

        .content-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .content-table tr:hover {
            background-color: #f1f1f1;
        }

        .content-table td {
            vertical-align: middle;
        }

        .content-title {
            font-size: 18px;
            font-weight: bold;
            margin-top: 30px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <table class="header-table">
            <tr>
                <td class="logo">
                    <img src="{{ public_path('img/logo-enod-web.jpg') }}" alt="Logotipo ENOD">
                </td>
                <td class="title">CONTROL ASISTENCIA</td>
                <td class="date"><b>FECHA:</b> {{ $fecha}}</td>
            </tr>
        </table>
        <div class="separator"></div>
    </header>

    <!-- Content -->
    <div class="content">
        <h2 class="content-title">Detalles del Operador</h2>
        <table class="content-table">
            <tr>
                <th>Nombre del Operador</th>
                <th>Horas Diarias Laborables</th>
                <th>Fecha Seleccionada</th>
            </tr>
            <tr>
                <td>{{ $operador->name }}</td>
                <td>{{ $frente->horas_diarias_laborables }}</td>
                <td>{{ $fecha}}</td>
            </tr>
        </table>
    </div>
</body>
</html>