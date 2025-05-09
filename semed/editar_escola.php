<?php
// Conectar ao banco de dados
include 'config.php';

try {
    // Verificar se os dados foram enviados
    if (!isset($_POST['id']) || !isset($_POST['nome']) || !isset($_POST['endereco']) || !isset($_POST['telefone']) || !isset($_POST['email']) || !isset($_POST['data_fundacao']) || !isset($_POST['ativo'])) {
        throw new Exception("Dados incompletos.");
    }

    // Capturar dados do formulário
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $endereco = $_POST['endereco'];
    $telefone = $_POST['telefone'];
    $email = $_POST['email'];
    $data_fundacao = $_POST['data_fundacao'];
    $ativo = $_POST['ativo'];

    // Atualizar a escola no banco de dados
    $sql = "UPDATE escola SET nome = :nome, endereco = :endereco, telefone = :telefone, email = :email, data_fundacao = :data_fundacao, ativo = :ativo WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'id' => $id,
        'nome' => $nome,
        'endereco' => $endereco,
        'telefone' => $telefone,
        'email' => $email,
        'data_fundacao' => $data_fundacao,
        'ativo' => $ativo
    ]);

    // Retornar mensagem de sucesso
    echo json_encode(['status' => 'success', 'message' => 'Escola atualizada com sucesso!']);
} catch (Exception $e) {
    // Retornar mensagem de erro em caso de falha
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>