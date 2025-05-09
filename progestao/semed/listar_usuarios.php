<?php
include 'config.php';

// Consulta para buscar todos os usuários
$sql = "SELECT id, nome, email, tipo FROM usuarios";
$stmt = $pdo->query($sql);

// Verifica se há resultados
if ($stmt->rowCount() > 0) {
    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC); // Retorna os dados como um array associativo
    echo json_encode(['status' => 'success', 'data' => $usuarios]); // Retorna os dados em JSON
} else {
    echo json_encode(['status' => 'error', 'message' => 'Nenhum usuário encontrado.']); // Retorna mensagem de erro
}
?>