<?php
try {
    $pdo = new PDO("mysql:host=127.0.0.1;dbname=identificar_responsavel", 'root', 'mysql2024');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Conexão bem-sucedida!";
} catch (PDOException $e) {
    die("Erro de conexão: " . $e->getMessage());
}
?>