<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bem-vindo à GymPro</title>

    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            text-align: center;
            background-color: #ffffff;
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #333;
        }

        strong {
            color: #555;
        }

        p {
            color: #555;
        }

        .footer {
            color: #777;
            margin-top: 20px;
        }

        .logo {
            margin-top: 20px;
            width: 20rem;
        }
    </style>
</head>
<body>
    @php
    if ($NewUser['plan_id'] === 1) {
        $current_user_plan = 'Bronze';
        $students = '10 estudantes';
    } elseif ($NewUser['plan_id'] === 2) {
        $current_user_plan = 'Prata';
        $students = '20 estudantes';

    } else {
        $current_user_plan = 'Ouro';
        $students = 'estudantes ilimitados';
    }
@endphp

    <div class="container">
        <h1>Bem-vindo à GymPro!</h1>
        <p>Olá <strong>{{ $NewUser['name'] }}</strong>,</p>

        <p>Estamos empolgados por você ter você treinando conosco. Agradecemos por escolher nosso serviço.</p>
        <p>Você assinou o plano <strong>{{$current_user_plan}}</strong> e possui <strong>{{$students}}</strong></p>
        <p>Por favor, sinta-se à vontade para explorar todas as funcionalidades do nosso sistema.</p>
        <p>Se você tiver alguma dúvida ou precisar de assistência, não hesite em entrar em contato.</p>
        <br>
        <p class="footer">Atenciosamente</p>
        <img src="https://i.ibb.co/0JM4TmV/logolaranja.png" alt="Logo da GymPro" class="logo">
    </div>

</body>
</html>
