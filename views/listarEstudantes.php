<?php
require_once 'controllers/Controller.php';
$controller = new Controller();
$nomePesquisa = $_GET['nome'] ?? '';
$estudantes = $nomePesquisa ? $controller->buscarPorNome($nomePesquisa) : $controller->listar();
$nomePesquisa = $_GET['nome'] ?? '';
$cursoFiltro = $_GET['curso'] ?? '';
$anosIngresso = $controller->listarAnosIngresso();
$cursoSerie = $_GET['ano_ingresso'] ?? '';



if (!empty($nomePesquisa) || !empty($cursoFiltro) || !empty($cursoSerie)) {
    
    $estudantes = $controller->buscarPorAnoCursoNome($nomePesquisa, $cursoFiltro, $cursoSerie);

} else {
    $estudantes = $controller->listar();
}



$rota = $_GET['rota'] ?? '';
if (isset($_GET['ajax_search']) || $rota === 'buscar_ajax_listar') {
    try {
        $nomePesquisa = $_GET['nome'] ?? '';
        $estudantes = $controller->buscarPorNome($nomePesquisa);

        foreach ($estudantes as $estudante) {
    $estudante->responsaveis = $controller->buscarResponsaveis($estudante->id);
}
        ob_start();
        if (!empty($estudantes)) {
           ?>
    <table>
    <thead>
        <tr>
            <th>Matrícula</th>
            <th>Nome</th>
            <th>Curso</th>
            <th>Ano</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($estudantes)): ?>
            <?php foreach ($estudantes as $estudante): ?>
                <tr>
                    <td><?= $estudante->matricula ?></td>
                    <td><?= $estudante->nome ?></td>
                    <td><?= $estudante->curso ?></td>
                    <td><?= $estudante->ano_ingresso ?></td>
                    <td>
                        <button id="btn-toggle-<?= $estudante->id ?>" onclick="toggleSubrow(<?= $estudante->id ?>)">
                            Ver Responsáveis
                        </button>
                    </td>
                </tr>
                <tr id="responsaveis-<?= $estudante->id ?>" class="subrow" style="display: none;">
                    <td colspan="5">
                        <table>
                            <thead>
                                <tr>
                                    <th>Nome do Responsável</th>
                                    <th>Contato</th>
                                    <th>Parentesco</th>
                                    <th>WhatsApp</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($estudante->responsaveis)): ?>
                                <?php foreach ($estudante->responsaveis as $responsavel): ?>
                                    
    <tr>
        <td><?= $responsavel->nome ?></td>
        <td><?= $responsavel->contato ?></td>
        <td><?= $responsavel->parentesco ?></td>
        <td>
           <form action="">
           <button> <a href="https://wa.me/55<?= preg_replace('/\D/', '', $responsavel->contato) ?>" target="_blank">
        Fale via WhatsApp
    </a></button>
           </form> 
        </td>
        <td>
            <form method="POST" action="router.php?rota=deletar_responsavel">
                <input type="hidden" name="deletar_responsavel" value="<?= $responsavel->id ?>">
                <button type="submit" onclick="return confirm('Tem certeza que deseja excluir este estudante?');">Excluir</button> 
            </form>
        </td>
    </tr>
<?php endforeach; ?>
                                <?php else: ?>
    <tr>
        <td colspan="4">Nenhum responsável encontrado.</td>
    </tr>
<?php endif; ?>
                            </tbody>
                        </table>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="3">Nenhum estudante encontrado.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
    <?php
        } else {
            echo $nomePesquisa ? 'Nenhum estudante encontrado.' : 'Nenhum estudante cadastrado.';
        }
        $html = ob_get_clean();

        echo json_encode(['success' => true, 'html' => $html]);
        exit;
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        exit;
    }
}
// Para cada estudante, busque seus responsáveis
foreach ($estudantes as $estudante) {
    $estudante->responsaveis = $controller->buscarResponsaveis($estudante->id);
   
}?>

