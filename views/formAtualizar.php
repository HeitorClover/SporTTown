<?php
require_once 'controllers/Controller.php';

$controller = new Controller();

$matricula = $_GET['matricula'] ?? null;

if (!$matricula) {
    echo "<p>Matrícula não informada.</p>";
    echo '<button onclick="window.location.href=\'router.php?rota=atualizar\'">Voltar</button>';
    exit;
}

$estudante = $controller->buscarDadosCompletos($matricula);

if (!$estudante) {
    echo "<p>Estudante não encontrado.</p>";
    echo '<button onclick="window.location.href=\'router.php?rota=atualizar\'">Voltar</button>';
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Atualizar Estudante</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
    body{
       background-image: url('imagens/home (5).png');
        background-size: cover;
       
    }
    </style>
</head>
<body>
    <h2>Atualizar Estudante</h2>

    <form action="router.php?rota=atualizar" method="POST" id="formAtualizar">
        <input type="hidden" name="matricula" value="<?= htmlspecialchars($estudante->matricula) ?>">

        <label>Nome:</label>
        <input type="text" name="nome" value="<?= htmlspecialchars($estudante->nome) ?>" required>
        <br>

        <label>Curso:</label>
        <input type="text" name="curso" value="<?= htmlspecialchars($estudante->curso) ?>" required>
        <br>

        <label>Ano de Ingresso:</label>
        <input type="number" name="ano_ingresso" value="<?= htmlspecialchars($estudante->ano_ingresso) ?>" required>
        <br>

        <h3>Responsáveis</h3>
        <div id="responsaveis-container">
            <?php foreach ($estudante->responsaveis as $index => $responsavel): ?>
                <div class="responsavel-group">
                    <input type="text" name="responsaveis[<?= $index ?>][nome]" 
                           value="<?= htmlspecialchars($responsavel->nome) ?>" placeholder="Nome do Responsável" required>
                    <input type="text" name="responsaveis[<?= $index ?>][contato]" 
                           value="<?= htmlspecialchars($responsavel->contato) ?>" placeholder="Contato" required>
                    <input type="text" name="responsaveis[<?= $index ?>][parentesco]" 
                           value="<?= htmlspecialchars($responsavel->parentesco) ?>" placeholder="Parentesco">
                    <?php if ($index > 0): ?>
                        <button type="button" class="remove-responsavel">
                            <i class="fas fa-times"></i> Remover
                        </button>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>

        <button type="button" id="add-responsavel">
            <i class="fas fa-plus-circle"></i> Adicionar Responsável
        </button>
        
        <button type="submit">Atualizar</button>
    </form>

    <button onclick="window.location.href='router.php?rota=atualizar'">Cancelar</button>

    <script>
    $(document).ready(function() {
        let responsavelCount = <?= count($estudante->responsaveis) ?>;
        
        $('#add-responsavel').click(function() {
            if(responsavelCount >= 5) {
                alert('Máximo de 5 responsáveis permitidos!');
                return;
            }

            const newGroup = `
                <div class="responsavel-group">
                    <input type="text" name="responsaveis[${responsavelCount}][nome]" placeholder="Nome do Responsável" required>
                    <input type="text" name="responsaveis[${responsavelCount}][contato]" placeholder="Contato" required>
                    <input type="text" name="responsaveis[${responsavelCount}][parentesco]" placeholder="Parentesco">
                    <button type="button" class="remove-responsavel">
                        <i class="fas fa-times"></i> Remover
                    </button>
                </div>
            `;
            
            $('#responsaveis-container').append(newGroup);
            responsavelCount++;
        });

        $(document).on('click', '.remove-responsavel', function() {
            if($('.responsavel-group').length > 1) {
                $(this).parent().remove();
                // Reindexa os grupos
                $('.responsavel-group').each(function(index) {
                    $(this).find('input').each(function() {
                        const name = $(this).attr('name').replace(/responsaveis\[\d+\]/, `responsaveis[${index}]`);
                        $(this).attr('name', name);
                    });
                });
                responsavelCount = $('.responsavel-group').length;
            } else {
                alert('É necessário ter pelo menos um responsável!');
            }
        });
    });
    </script>
</body>
</html>