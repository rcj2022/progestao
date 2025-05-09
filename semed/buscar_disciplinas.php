<?php
include 'config.php'; // Inclua o arquivo de configuração do banco de dados

$turma_id = $_GET['turma_id'] ?? null;

if ($turma_id) {
    // Consulta as disciplinas vinculadas à turma
    $sql = "
        SELECT DISTINCT d.id_disciplina, d.nome 
        FROM disciplinas d
        INNER JOIN vinculos v ON d.id_disciplina = v.disciplina_id
        WHERE v.turma_id = :turma_id
        ORDER BY d.nome
    ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':turma_id' => $turma_id]);
    $disciplinas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Retorna as disciplinas em formato JSON
    header('Content-Type: application/json');
    echo json_encode($disciplinas);
} else {
    // Retorna um array vazio se nenhuma turma for selecionada
    header('Content-Type: application/json');
    echo json_encode([]);
}