<?php
include 'config.php';

$id = $_POST['id'];
$nome = $_POST['nome'];
$email = $_POST['email'];
$senha = $_POST['senha'];
$tipo = $_POST['tipo'];

// Verificar se o e-mail já existe (exceto para o usuário atual)
$sql_check = "SELECT COUNT(*) FROM usuarios WHERE email = :email AND id != :id";
$stmt_check = $pdo->prepare($sql_check);
$stmt_check->bindParam(':email', $email);
$stmt_check->bindParam(':id', $id);
$stmt_check->execute();
$email_exists = $stmt_check->fetchColumn();

if ($email_exists > 0) {
    echo json_encode(['status' => 'error', 'message' => 'Este e-mail já está cadastrado.']);
    exit();
} else {
    // Atualizar os dados do usuário
    if (!empty($senha)) {
        // Se a senha foi fornecida, atualizar a senha
        $sql = "UPDATE usuarios SET nome = :nome, email = :email, senha = :senha, tipo = :tipo WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':senha', password_hash($senha, PASSWORD_DEFAULT));
    } else {
        // Se a senha não foi fornecida, manter a senha atual
        $sql = "UPDATE usuarios SET nome = :nome, email = :email, tipo = :tipo WHERE id = :id";
        $stmt = $pdo->prepare($sql);
    }

    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':tipo', $tipo);
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Usuário atualizado com sucesso!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Erro ao atualizar usuário.']);
    }
}
?>