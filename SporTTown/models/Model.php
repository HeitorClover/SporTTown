<?php
class Model {
    private $host = 'localhost';
    private $dbname = 'loginsporttown';
    private $usuario = 'root';
    private $senha = 'mysql2024';

    protected $pdo;

    public function __construct() {
        try {
            $this->pdo = new PDO("mysql:host={$this->host};dbname={$this->dbname}", $this->usuario, $this->senha);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Erro na conexão: " . $e->getMessage());
        }
    }

    public function getConnect() {
        return $this->pdo;
    }

    
    public function hashPassword($senha) {
        return password_hash($senha, PASSWORD_DEFAULT);
    }

    public function verifyPassword($senhaDigitada, $hashArmazenado) {
        return password_verify($senhaDigitada, $hashArmazenado); // Retorne DIRETAMENTE
    }
    
    public function salvar($nome, $email, $senha) {
    try {
        // Criptografa a senha
        $hash = password_hash($senha, PASSWORD_DEFAULT);

        // SQL com 3 colunas e 3 placeholders nomeados
        $sql = "
            INSERT INTO usuario (nome, email, senha)
            VALUES (:nome, :email, :senha)
        ";
        $stmt = $this->pdo->prepare($sql);

        // Bind correto de cada placeholder
        $stmt->bindParam(':nome',  $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':senha', $hash);

        $stmt->execute();
    } catch (PDOException $e) {
        die("Erro ao salvar: " . $e->getMessage());
    }
}


}?>
