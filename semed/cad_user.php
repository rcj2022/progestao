<?php
session_start();
include 'config.php';



// Recebe os dados do formulário
$nome = $_POST['nome'];
$email = $_POST['email'];
$senha = $_POST['senha'];
$tipo = $_POST['tipo'];
$escola_id = $_POST['escola_id']; // Obtém o ID da escola da sessão

// Verificar se o e-mail já existe
$sql_check = "SELECT COUNT(*) FROM usuarios WHERE email = :email";
$stmt_check = $pdo->prepare($sql_check);
$stmt_check->bindParam(':email', $email, PDO::PARAM_STR);
$stmt_check->execute();
$email_exists = $stmt_check->fetchColumn();

if ($email_exists > 0) {
    echo json_encode(['status' => 'error', 'message' => 'Este e-mail já está cadastrado.']);
    exit();
}

// Criptografar a senha antes de inserir no banco de dados
$senha_hash = password_hash($senha, PASSWORD_DEFAULT);

// Inserir novo usuário no banco, incluindo o ID da escola
$sql = "INSERT INTO usuarios (nome, email, senha, tipo, escola_id) 
        VALUES (:nome, :email, :senha, :tipo, :escola_id)";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
$stmt->bindParam(':email', $email, PDO::PARAM_STR);
$stmt->bindParam(':senha', $senha_hash, PDO::PARAM_STR);
$stmt->bindParam(':tipo', $tipo, PDO::PARAM_STR);
$stmt->bindParam(':escola_id', $escola_id, PDO::PARAM_INT);

if ($stmt->execute()) {
    echo json_encode([
        'status' => 'success',
        'message' => 'Usuário cadastrado com sucesso!',
        'redirect' => 'painel_secretario.php'
    ]);
    exit();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Erro ao cadastrar usuário.']);
    exit();
}
?>
