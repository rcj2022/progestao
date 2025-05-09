<?php
include 'config.php';

$id = $_GET['id'];

// Verificar se o usuário existe
$sql_check = "SELECT COUNT(*) FROM usuarios WHERE id = :id";
$stmt_check = $pdo->prepare($sql_check);
$stmt_check->bindParam(':id', $id);
$stmt_check->execute();
$usuario_exists = $stmt_check->fetchColumn();

if ($usuario_exists > 0) {
    // Excluir o usuário
    $sql = "DELETE FROM usuarios WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Usuário excluído com sucesso!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Erro ao excluir usuário.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Usuário não encontrado.']);
}
?>