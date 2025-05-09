<?php
// Conectar ao banco de dados
include 'config.php';

try {
    // Verificar se o ID foi enviado
    if (!isset($_GET['id'])) {
        throw new Exception("ID da escola não fornecido.");
    }

    $id = $_GET['id'];

    // Excluir a escola do banco de dados
    $sql = "DELETE FROM escolas WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id]);

    // Retornar mensagem de sucesso
    echo json_encode(['status' => 'success', 'message' => 'Escola excluída com sucesso!']);
} catch (Exception $e) {
    // Retornar mensagem de erro em caso de falha
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>