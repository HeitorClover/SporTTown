<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Lista de Estudantes e Responsáveis</title>
</head>
<body>
    <h2>Lista de Estudantes e Responsáveis</h2>
    <table border="1">
        <tr>
            <th>Nome do Estudante</th>
            <th>Curso</th>
            <th>Ano de Ingresso</th>
            <th>Nome do Responsável</th>
            <th>Contato</th>
        </tr>
        <?php if (!empty($estudantes)): ?>
            <?php foreach ($estudantes as $estudante): ?>
            <tr>
                <td><?= htmlspecialchars($estudante->estudante); ?></td>
                <td><?= htmlspecialchars($estudante->curso); ?></td>
                <td><?= htmlspecialchars($estudante->ano_ingresso); ?></td>
                <td><?= htmlspecialchars($estudante->nome_responsavel); ?></td>
                <td>
                    <?php 
                        // Remove caracteres indesejados do número para garantir que funcione no link do WhatsApp
                        $numeroFormatado = preg_replace('/\D/', '', $estudante->contato);
                    ?>
                    <a href="https://wa.me/<?= $numeroFormatado; ?>" target="_blank">
                        <button>WhatsApp</button>
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="5">Estudante ou responsável não encontrados.</td>
            </tr>
        <?php endif; ?>
    </table>
    <br>
    <a href="index.php">Voltar</a>
</body>
</html>