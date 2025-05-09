<?php
// Conectar ao banco de dados
include 'config.php';

try {
    // Verificar se o ID foi enviado
    if (!isset($_GET['id'])) {
        throw new Exception("ID da escola não fornecido.");
    }

    $id = $_GET['id'];

    // Buscar a escola no banco de dados
    $sql = "SELECT id, nome, endereco, telefone, email, data_fundacao, ativo FROM escola WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id]);
    $escola = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($escola) {
        // Retornar os dados da escola em formato JSON
        echo json_encode(['status' => 'success', 'escola' => $escola]);
    } else {
        throw new Exception("Escola não encontrada.");
    }
} catch (Exception $e) {
    // Retornar mensagem de erro em caso de falha
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>