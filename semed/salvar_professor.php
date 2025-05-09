<?php
include 'config.php'; // Conexão com o banco

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = trim($_POST["nome"]);
    $cpf = trim($_POST["cpf"]);
    $endereco = trim($_POST["endereco"]);
    $formacao = trim($_POST["formacao"]);

    // Verifica se o CPF já está cadastrado
    $sql_verifica = "SELECT id FROM professores WHERE cpf = ?";
    $stmt_verifica = $pdo->prepare($sql_verifica);
    $stmt_verifica->execute([$cpf]);

    if ($stmt_verifica->rowCount() > 0) {
        die("<script>alert('Erro: CPF já cadastrado!'); window.history.back();</script>");
    }

    // Insere no banco
    $sql = "INSERT INTO professores (nome, cpf, endereco, formacao) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);

    if ($stmt->execute([$nome, $cpf, $endereco, $formacao])) {
        echo "<script>alert('Professor cadastrado com sucesso!'); window.location.href='frm_professor.php';</script>";
    } else {
        echo "<script>alert('Erro ao cadastrar.'); window.history.back();</script>";
    }
}
?>
