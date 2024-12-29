<!DOCTYPE html>
<html>
<head>
    <title>Listado de Contratos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12pt;
        }
        h1 {
            font-size: 18pt;
        }
        table {
            font-size: 10pt;
            width: 100%;
            border-collapse: collapse;
        }
        th {
            background-color: #f3f4f6;
            font-weight: bold;
            text-align: left;
            padding: 8px;
        }
        td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }
    </style>
</head>
<body>
    <h1>Listado de Registros</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre Titular</th>
                <th>CUPS</th>
                <th>TAR</th>
                <th>Consumo</th>
                <th>Comercializadora</th>
            </tr>
        </thead>
        <tbody>
            @foreach($records as $record)
                <tr>
                    <td>{{ $record->id }}</td>
                    <td>{{ $record->nombre_titular}}</td>
                    <td>{{ substr($record->cups, -6) }}</td>
                    <td>{{ $record->tarifa_acceso}}</td>
                    <td>{{ number_format($record->consumo_anual, 0, ',', '.') }}</td>
                    <td>{{ $record->comercializadora->nombre}}</td>                    
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>