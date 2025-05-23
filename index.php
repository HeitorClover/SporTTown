<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Inicial</title>
    <!-- Font Awesome para ícones -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        /* Reset básico */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;

            /* Configuração do plano de fundo */
            background-image: url('imagens/home (5).png'); /* Substitua pelo caminho real da imagem */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            position: relative; /* Para permitir o posicionamento absoluto da imagem */
        }

        /* Posicionamento da imagem no canto superior esquerdo */
        .logo-container {
            position: absolute;
            top: 20px; /* Ajusta a distância do topo */
            left: 20px; /* Ajusta a distância da esquerda */
            z-index: 1; /* Garante que a imagem fique acima dos outros elementos */
        }

        .logo {
            max-width: 200px; /* Define o tamanho máximo da imagem */
            height: auto; /* Mantém a proporção da imagem */
        }

        h2 {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 30px;
            text-align: center;
            color: #fff; /* Texto branco para visibilidade sobre o plano de fundo */
            letter-spacing: 1px;
        }

        .button-container {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
            justify-content: center;
        }

        button {
            background-color: rgba(76, 110, 245, 0.8); /* Azul com transparência para visibilidade sobre o plano de fundo */
            color: white;
            border: none;
            padding: 15px 30px;
            font-size: 1rem;
            font-weight: 500;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        button:hover {
            background-color: rgba(59, 91, 219, 0.8);
            transform: translateY(-3px);
            box-shadow: 0 6px 10px rgba(0, 0, 0, 0.15);
        }

        button:active {
            background-color: rgba(44, 64, 155, 0.8);
            transform: translateY(0);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        button i {
            font-size: 1.2rem;
        }

        @media (max-width: 600px) {
            h2 {
                font-size: 2rem;
            }

            button {
                padding: 12px 25px;
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
    <!-- Título -->
    <h2>Gerenciamento de Estudantes</h2>

    <br><br><br>

    <!-- Botões -->
    <div class="button-container">
        <button onclick="window.location.href='router.php?rota=cadastrar'">
            <i class="fa-solid fa-user-plus"></i> Cadastrar Estudante
        </button>
        <button onclick="window.location.href='router.php?rota=listar'">
            <i class="fa-solid fa-list"></i> Listar Estudantes
        </button>
        <button onclick="window.location.href='router.php?rota=deletar'">
            <i class="fa-solid fa-trash"></i> Excluir Estudantes
        </button>
        <button onclick="window.location.href='router.php?rota=atualizar'">
            <i class="fa-solid fa-pen-to-square"></i> Atualizar Estudantes
        </button>
    </div>
</body>
</html>