<?php
include 'config.php'; // Arquivo de conexão com o banco de dados

if (isset($_GET['id'])) {
    $disciplina_id = $_GET['id']; // Obtém o ID da disciplina a ser excluída

    try {
        // Verifica se a disciplina existe antes de excluir
        $sql_check = "SELECT * FROM disciplina_individual WHERE id = :disciplina_id";
        $stmt_check = $pdo->prepare($sql_check);
        $stmt_check->bindValue(':disciplina_id', $disciplina_id, PDO::PARAM_INT);
        $stmt_check->execute();

        if ($stmt_check->rowCount() > 0) {
            // Exclui a disciplina
            $sql_delete = "DELETE FROM disciplina_individual WHERE id = :disciplina_id";
            $stmt_delete = $pdo->prepare($sql_delete);
            $stmt_delete->bindValue(':disciplina_id', $disciplina_id, PDO::PARAM_INT);

            if ($stmt_delete->execute()) {
                echo "<script>alert('Disciplina excluída com sucesso!'); window.location='disciplina_listar.php';</script>";
            } else {
                echo "<script>alert('Erro ao excluir a disciplina.'); window.location='disciplina_listar.php';</script>";
            }
        } else {
            echo "<script>alert('Disciplina não encontrada.'); window.location='disciplina_listar.php';</script>";
        }
    } catch (PDOException $e) {
        echo "<script>alert('Erro ao excluir a disciplina: " . $e->getMessage() . "'); window.location='disciplina_listar.php';</script>";
    }
} else {
    echo "<script>alert('ID de disciplina não fornecido.'); window.location='disciplina_listar.php';</script>";
}
?>
