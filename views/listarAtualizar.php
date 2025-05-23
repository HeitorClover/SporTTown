<?php
require_once 'controllers/Controller.php';
$controller = new Controller();

$nomePesquisa = $_GET['nome'] ?? '';
$estudantes = $nomePesquisa ? $controller->buscarPorNome($nomePesquisa) : $controller->listar();

if(isset($_GET['ajax_search'])) {
    try {
        $nomePesquisa = $_POST['nome'] ?? '';
        $estudantes = $controller->buscarPorNome($nomePesquisa);
        
        ob_start();
        if (!empty($estudantes)): ?>
            <table border="1">
                <tr>
                    <th>Matrícula</th>
                    <th>Nome</th>
                    <th>Curso</th>
                    <th>Ano de Ingresso</th>
                    <th>Ações</th>
                </tr>
                <?php foreach ($estudantes as $estudante): ?>
                    <tr>
                        <td><?= htmlspecialchars($estudante->matricula) ?></td>
                        <td><?= htmlspecialchars($estudante->nome) ?></td>
                        <td><?= htmlspecialchars($estudante->curso) ?></td>
                        <td><?= htmlspecialchars($estudante->ano_ingresso) ?></td>
                        <td>
                            <a href="router.php?rota=formAtualizar&matricula=<?= $estudante->matricula ?>">
                           Atualizar
                        </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php else: ?>
            <p><?= $nomePesquisa ? 'Nenhum estudante encontrado.' : 'Nenhum estudante cadastrado.' ?></p>
        <?php endif;
        
        echo ob_get_clean();
        exit;
        
    } catch(Exception $e) {
        http_response_code(500);
        echo "Erro no servidor: " . $e->getMessage();
        exit;
    }
}

?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Lista de Estudantes</title>
    <style>
        /* Reset básico */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-image: url('imagens/Home (6).png'); /* Substitua pelo caminho real da imagem */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            position: relative;
        }

        h2 {
            font-size: 2rem;
            margin-bottom: 20px;
            text-align: center;
            color: #2F4F4F;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background-color: #fff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #2F4F4F;
        }

        th {
            background-color: #2F4F4F;
            color: white;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        td {
            color: #333;
        }

        tr:hover {
            background-color:rgb(140, 144, 148);
        }

        td a {
            color: #2F4F4F;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s ease;
        }

        td a:hover {
            color:rgb(2, 37, 37);
        }

        p {
            text-align: center;
            font-size: 1.2rem;
            color: #666;
        }
        
        .search-container{
            text-align: center;
            padding-bottom: 15px;
            color: white;
            border: none;
        }

        button {
            display: block;
            margin: 20px auto;
            background-color: #2F4F4F;
            color: white;
            border: none;
            padding: 12px 24px;
            font-size: 1rem;
            font-weight: 500;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        button:hover {
            background-color: #2F4F4F;
            transform: translateY(-2px);
            box-shadow: 0 6px 10px rgba(0, 0, 0, 0.15);
        }

        button:active {
            background-color: rgb(9, 59, 59);
            transform: translateY(0);
            box-shadow: 0 4px 6px #2F4F4F;
        }

        @media (max-width: 768px) {
            table {
                font-size: 0.9rem;
            }

            th, td {
                padding: 10px;
            }

            button {
                padding: 10px 20px;
                font-size: 0.9rem;
            }
        }

        #searchInput{
            display: block;
            margin: 20px auto;
            background-color:rgb(5, 54, 54);
            color: white;
            border: none;
            padding: 12px 24px;
            font-size: 1rem;
            font-weight: 500;
            border-radius: 8px;
        }
    </style>
</head>
<body>
    <h2>Lista de Estudantes</h2>
    
    <div class="search-container">
        <input type="text" id="searchInput" placeholder="Digite para pesquisar..." 
               value="<?= htmlspecialchars($nomePesquisa) ?>" autocomplete="off">
        <span id="loading">Carregando...</span>
        <div id="error"></div>
    </div>
    
    <div id="results">
        <?php if (!empty($estudantes)): ?>
            <table>
                <tr>
                    <th>Matrícula</th>
                    <th>Nome</th>
                    <th>Curso</th>
                    <th>Ano de Ingresso</th>
                    <th>Ações</th>
                </tr>
                <?php foreach ($estudantes as $estudante): ?>
                    <tr>
                        <td><?= htmlspecialchars($estudante->matricula) ?></td>
                        <td><?= htmlspecialchars($estudante->nome) ?></td>
                        <td><?= htmlspecialchars($estudante->curso) ?></td>
                        <td><?= htmlspecialchars($estudante->ano_ingresso) ?></td>
                        <td>
                            <a href="router.php?rota=formAtualizar&matricula=<?= $estudante->matricula ?>">
                           Atualizar
                        </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php else: ?>
            <p><?= $nomePesquisa ? 'Nenhum estudante encontrado.' : 'Nenhum estudante cadastrado.' ?></p>
        <?php endif; ?>
    </div>
    
    <button onclick="window.location.href='index.php'">Voltar ao Menu</button>

    <script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const resultsDiv = document.getElementById('results');
    const errorDiv = document.getElementById('error');
    
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.trim();
        
        fetch(`router.php?rota=buscar_Atualizar&nome=${encodeURIComponent(searchTerm)}`, {
            headers: {
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) throw new Error('Erro na rede');
            return response.json();
        })
        .then(data => {
            if (data.success) {
                resultsDiv.innerHTML = data.html;
                errorDiv.style.display = 'none';
            } else {
                throw new Error(data.error || 'Erro desconhecido');
            }
        })
        .catch(error => {
            errorDiv.textContent = error.message;
            errorDiv.style.display = 'block';
            console.error('Erro:', error);
        });
    });
});
</script>

</body>
</html>