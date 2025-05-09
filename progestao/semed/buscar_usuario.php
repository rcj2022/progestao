<?php
include 'config.php';

$id = $_GET['id'];

// Buscar os dados do usuário
$sql = "SELECT id, nome, email, tipo FROM usuarios WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id', $id);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
    echo json_encode(['status' => 'success', 'usuario' => $usuario]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Usuário não encontrado.']);
}
?>