<!DOCTYPE html>
<html lang="pt-br">
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
            background-image: url('imagens/Home (6).png');  
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            position: relative;
        }

        h2 {
            font-size: 3em;
            margin-bottom: 20px;
            text-align: center;
            color: #2F4F4F;
            margin-right: 5px;
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


        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background-color:rgb(248, 248, 248);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }

       
        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #2F4F4F ;
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

        p {
            text-align: center;
            font-size: 1.2rem;
            color: #666;
        }

       button {
            display: block;
            margin: 10px auto;
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
    </style>
    <script>
        function toggleSubrow(id) {
            var row = document.getElementById('responsaveis-' + id);
            var button = document.getElementById('btn-toggle-' + id);

            if (row.style.display === "none" || row.style.display === "") {
                row.style.display = "table-row";
                button.textContent = "Esconder Responsáveis";
            } else {
                row.style.display = "none";
                button.textContent = "Ver Responsáveis";
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const resultsDiv = document.getElementById('results2'); // Agora aponta para results2
    const errorDiv = document.getElementById('error');
    
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.trim();
        
        fetch(`router.php?rota=buscar_ajax_listar&nome=${encodeURIComponent(searchTerm)}`, {
           

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
                console.log(data.html); // Verificar o conteúdo recebido
                resultsDiv.innerHTML = data.html; // Atualiza a nova div
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

    function limparBuscaENviar(formId) {
        // Limpa a busca por nome ao aplicar filtros
        const searchInput = document.getElementById('searchInput');
        if (searchInput) {
            searchInput.value = '';
        }

        document.getElementById(formId).submit();
    }


    </script>
</head>
<body>

  <h2>Lista de Estudantes</h2>
    
   <div class="search-container">
    <input type="text" id="searchInput" placeholder="Digite para pesquisar..." 
           value="<?= htmlspecialchars($nomePesquisa) ?>" autocomplete="off">

    <div id="error" style="display: none; color: red;"></div>

    <form method="GET" id="filtroForm">
        <label for="curso">Filtrar por Curso:</label>
        <select name="curso" id="curso" onchange="document.getElementById('filtroForm').submit()">
            <option value="">Todos os Cursos</option>
            <option value="Administração" <?= ($cursoFiltro === 'Administração') ? 'selected' : '' ?>>Administração</option>
            <option value="Enfermagem" <?= ($cursoFiltro === 'Enfermagem') ? 'selected' : '' ?>>Enfermagem</option>
            <option value="Des. Sistemas" <?= ($cursoFiltro === 'Des. Sistemas') ? 'selected' : '' ?>>Des. Sistemas</option>
            <option value="Informática" <?= ($cursoFiltro === 'Informática') ? 'selected' : '' ?>>Informática</option>
        </select>

        <label for="serie">Filtrar por Ano de Ingresso:</label>
        <select name="ano_ingresso" id="serie" onchange="document.getElementById('filtroForm').submit()">
            <option value="">Todos os Anos</option>
            <option value="2025" <?= ($cursoSerie === '2025') ? 'selected' : '' ?>>Alunos de 2025</option>
            <option value="2024" <?= ($cursoSerie === '2024') ? 'selected' : '' ?>>Alunos de 2024</option>
            <option value="2023" <?= ($cursoSerie === '2023') ? 'selected' : '' ?>>Alunos de 2023</option>
            <option value="antes2023" <?= ($cursoSerie === 'antes2023') ? 'selected' : '' ?>>Alunos antes de 2023</option>
        </select>
    </form>


</div>
<div id="results2">

<table>
    <thead>
        <tr>
            <th>Matrícula</th>
            <th>Nome</th>
            <th>Curso</th>
            <th>Ano</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($estudantes)): ?>
            <?php foreach ($estudantes as $estudante): ?>
                <tr>
                    <td><?= $estudante->matricula ?></td>
                    <td><?= $estudante->nome ?></td>
                    <td><?= $estudante->curso ?></td>
                    <td><?= $estudante->ano_ingresso ?></td>
                    <td>
                        <button id="btn-toggle-<?= $estudante->id ?>" onclick="toggleSubrow(<?= $estudante->id ?>)">
                            Ver Responsáveis
                        </button>
                    </td>
                </tr>
                <tr id="responsaveis-<?= $estudante->id ?>" class="subrow" style="display: none;">
                    <td colspan="5">
                        <table>
                            <thead>
                                <tr>
                                    <th>Nome do Responsável</th>
                                    <th>Contato</th>
                                    <th>Parentesco</th>
                                    <th>WhatsApp</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($estudante->responsaveis)): ?>
                                <?php foreach ($estudante->responsaveis as $responsavel): ?>
                                    
    <tr>
        <td><?= $responsavel->nome ?></td>
        <td><?= $responsavel->contato ?></td>
        <td><?= $responsavel->parentesco ?></td>
        <td>
           <form action="">
           <button> <a href="https://wa.me/55<?= preg_replace('/\D/', '', $responsavel->contato) ?>" target="_blank">
        Fale via WhatsApp
    </a></button>
           </form> 
        </td>
        <td>
            <form method="POST" action="router.php?rota=deletar_responsavel">
                <input type="hidden" name="deletar_responsavel" value="<?= $responsavel->id ?>">
                <button type="submit" onclick="return confirm('Tem certeza que deseja excluir este estudante?');">Excluir</button> 
            </form>
        </td>
    </tr>
<?php endforeach; ?>
                                <?php else: ?>
    <tr>
        <td colspan="4">Nenhum responsável encontrado.</td>
    </tr>
<?php endif; ?>
                            </tbody>
                        </table>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="3">Nenhum estudante encontrado.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
</div>
    
 <button onclick="window.location.href='index.php'">Voltar ao Menu</button>
</body>
</html>
