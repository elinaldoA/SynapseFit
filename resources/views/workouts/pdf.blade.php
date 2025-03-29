<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meus Treinos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 2px;
            color: #2C3E50;
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
        }

        h3 {
            color: #3498DB;
            margin-top: 40px;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #BDC3C7;
            font-size: 12px;
        }

        th {
            background-color: black;
            color: white;
        }

        td {
            background-color: #ECF0F1;
        }

        .table-container {
            page-break-inside: avoid; /* Impede quebras de página dentro da tabela */
            margin-bottom: 40px;
        }

        .footer {
            text-align: center;
            margin-top: 50px;
            font-size: 10px;
            color: #7F8C8D;
        }

        /* Ajuste para garantir que o conteúdo da tabela não quebre */
        table, th, td {
            page-break-inside: auto;
        }

        /* Estilo de rodapé */
        .footer p {
            margin: 0;
        }

        /* Reduzir margens para garantir melhor aproveitamento da página */
        @page {
            margin: 20mm;
        }

    </style>
</head>
<body>

    <h1>Meus Treinos</h1>

    @foreach ($groupedWorkouts as $type => $workouts)
        <div class="table-container">
            <h3>Ficha {{ $type }}</h3>
            <table>
                <thead>
                    <tr>
                        <th>Exercício</th>
                        <th>Séries</th>
                        <th>Repetições</th>
                        <th>Descanso</th>
                        <th>Carga</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($workouts as $workout)
                        <tr>
                            <td>{{ $workout->exercise->name }}</td>
                            <td>{{ $workout->series }}</td>
                            <td>{{ $workout->repeticoes }}</td>
                            <td>{{ $workout->descanso }} seg</td>
                            <td>{{ $workout->carga ? $workout->carga . ' kg' : 'Livre' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endforeach

    <div class="footer">
        <h2>Treinos gerados por <strong>SynapseFit App</strong> - Todos os direitos reservados.</h2>
    </div>

</body>
</html>
