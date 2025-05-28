<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
     <?php if(isset($_GET['sucesso'])): ?>
        <p style="color: green;">Estudante cadastrado com sucesso!</p>
    <?php endif; ?>

    <form action="router.php?rota=cadastrar" method="POST">

        <label>Nome:</label>
        <input type="text" name="nome" placeholder="Nome" maxlength="200" required>

        <label>Email:</label>
        <input type="text" name="email" placeholder="Email" maxlength="500" required>

        <label>Senha</label>
        <input type="password" name="senha" placeholder="Senha" min="6" max="100" required>

        <br><br>
        <input type="submit" value="Cadastrar">
    </form>

    <button onclick="window.location.href='index.php'">Voltar ao Menu</button>
    
</body>
</html>