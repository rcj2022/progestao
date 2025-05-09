<?php
// Inclua o arquivo de conexão com o banco de dados
include 'config.php';

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recebe os dados do formulário
    $id = $_POST['id'];
    $turma = $_POST['turma'];
    $turno = $_POST['turno'];
    $qtde_aluno = $_POST['qtde_aluno'];
    $exercicio = $_POST['exercicio'];
    $curso = $_POST['curso'];
    $etapa = $_POST['etapa'];

    // Prepara a query SQL para atualizar os dados
    $sql = "UPDATE turma SET 
            nome = :turma, 
            turno = :turno, 
            quantidade_maxima_alunos = :qtde_aluno, 
            exercicio = :exercicio, 
            curso = :curso, 
            etapa = :etapa 
            WHERE id = :id";

    // Prepara a declaração
    $stmt = $pdo->prepare($sql);

    if ($stmt) {
        // Associa os parâmetros usando bindValue
        $stmt->bindValue(':turma', $turma, PDO::PARAM_STR);
        $stmt->bindValue(':turno', $turno, PDO::PARAM_STR);
        $stmt->bindValue(':qtde_aluno', $qtde_aluno, PDO::PARAM_INT);
        $stmt->bindValue(':exercicio', $exercicio, PDO::PARAM_STR);
        $stmt->bindValue(':curso', $curso, PDO::PARAM_STR);
        $stmt->bindValue(':etapa', $etapa, PDO::PARAM_STR);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        // Executa a declaração
        if ($stmt->execute()) {
            // Redireciona para uma página de sucesso
            header("Location: listar_turmas.php");
            exit();
        } else {
            // Exibe uma mensagem de erro
            echo "Erro ao atualizar a turma.";
        }
    } else {
        echo "Erro ao preparar a query.";
    }
} else {
    // Se o formulário não foi enviado, redireciona para a página de edição
    header("Location: editar_turma.php?id=" . $id);
    exit();
}
?>