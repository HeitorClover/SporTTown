<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Pesquisar Estudante</title>
</head>
<body>

    <h2>Pesquisar Estudante</h2>
    <form action="index.php?route=listarEstudantesResponsaveis" method="POST">
        <label>Nome:</label>
        <input type="text" name="nomeEstudante" placeholder="Nome do estudante" required>
        <button type="submit">Buscar</button>
    </form>
</body>
</html>