<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuario_id'])) {
    die("Você não pode acessar esta página. <a href='index.php'>Entrar</a>");
}
?>
