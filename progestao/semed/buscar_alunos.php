<?php
include 'config.php';

try {
    $termo = $_GET['termo'] ?? '';

    $sql = "SELECT id, nome FROM alunos WHERE nome LIKE :termo";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':termo', "%$termo%", PDO::PARAM_STR);
    $stmt->execute();

    $alunos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode($alunos);
} catch (PDOException $e) {
    echo json_encode(["error" => "Erro na consulta: " . $e->getMessage()]);
}
?>
