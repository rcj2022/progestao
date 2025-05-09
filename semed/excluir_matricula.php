<?php
// Inclui o arquivo de configuração do banco de dados
include 'config.php';

// Verifica se o ID da matrícula foi passado na URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Verifica se o ID é um número válido
    if (!is_numeric($id)) {
        echo "<script>alert('ID inválido!'); window.location='matricula.php';</script>";
        exit();
    }

    // Prepara a consulta SQL para excluir a matrícula
    $sql = "DELETE FROM matriculados WHERE id = ?";
    $stmt = $pdo->prepare($sql);

    // Executa a consulta com o ID fornecido
    if ($stmt->execute([$id])) {
        // Verifica se alguma linha foi afetada (se a matrícula foi excluída)
        if ($stmt->rowCount() > 0) {
            echo "<script>alert('Matrícula excluída com sucesso!'); window.location='matricula.php';</script>";
        } else {
            echo "<script>alert('Matrícula não encontrada ou já excluída!'); window.location='matricula.php';</script>";
        }
    } else {
        echo "<script>alert('Erro ao excluir matrícula!'); window.location='matricula.php';</script>";
    }
} else {
    // Se o ID não foi passado, redireciona com uma mensagem de erro
    echo "<script>alert('ID não fornecido!'); window.location='matricula.php';</script>";
    exit();
}
?>