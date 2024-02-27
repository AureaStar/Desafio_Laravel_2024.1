<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Consultas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>Relatório de Consultas</h1>
            <p><strong>Médico:</strong> {{$user->name}}</p>
            <p><strong>Data e Hora da Emissão:</strong> {{$datetime}}</p>
        </header>
        <main>
            <h2>Consultas Realizadas</h2>
            <table>
                <thead>
                    <tr>
                        <th>Mês</th>
                        <th>Paciente</th>
                        <th>Especialidade</th>
                        <th>Data</th>
                        <th>Custo</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($appointments as $appointment)
                        <tr>
                            <td>{{date('m/Y', strtotime($appointment->procedure_start))}}</td>
                            <td>{{$appointment->patient->user->name}}</td>
                            <td>{{$appointment->specialty->name}}</td>
                            <td>{{date('d/m/Y', strtotime($appointment->procedure_start))}}</td>
                            <td>R$ {{$appointment->price}}</td>
                        </tr>
                        
                    @endforeach
                </tbody>
            </table>
        </main>
    </div>
</body>
</html>
