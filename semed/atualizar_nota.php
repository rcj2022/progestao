<?php
session_start();
include 'config.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    die(json_encode(['success' => false, 'message' => 'Usuário não logado.']));
}

// Recebe os dados da requisição
$id = $_POST['id'] ?? null;
$campo = $_POST['campo'] ?? null;
$valor = $_POST['valor'] ?? null;

if (!$id || !$campo || !is_numeric($valor)) {
    die(json_encode(['success' => false, 'message' => 'Dados inválidos.']));
}

// Valida os valores
if (($campo === 'av1' || $campo === 'av2') && ($valor < 0 || $valor > 8)) {
    die(json_encode(['success' => false, 'message' => 'AV1 e AV2 devem estar entre 0 e 8.']));
}

if ($campo === 'av3' && ($valor < 0 || $valor > 9)) {
    die(json_encode(['success' => false, 'message' => 'AV3 deve estar entre 0 e 9.']));
}

// Atualiza a nota no banco de dados
try {
    $sql = "UPDATE notas SET $campo = :valor WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':valor', $valor, PDO::PARAM_STR);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    // Recalcula o total
    $sqlTotal = "SELECT av1, av2, av3 FROM notas WHERE id = :id";
    $stmtTotal = $pdo->prepare($sqlTotal);
    $stmtTotal->bindParam(':id', $id, PDO::PARAM_INT);
    $stmtTotal->execute();
    $nota = $stmtTotal->fetch(PDO::FETCH_ASSOC);

    $total = $nota['av1'] + $nota['av2'] + $nota['av3'];

    // Atualiza o total no banco de dados
    $sqlUpdateTotal = "UPDATE notas SET total = :total WHERE id = :id";
    $stmtUpdateTotal = $pdo->prepare($sqlUpdateTotal);
    $stmtUpdateTotal->bindParam(':total', $total, PDO::PARAM_STR);
    $stmtUpdateTotal->bindParam(':id', $id, PDO::PARAM_INT);
    $stmtUpdateTotal->execute();

    echo json_encode(['success' => true, 'total' => $total]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Valor inaceitavel: av1=8,av2=8,av3=9.']);
}
?>