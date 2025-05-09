<?php
// Conectar ao banco de dados
include 'config.php';

try {
    // Buscar todas as escolas no banco de dados
    $sql = "SELECT id, nome, endereco, telefone, email, data_fundacao, ativo FROM escola";
    $stmt = $pdo->query($sql);
    $escolas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Retornar os dados em formato JSON
    echo json_encode(['status' => 'success', 'data' => $escolas]);
} catch (PDOException $e) {
    // Retornar mensagem de erro em caso de falha
    echo json_encode(['status' => 'error', 'message' => 'Erro ao listar escolas: ' . $e->getMessage()]);
}
?>