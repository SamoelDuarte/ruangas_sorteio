<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Link já Usado</title>
    <!-- Fonte personalizada e estilos -->
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Raleway', sans-serif;
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #333;
            flex-direction: column;
        }

        .container {
            background: linear-gradient(135deg, #ff6666, #ff9966);
            border-radius: 15px;
            padding: 20px;
            max-width: 500px;
            width: 100%;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
            text-align: center;
            color: white;
            animation: fadeIn 1s ease-in-out;
        }

        h1 {
            font-size: 32px;
            margin-bottom: 20px;
        }

        p {
            font-size: 18px;
            margin: 10px 0;
        }

        .numero-sorte {
            font-size: 24px;
            font-weight: bold;
            color: #ffcf48;
        }

        .btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #fff;
            color: #ff6666;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s, color 0.3s;
        }

        .btn:hover {
            background-color: #ff6666;
            color: white;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>

    <div class="container">
        <h1>Oi, {{ $cliente->nome }}!</h1>
        <p>Você já escolheu o número da sorte:</p>
        <div class="numero-sorte">{{ $cliente->numero_da_sorte }}</div>
        <p>Boa sorte no sorteio! Você está dentro da competição.</p>
    </div>

</body>

</html>
