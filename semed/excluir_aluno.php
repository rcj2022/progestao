<?php
include 'config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Exclui o aluno do banco de dados
    $sql = "DELETE FROM alunos WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        header("Location: listar_alunos.php?msg=Aluno excluído com sucesso!");
        exit();
    } else {
        header("Location: listar_alunos.php?msg=Erro ao excluir aluno.");
        exit();
    }
} else {
    header("Location: listar_alunos.php");
    exit();
}
?>