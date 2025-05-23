<?php

require_once __DIR__ . '/../models/Model.php'; // Caminho absoluto, evita erros com níveis de diretórios

class Controller {
private $model;

public function __construct(){
    $this->model = new Model(); 
}

public function create()
{
    return view('estudante.form');
}

public function cadastrar($data) {
    // Validação simples
    if (empty($data['matricula']) || empty($data['nome']) || 
        empty($data['curso']) || empty($data['ano_ingresso']) ||
        empty($data['responsaveis'][0]['nome']) || 
        empty($data['responsaveis'][0]['contato'])
    ) {
        die("Todos os campos obrigatórios devem ser preenchidos.");
    }

    try {
        // Use o método do Model em vez de acessar $connect diretamente
        $this->model->salvarComResponsavel($data);

        header("Location: router.php?rota=cadastrar&sucesso=1");
        exit;
    } catch (Exception $e) {
        die("Erro ao cadastrar: " . $e->getMessage());
    }
}


public function buscarPorAnoCursoNome($nome, $curso, $ano) {
    $sql = "SELECT * FROM estudantes WHERE 1=1";
    $params = [];

    // Filtro por nome (parcial)
    if (!empty($nome)) {
        $sql .= " AND nome LIKE ?";
        $params[] = "%$nome%";
    }

    // Filtro por curso (igualdade exata)
    if (!empty($curso)) {
        $sql .= " AND curso = ?";
        $params[] = $curso;
    }

    // Filtro por ano de ingresso (com opção especial "antes2023")
    if (!empty($ano)) {
        if ($ano === 'antes2023') {
            $sql .= " AND ano_ingresso < ?";
            $params[] = 2023;
        } elseif (is_numeric($ano)) {
            $sql .= " AND ano_ingresso = ?";
            $params[] = (int)$ano;
        }
    }

    $pdo = $this->model->getConnect();
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    return $stmt->fetchAll(PDO::FETCH_OBJ);
}




public function listarAnosIngresso() {
    $sql = "SELECT DISTINCT ano_ingresso FROM estudantes ORDER BY ano_ingresso DESC";
    $pdo = $this->model->getConnect(); // usando o método correto
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_COLUMN);
}



public function listar() {
    return $this->model->buscarEstudantes();
}

public function buscarResponsaveis($id) {
    return $this->model->getResponsaveisPorEstudante($id);
}

public function deletarResponsavel($id) {
    $this->model->deletarResponsavel($id);
    header("Location: router.php?rota=listar_estudantes");
    exit;
}


public function mostrarResponsaveis($idEstudante) {
    $model = new Model();
   $responsaveis = $model->getResponsaveisPorEstudante($idEstudante);

    foreach ($responsaveis as $r) {
        echo "<strong>Nome:</strong> {$r['nome']}<br>";
        echo "<strong>Contato:</strong> {$r['contato']}<br>";
        echo "<strong>Parentesco:</strong> {$r['parentesco']}<hr>";
    }
}



public function deletar($matricula) {
    // 🔎 Busca o estudante para obter o ID
    $estudante = $this->model->getEstudantePorMatricula($matricula);

    if ($estudante) {
        $idEstudante = $estudante->id;

        // 🔄 Primeiro, exclui os responsáveis relacionados a esse estudante
        $this->model->deletarResponsaveisPorEstudante($idEstudante);

        // 🚀 Depois, exclui o estudante
        $this->model->deletarEstudante($matricula);

        header("Location: router.php?rota=listar_estudantes");
    exit;
    }
}

public function buscarResponsaveisArray($id) {
    return $this->model->getResponsaveisPorEstudante($id);
}


public function buscarPorNome($nome) {
    return $this->model->buscarEstudantesPorNome($nome);
}

public function buscarPorMatricula($matricula) {
    return $this->model->buscarPorMatricula($matricula);
}



public function buscarSugestoes($termo) {
    return $this->model->buscarSugestoesNome($termo);
}

public function autocomplete($termo) {
    return $this->model->buscarSugestoesNome($termo);
}


public function atualizar() {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $matricula = $_POST["matricula"];
        $nome = $_POST["nome"];
        $curso = $_POST["curso"];
        $ano_ingresso = $_POST["ano_ingresso"];
        $responsaveis = $_POST["responsaveis"] ?? [];

        try {
            // Primeiro atualiza o estudante
            $this->model->atualizarEstudante($matricula, $nome, $curso, $ano_ingresso);
            
            // Busca o ID do estudante
            $estudante = $this->model->buscarPorMatricula($matricula);
            
            // Atualiza os responsáveis
            if ($estudante) {
                $this->model->atualizarResponsaveis($estudante->id, $responsaveis);
            }

            header("Location: router.php?rota=listar&atualizado=1");
            exit;
        } catch (Exception $e) {
            die("Erro ao atualizar: " . $e->getMessage());
        }
    }
}


public function buscarDadosCompletos($matricula) {
    $estudante = $this->model->buscarPorMatricula($matricula);
    if ($estudante) {
        $estudante->responsaveis = $this->model->buscarResponsaveis($estudante->id);
    }
    return $estudante;
}

}



?>
