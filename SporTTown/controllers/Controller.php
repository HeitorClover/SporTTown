<?php

require_once __DIR__ . '/../models/Model.php'; // Caminho absoluto, evita erros com níveis de diretórios

class Controller {
private $model;

public function __construct(){
    $this->model = new Model(); 
}

public function cadastrar() {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nome = $_POST["nome"];
        $email = $_POST["email"];
        $senha = $_POST["senha"];

        $this->model->salvar($nome, $email, $senha);

        header("Location:router.php?rota=cadastrar&sucesso=1");
        exit;
    }
}

public function listar() {
    return $this->model->buscarEstudantes();
}


}
