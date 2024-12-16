<?php

// Função para verificar se o número já foi escolhido
if (!function_exists('isEscolhido')) {
    function isEscolhido($numero, $numerosEscolhidos)
    {
        return in_array($numero, $numerosEscolhidos);
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sorteio Ruan Gas</title>

    <!-- Link para Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;700&display=swap" rel="stylesheet">
    <style>
        /* Reset e estilo base */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

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
            background: linear-gradient(135deg, #6bff8c, #126a6e);
            border-radius: 15px;
            padding: 20px;
            max-width: 551px;
            width: 100%;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
            text-align: center;
            color: white;
            animation: fadeIn 1s ease-in-out;
        }

        h1 {
            font-size: 30px;
            margin-bottom: 20px;
        }

        input[type="text"] {
            width: 80%;
            padding: 12px;
            font-size: 18px;
            margin: 10px 0;
            border: 2px solid #fff;
            border-radius: 5px;
            outline: none;
            background-color: #fff;
            color: #333;
            transition: border-color 0.3s;
            text-align: center;
        }

        input[type="text"]:focus {
            border-color: #f06595;
        }

        button {
            background-color: #fff;
            color: #f06595;
            border: none;
            padding: 12px 20px;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s, color 0.3s;
            width: 80%;
        }

        button:hover {
            background-color: #f06595;
            color: white;
        }

        /* Estilo da barra de rolagem */
        .numero-container {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 1px;
            margin-top: 20px;
            max-height: 300px;
            overflow-y: auto;
            border-radius: 10px;
            /* Arredondamento */
            background: linear-gradient(135deg, #6bff8c, #126a6e);
        }

        /* Estilo da barra de rolagem */
        .numero-container::-webkit-scrollbar {
            width: 10px;
            /* Largura da barra */
        }

        .numero-container::-webkit-scrollbar-track {
            background: linear-gradient(135deg, #dcdcdc, #f1f1f1);
            /* Degradê no track */
            border-radius: 10px;
        }

        .numero-container::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #6bff8c, #126a6e);
            /* Degradê no thumb */
            border-radius: 10px;
            /* Arredondado */
        }

        .numero-container::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, #4ca472, #0f595c);
            /* Escurece no hover */
        }

        .numero-btn {
            background-color: #fff;
            color: #126a6e;
            border: 2px solid #fff;
            padding: 15px;
            font-size: 14px;
            text-align: center;
            border-radius: 50px;
            cursor: pointer;
            transition: background-color 0.3s, color 0.3s;
        }

        .numero-btn:hover {
            background-color: #126a6e;
            color: white;
        }

        .numero-btn:active {
            background-color: #f06595;
            color: white;
        }

        .disabled-btn {
            background-color: #dcdcdc;
            color: #888;
            cursor: not-allowed;
            position: relative;
        }

        .disabled-btn::after {
            content: "X";
            color: red;
            font-weight: bold;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 18px;
        }
    </style>
</head>

<body>

    <div class="container">
        <h2><?php echo $cliente->sorteio->nome; ?> </h2>
        <h1>Ruan Gas</h1>
        <p>Escolha um número da sorte para participar do sorteio incrível! Insira o número desejado e clique no botão
            para salvar sua escolha.</p>

        <!-- Informações do Sorteio -->
        <div class="info-sorteio">
            <p><strong>Número do Sorteio:</strong> <?php echo $cliente->sorteio->numero_sorteio; ?></p>
            <p><strong>Data de Início:</strong> <?php echo $cliente->sorteio->data_inicio_formatada; ?></p>
            <p><strong>Data de Término:</strong> <?php echo $cliente->sorteio->data_termino_formatada; ?></p>
        </div>
        <form action="{{ route('sorteio.salvarNumeroSorte', ['id' => $cliente->id]) }}" method="POST">
            @csrf <!-- Garante a proteção CSRF -->

            <!-- Input para escolher o número da sorte -->
            <input type="text" id="numeroSorte" name="numero_sorte" maxlength="4"
                placeholder="Digite seu número da sorte" oninput="validarNumero(this.value)">

            <!-- Botão para salvar a escolha -->
            <button type="submit">Salvar</button>
        </form>

    </div>

    <!-- Container para os botões de números -->
    <div class="numero-container container" id="numeroContainer">
        <?php
        // Loop para criar os botões de 1000 a 9999
        for ($i = 1000; $i <= 9999; $i++) {
            // Verifica se o número já foi escolhido
            $disabledClass = isEscolhido($i, $numerosEscolhidos) ? 'disabled-btn' : '';
            $onclick = isEscolhido($i, $numerosEscolhidos) ? '' : 'onclick="selecionarNumero(' . $i . ')"';
            echo '<div class="numero-btn ' . $disabledClass . '" ' . $onclick . '>' . $i . '</div>';
        }
        ?>
    </div>

    <script>
        // Números já escolhidos (deve ser sincronizado com o backend)
        const numerosEscolhidos = <?php echo json_encode($numerosEscolhidos); ?>;

        // Função para preencher o input com o número escolhido
        function selecionarNumero(numero) {
            document.getElementById("numeroSorte").value = numero;
        }

        // Função para validar o número digitado
        function validarNumero(numero) {
        // Verifica se o número digitado é válido (não vazio e numérico)
        if (numero.trim() === '') return;

        // Verifica se o número já foi escolhido
        if (numerosEscolhidos.includes(numero)) {
            alert("Número indisponível! Por favor, escolha outro número.");
            document.getElementById("numeroSorte").value = ""; // Limpa o campo de input
        }
    }

        // Função para salvar a escolha
        function salvarEscolha() {
            const numeroEscolhido = document.getElementById("numeroSorte").value;

            if (!numeroEscolhido) {
                alert("Por favor, escolha um número da sorte.");
                return;
            }

            // Lógica de salvar o número no backend pode ser implementada aqui
            alert("Número " + numeroEscolhido + " salvo com sucesso!");
        }
    </script>

</body>

</html>
