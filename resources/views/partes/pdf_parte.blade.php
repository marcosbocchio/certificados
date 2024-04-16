<!DOCTYPE html>
<html>
<head>
    <title>PDF Parte Manual</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            width: 100%;
            height: 10%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .header-logo {
            width: 40%;
        }
        .header-logo img {
            width: 100%;
            height: auto;
        }
        .header-info {
            width: 60%;
            text-align: center;
        }
        .header-info table {
            width: 100%;
        }
        .header-info td {
            padding: 5px;
            text-align: center;
        }
        .body {
            width: 100%;
            height: 70%;
            margin-bottom: 20px;
        }
        .footer {
            width: 100%;
            height: 20%;
            margin-top: 20px;
        }
        .footer-content {
            width: 100%;
            text-align: center;
        }
        .footer-content table {
            margin: 0 auto;
        }
        .footer-content td {
            padding: 5px;
            text-align: center;
        }
        .parte-manual {
            width: 100%;
            border-collapse: collapse;
        }
        .parte-manual th, .parte-manual td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        .parte-manual th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
<div class="container">
    <!-- Header -->
    <div class="header">
        <!-- Logo -->
        <div class="header-logo">
            <img src="https://www.enodndt.com/img/logo-enod-web.jpg" alt="Logotipo ENOD">
        </div>
        <!-- Información del parte diario -->
        <div class="header-info">
            <table>
                <tr>
                    <td>PARTE DIARIO</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>FECHA</td>
                </tr>
                <tr>
                    <td>HOJA X DE X</td>
                </tr>
            </table>
        </div>
    </div>

    <!-- Body -->
    <div class="body">
        <h1>Parte Manual</h1>
        <h2>Detalles:</h2>
        <table class="parte-manual">
            <thead>
                <tr>
                    <th>Técnica</th>
                    <th>Cantidad</th>
                    <th>Planta</th>
                    <th>Equipo/Linea</th>
                    <th>Horario</th>
                    <th>N° Informe</th>
                    <th>Operadores</th>
                </tr>
            </thead>
            <tbody>
                @foreach($detalles as $detalle)
                <tr>
                    <td>{{ $detalle->tecnica ?? '-' }}</td>
                    <td>{{ $detalle->cantidad ?? '-' }}</td>
                    <td>{{ $detalle->planta ?? '-' }}</td>
                    <td>{{ $detalle->equipo_linea ?? '-' }}</td>
                    <td>{{ $detalle->horario ?? '-' }}</td>
                    <td>{{ $detalle->n_informe ?? '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Footer -->
    <div class="footer">
        <div class="footer-content">
            <table>
                <tr>
                    <td colspan="2">Referencias</td>
                    <td colspan="2">Horarios</td>
                </tr>
                <tr>
                    <td colspan="2">CR -- GAMMAGRAFIADO DIGITAL</td>
                    <td colspan="2">LUNES A VIERNES - 7 A 16:30 HS</td>
                </tr>
                <tr>
                    <td colspan="2">ADM -- ADMINISTRATIVO</td>
                    <td colspan="2">A</td>
                </tr>
                <tr>
                    <td colspan="2">LP -- LIQUIDOS PENETRANTES</td>
                    <td colspan="2">LUNEAS A VIERNES - 7 A 19 HS</td>
                </tr>
                <tr>
                    <td colspan="2">PM -- PARTICULAS MAGNETICAS</td>
                    <td colspan="2">B</td>
                </tr>
                <!-- Agrega más filas según sea necesario -->
            </table>
        </div>
    </div>
</div>
</body>
</html>