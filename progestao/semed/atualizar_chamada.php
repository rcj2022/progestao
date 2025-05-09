<?php
session_start();
include 'config.php';

// Verifica se o usuário está autenticado
if (!isset($_SESSION['usuario_id'])) {
    die(json_encode(['success' => false, 'message' => 'Usuário não autenticado.']));
}

// Verifica se os dados foram enviados via POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die(json_encode(['success' => false, 'message' => 'Método de requisição inválido.']));
}

// Valida os dados recebidos
$id = $_POST['id'] ?? null;
$status = $_POST['status'] ?? null;

if (!$id || !$status) {
    die(json_encode(['success' => false, 'message' => 'Dados incompletos.']));
}

// Atualiza o status no banco de dados
try {
    $sql = "UPDATE chamada SET status = :status WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':status', $status, PDO::PARAM_STR);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Erro ao atualizar o status: ' . $e->getMessage()]);
}
?>