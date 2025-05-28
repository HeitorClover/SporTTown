<?php

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

include('models/Model.php');

$model = new Model();
$pdo = $model->getConnect();

    if (isset($_POST['email'], $_POST['senha'])) {
        $email = $_POST['email'];
        $senha = $_POST['senha'];

        $stmt = $pdo->prepare("SELECT * FROM usuario WHERE email = ?");
        $stmt->execute([$email]);
        $usuario = $stmt->fetch(PDO::FETCH_OBJ);
        
            if ($usuario && password_verify($senha, $usuario->senha)) {
                $_SESSION['usuario_id'] = $usuario->id;
                $_SESSION['usuario_nome'] = $usuario->nome;
                header("Location: painel.php");
                exit;
            } else {
                echo "Credenciais incorretas.";
            }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style_login.css">
    <title> Login </title>
</head>
<body>
    <div class="login-container">
        <h1>Login</h1>
        <h4>Conecte-se para continuar</h4>
        <form action="" method="POST">
            <input type="text" name="email" placeholder="Email:" required>
            <input type="password" name="senha" placeholder="Senha:" required>
            <button type="submit">Entrar</button>
        </form>
        <a href="cadastrar.php"> Não Tem conta?</a>
      </div>
      <script src="script_login.js"></script>
</body>
</html>