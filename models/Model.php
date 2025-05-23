<?php
class Model {
    private $connect;
    
    public function __construct() {
        try {
            $this->connect = new PDO("mysql:host=localhost;dbname=identificar_responsavel", 'root', 'mysql2024');
            $this->connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Erro de conexão: " . $e->getMessage());
        }
    }



    protected $fillable = ['matricula', 'nome', 'curso', 'ano_ingresso'];

    public function responsavel()
    {
        return $this->hasOne(Estudante::class, 'id_estudante'); // simula relação com responsável
    }

     public function salvarComResponsavel($data) {
    try {

        $this->connect->beginTransaction();

        $stmt = $this->connect->prepare("
            INSERT INTO estudantes (matricula, nome, curso, ano_ingresso)
            VALUES (:matricula, :nome, :curso, :ano_ingresso)
        ");
        $stmt->execute([
            ':matricula' => $data['matricula'],
            ':nome' => $data['nome'],
            ':curso' => $data['curso'],
            ':ano_ingresso' => $data['ano_ingresso']
        ]);

        $estudanteId = $this->connect->lastInsertId();

        foreach ($data['responsaveis'] as $responsavel) {
            if (!empty($responsavel['nome'])) {
                $stmt = $this->connect->prepare("
                    INSERT INTO responsaveis (id_estudante, nome, contato, parentesco)
                    VALUES (:id_estudante, :nome, :contato, :parentesco)
                ");
                $stmt->execute([
                    ':id_estudante' => $estudanteId,
                    ':nome' => $responsavel['nome'],
                    ':contato' => $responsavel['contato'],
                    ':parentesco' => $responsavel['parentesco'] ?? null
                ]);
            }
        }

        $this->connect->commit();
        return true;
    } catch (PDOException $e) {
        $this->connect->rollBack();
        throw $e;
    }
}

 public function buscarResponsaveis($idEstudante) {
        try {
            $stmt = $this->connect->prepare("SELECT * FROM responsaveis WHERE id_estudante = :id_estudante");
            $stmt->bindParam(':id_estudante', $idEstudante, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            die("Erro ao buscar responsáveis: " . $e->getMessage());
        }
    }

    public function atualizarResponsaveis($idEstudante, $responsaveis) {
        try {
            $this->connect->beginTransaction();
            
            // Primeiro remove os responsáveis existentes
            $stmtDelete = $this->connect->prepare("DELETE FROM responsaveis WHERE id_estudante = :id_estudante");
            $stmtDelete->bindParam(':id_estudante', $idEstudante, PDO::PARAM_INT);
            $stmtDelete->execute();
            
            // Depois insere os novos
            foreach ($responsaveis as $responsavel) {
                if (!empty($responsavel['nome'])) {
                    $stmtInsert = $this->connect->prepare("
                        INSERT INTO responsaveis (id_estudante, nome, contato, parentesco)
                        VALUES (:id_estudante, :nome, :contato, :parentesco)
                    ");
                    $stmtInsert->execute([
                        ':id_estudante' => $idEstudante,
                        ':nome' => $responsavel['nome'],
                        ':contato' => $responsavel['contato'],
                        ':parentesco' => $responsavel['parentesco'] ?? null
                    ]);
                }
            }
            
            $this->connect->commit();
            return true;
        } catch (PDOException $e) {
            $this->connect->rollBack();
            throw $e;
        }
    }

    public function getResponsaveisPorEstudante($idEstudante) {
    try {
        $stmt = $this->connect->prepare("SELECT id, nome, contato, parentesco FROM responsaveis WHERE id_estudante = ?");
        $stmt->execute([$idEstudante]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);  // para acessar $responsavel->id
    } catch (PDOException $e) {
        return []; // em caso de erro, retorna vazio
    }
}

public function getConnect() {
    return $this->connect;
}

    public function estudante()
    {
        return $this->belongsTo(Estudante::class);
    }

    public function buscarEstudantes() {
        try {
            $stmt = $this->connect->prepare("SELECT id, matricula, nome, curso, ano_ingresso FROM estudantes");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            die("Erro ao buscar estudantes: " . $e->getMessage());
        }
    }

    // Adicionar função de deletar no Model.php
    public function deletarEstudante($matricula) {
        try {
            $stmt = $this->connect->prepare("DELETE FROM estudantes WHERE matricula = :matricula");
            $stmt->bindParam(':matricula', $matricula, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            die("Erro ao excluir estudante: " . $e->getMessage());
        }
    }

    public function deletarResponsaveisPorEstudante($idEstudante) {
    $sql = "DELETE FROM responsaveis WHERE id_estudante = ?";
    $stmt = $this->connect->prepare($sql);
    $stmt->execute([$idEstudante]);
}

public function deletarResponsavel($idResponsavel) {
    try {
        $stmt = $this->connect->prepare("DELETE FROM responsaveis WHERE id = :id");
        $stmt->bindParam(':id', $idResponsavel, PDO::PARAM_INT);
        $stmt->execute();
    } catch (PDOException $e) {
        die("Erro ao excluir responsável: " . $e->getMessage());
    }
}
    public function buscarPorMatricula($matricula) {
        try {
            $stmt = $this->connect->prepare("SELECT * FROM estudantes WHERE matricula = :matricula");
            $stmt->bindParam(':matricula', $matricula, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            die("Erro ao buscar estudante: " . $e->getMessage());
        }
    }
public function getEstudantePorMatricula($matricula) {
    try {
        $stmt = $this->connect->prepare("SELECT * FROM estudantes WHERE matricula = :matricula");
        $stmt->bindParam(':matricula', $matricula, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ); // Retorna um objeto do estudante
    } catch (PDOException $e) {
        die("Erro ao buscar estudante: " . $e->getMessage());
    }
}
    public function atualizarEstudante($matricula, $nome, $curso, $ano_ingresso) {
        try {
            $stmt = $this->connect->prepare("
                UPDATE estudantes 
                SET nome = :nome, curso = :curso, ano_ingresso = :ano_ingresso 
                WHERE matricula = :matricula
            ");
            $stmt->bindParam(':matricula', $matricula, PDO::PARAM_INT);
            $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
            $stmt->bindParam(':curso', $curso, PDO::PARAM_STR);
            $stmt->bindParam(':ano_ingresso', $ano_ingresso, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            die("Erro ao atualizar estudante: " . $e->getMessage());
        }
    }
     public function buscarEstudantesPorNome($nome) {
        try {
            $stmt = $this->connect->prepare("SELECT * FROM estudantes WHERE nome LIKE :nome");
            $stmt->bindValue(':nome', '%' . $nome . '%', PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            die("Erro ao buscar estudantes: " . $e->getMessage());
        }
    }

}

?>
