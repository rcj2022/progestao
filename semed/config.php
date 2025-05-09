<?php
// Configurações do banco de dados
$host = 'localhost';
$dbname = 'esc25';
$username = 'root';
$password = '';

// Conexão com o banco de dados usando PDO
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Ativa o modo de exceção para erros
} catch (PDOException $e) {
    die("Erro na conexão: " . $e->getMessage());
}

function getAlunos($pdo, $escola_id) {
    // Consulta SQL com ordenação por nome
    $sql = "SELECT * FROM alunos WHERE escola_id = ? ORDER BY nome ASC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$escola_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getProfessores($pdo, $escola_id) {
    $sql = "SELECT id, nome FROM usuarios WHERE tipo = 'professor' AND escola_id = :escola_id ORDER BY nome";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':escola_id', $escola_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}



// Função para buscar disciplinas
function getDisciplinas($pdo) {
    $sql = "SELECT id_disciplina, nome FROM disciplinas order by nome";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Função para buscar turmas
function getTurmas($pdo) {
    $sql = "SELECT id, nome FROM turma order by nome";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Função para buscar bimestres
function getBimestres($pdo) {
    $sql = "SELECT id, nome FROM bimestres order by nome";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Função para buscar bimestres
function getEscola($pdo) {
    $sql = "SELECT id, nome FROM escola order by nome";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
// Função para buscar os vínculos da escola
function getVinculos($pdo, $escola_id) {
    $sql = "
        SELECT v.*, 
               a.nome AS aluno_nome, 
               p.nome AS professor_nome, 
               d.nome AS disciplina_nome, 
               t.nome AS turma_nome, 
               b.nome AS bimestre_nome
        FROM vinculos v
        JOIN alunos a ON v.aluno_id = a.id
        JOIN usuarios p ON v.usuario_id = p.id
        JOIN disciplinas d ON v.disciplina_id = d.id_disciplina
        JOIN turma t ON v.turma_id = t.id
        JOIN bimestres b ON v.bimestre_id = b.id
        WHERE v.escola_id = :escola_id
    ";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['escola_id' => $escola_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


?>