<?php
require_once('protected.php'); // Protege com base na sessão correta

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuario_nome'])) {
    header("Location: index.php"); // Redireciona para login se não estiver logado
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    Bem-vindo <?php echo $_SESSION['usuario_nome']; ?>
<p>
    <a href="logout.php"> Sair </a>
</p>

</body>
</html>