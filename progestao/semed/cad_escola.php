<?php
include 'config.php'; // Certifique-se de que este arquivo contém a conexão PDO correta

try {
    // Capturar dados do formulário
    $nome = $_POST['nome'];
    $endereco = $_POST['endereco'];
    $telefone = $_POST['telefone'];
    $email = $_POST['email'];
    $data_fundacao = $_POST['data_fundacao'];
    $ativo = $_POST['ativo'];

    // Verificar se o e-mail já está cadastrado
    $sql = "SELECT id FROM escola WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['email' => $email]);

    if ($stmt->rowCount() > 0) {
        echo json_encode(['status' => 'error', 'message' => 'Este e-mail já está cadastrado.']);
    } else {
        // Inserir nova escola no banco de dados
        $sql = "INSERT INTO escola (nome, endereco, telefone, email, data_fundacao, ativo)
                VALUES (:nome, :endereco, :telefone, :email, :data_fundacao, :ativo)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'nome' => $nome,
            'endereco' => $endereco,
            'telefone' => $telefone,
            'email' => $email,
            'data_fundacao' => $data_fundacao,
            'ativo' => $ativo
        ]);

        echo json_encode(['status' => 'success', 'message' => 'Escola cadastrada com sucesso!']);
    }
} catch (PDOException $e) {
    // Capturar exceções e retornar mensagem de erro
    echo json_encode(['status' => 'error', 'message' => 'Erro ao cadastrar escola: ' . $e->getMessage()]);
}
?>