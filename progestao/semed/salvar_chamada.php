<?php
include 'config.php';
session_start(); // Certifique-se de iniciar a sessão

// Verifica se o usuário está autenticado
$professor_id = $_SESSION['usuario_id'] ?? null;
if (!$professor_id) {
    die('Usuário não autenticado.');
}

// Recebe os dados do formulário
$data = $_POST['data'] ?? null;
$bimestre_id = $_POST['bimestre_id'] ?? null;
$turma_id = $_POST['turma_id'] ?? null;
$disciplina_id = $_POST['disciplina_id'] ?? null;
$aluno_id = $_POST['aluno_id'] ?? null;
$status = $_POST['status'] ?? null;

// Verifica se todos os campos necessários estão presentes
if ($data && $bimestre_id && $turma_id && $disciplina_id && $aluno_id && in_array($status, ['Presente', 'Ausente'])) {
    try {
        // Inicia uma transação para garantir integridade dos dados
        $pdo->beginTransaction();

        // Verifica se já existe um registro para o aluno na chamada
        $stmtCheck = $pdo->prepare("SELECT 1 FROM chamada 
            WHERE aluno_id = :aluno_id 
            AND data = :data 
            AND bimestre_id = :bimestre_id 
            AND turma_id = :turma_id 
            AND disciplina_id = :disciplina_id");

        $stmtCheck->execute([
            ':aluno_id' => $aluno_id,
            ':data' => $data,
            ':bimestre_id' => $bimestre_id,
            ':turma_id' => $turma_id,
            ':disciplina_id' => $disciplina_id
        ]);

        if ($stmtCheck->rowCount() > 0) {
            // Atualiza o status do aluno na chamada
            $stmtUpdate = $pdo->prepare("UPDATE chamada 
                SET status = :status 
                WHERE aluno_id = :aluno_id 
                AND data = :data 
                AND bimestre_id = :bimestre_id 
                AND turma_id = :turma_id 
                AND disciplina_id = :disciplina_id");

            $stmtUpdate->execute([
                ':status' => $status,
                ':aluno_id' => $aluno_id,
                ':data' => $data,
                ':bimestre_id' => $bimestre_id,
                ':turma_id' => $turma_id,
                ':disciplina_id' => $disciplina_id
            ]);

            // Se o UPDATE for bem-sucedido, comita a transação
            $pdo->commit();
            header('Location: chamada.php?data=' . $data . '&bimestre_id=' . $bimestre_id . '&turma_id=' . $turma_id . '&status=success');
        } else {
            // Se não encontrar o registro, exibe uma mensagem de erro
            $pdo->rollBack();
            header('Location: chamada.php?data=' . $data . '&bimestre_id=' . $bimestre_id . '&turma_id=' . $turma_id . '&status=not_found');
        }
        exit();
    } catch (Exception $e) {
        // Em caso de erro, desfaz a transação
        $pdo->rollBack();
        // Exibe o erro para depuração
        echo "Erro: " . $e->getMessage();
        header('Location: chamada.php?data=' . $data . '&bimestre_id=' . $bimestre_id . '&turma_id=' . $turma_id . '&status=error');
        exit();
    }
} else {
    // Caso algum dado necessário esteja ausente
    header('Location: chamada.php?status=invalid');
    exit();
}
?>
