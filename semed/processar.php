<?php
include 'config.php';

// Coleta os dados do formulário como arrays
$aluno_ids = $_POST['aluno_id']; 
$professor_id = $_POST['professor_id']; 
$disciplina_ids = $_POST['disciplina_id']; // Agora é array
$turma_ids = $_POST['turma_id']; 
$bimestre_ids = $_POST['bimestre_id']; // Agora é array
$id_escola = $_POST['escola_id']; 

try {
    // Prepara a query SQL para verificar se o vínculo já existe
    $sql_check = "SELECT COUNT(*) FROM vinculos 
                  WHERE aluno_id = :aluno_id 
                  AND usuario_id = :usuario_id 
                  AND disciplina_id = :disciplina_id 
                  AND turma_id = :turma_id 
                  AND bimestre_id = :bimestre_id 
                  AND escola_id = :escola_id";

    $stmt_check = $pdo->prepare($sql_check);

    // Prepara a query SQL para inserir ou atualizar os dados
    $sql = "INSERT INTO vinculos (aluno_id, usuario_id, disciplina_id, turma_id, bimestre_id, escola_id)
            VALUES (:aluno_id, :usuario_id, :disciplina_id, :turma_id, :bimestre_id, :escola_id)
            ON DUPLICATE KEY UPDATE
                usuario_id = :usuario_id,
                disciplina_id = :disciplina_id,
                turma_id = :turma_id,
                bimestre_id = :bimestre_id,
                escola_id = :escola_id";

    $stmt = $pdo->prepare($sql);

    // Itera sobre todas as combinações de aluno, turma, disciplina e bimestre
    foreach ($aluno_ids as $aluno_id) {
        foreach ($turma_ids as $turma_id) {
            foreach ($disciplina_ids as $disciplina_id) {
                foreach ($bimestre_ids as $bimestre_id) {
                    
                    // Verifica se o vínculo já existe
                    $stmt_check->execute([
                        ':aluno_id' => $aluno_id,
                        ':usuario_id' => $professor_id,
                        ':disciplina_id' => $disciplina_id,
                        ':turma_id' => $turma_id,
                        ':bimestre_id' => $bimestre_id,
                        ':escola_id' => $id_escola
                    ]);

                    // Se o vínculo não existir, executa a inserção
                    if ($stmt_check->fetchColumn() == 0) {
                        $stmt->execute([
                            ':aluno_id' => $aluno_id,
                            ':usuario_id' => $professor_id,
                            ':disciplina_id' => $disciplina_id,
                            ':turma_id' => $turma_id,
                            ':bimestre_id' => $bimestre_id,
                            ':escola_id' => $id_escola
                        ]);
                    } else {
                        // Atualiza os dados caso já exista
                        $stmt->execute([
                            ':aluno_id' => $aluno_id,
                            ':usuario_id' => $professor_id,
                            ':disciplina_id' => $disciplina_id,
                            ':turma_id' => $turma_id,
                            ':bimestre_id' => $bimestre_id,
                            ':escola_id' => $id_escola
                        ]);
                    }
                }
            }
        }
    }

    // Redireciona para listar_matriculas.php com status de sucesso
    header("Location: listar_matriculas.php?status=success");
    exit();
    
} catch (PDOException $e) {
    // Redireciona para listar_matriculas.php com mensagem de erro
    header("Location: listar_matriculas.php?status=error&message=" . urlencode($e->getMessage()));
    exit();
}

// Fecha a conexão (opcional)
$pdo = null;
?>
