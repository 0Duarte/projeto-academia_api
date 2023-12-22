<!-- resources/views/pdfs/workoutPdf.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Treinos</title>
    <style>
        /* Adicione estilos CSS aqui */
        *{
            font-family: sans-serif;
        }
        .divider{
            margin-bottom: 3rem
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;

        }
    </style>
</head>
<body>

    <h1>Treinos de {{ $student_name }}</h1>
    <hr>
    <div class="divider"></div>
    @forelse($workouts as $day => $dayWorkouts)
    <h2>{{ mb_convert_case($day, MB_CASE_TITLE, 'UTF-8') }}</h2>



        @if (!empty($dayWorkouts))
            <table>
                <tr>
                    <th>Exercício</th>
                    <th>Repetições</th>
                    <th>Peso (kg)</th>
                    <th>Tempo de Descanso (minutos)</th>
                    <th>Observações</th>
                    <th>Tempo (minutos)</th>

                </tr>
                @forelse($dayWorkouts as $workout)
                    <tr>
                        <td>
                            @if ($workout['exercise'])
                                {{ $workout['exercise']['description'] ?? 'Não definido' }}
                            @else
                                Não associado
                            @endif
                        </td>
                        <td>{{ $workout['repetitions'] ?? 'Não definido' }}</td>
                        <td>{{ $workout['weight'] ?? 'Não definido' }}</td>
                        <td>{{ $workout['break_time'] ?? 'Não definido' }}</td>
                        <td>{{ $workout['observations'] ?? '' }}</td>
                        <td>{{ $workout['time'] ?? 'Não definido' }}</td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="6">Nenhum treino registrado para este dia.</td>
                    </tr>
                @endforelse
            </table>
            <span class="divider"></span>
        @else
            <p>Nenhum treino registrado para este dia.</p>
        @endif

    @empty
        <p>Nenhum treino registrado.</p>
    @endforelse

</body>
</html>
