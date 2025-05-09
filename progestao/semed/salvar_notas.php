<?php
session_start();
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recupera os dados do formulário
    $turma = $_POST['turma'];
    $disciplina = $_POST['disciplina'];
    $bimestre = $_POST['bimestre'];
    $av1 = $_POST['av1'];
    $av2 = $_POST['av2'];
    $av3 = $_POST['av3'];
    $reav1 = $_POST['reav1'];
    $reav2 = $_POST['reav2'];
    $reav3 = $_POST['reav3'];

    // Inicia a transação
    try {
        $pdo->beginTransaction();

        foreach ($av1 as $alunoId => $notaAv1) {
            $notaAv2 = $av2[$alunoId];
            $notaAv3 = $av3[$alunoId];
            $notaReav1 = $reav1[$alunoId];
            $notaReav2 = $reav2[$alunoId];
            $notaReav3 = $reav3[$alunoId];

            // Calcula o total considerando as notas de recuperação
            $notaFinalAv1 = max($notaAv1, $notaReav1); // Usa a maior nota entre AV1 e REAV1
            $notaFinalAv2 = max($notaAv2, $notaReav2); // Usa a maior nota entre AV2 e REAV2
            $notaFinalAv3 = max($notaAv3, $notaReav3); // Usa a maior nota entre AV3 e REAV3
            $totalNota = $notaFinalAv1 + $notaFinalAv2 + $notaFinalAv3;

            // Verificar se a relação de notas já existe
            $sqlVerifica = "
                SELECT COUNT(*) FROM notas
                WHERE aluno_id = :aluno_id
                AND turma_id = (SELECT id FROM turma WHERE nome = :turma LIMIT 1)
                AND disciplina_id = (SELECT id_disciplina FROM disciplinas WHERE nome = :disciplina LIMIT 1)
                AND bimestre_id = (SELECT id FROM bimestres WHERE nome = :bimestre LIMIT 1)
            ";

            $stmtVerifica = $pdo->prepare($sqlVerifica);
            $stmtVerifica->bindParam(':aluno_id', $alunoId, PDO::PARAM_INT);
            $stmtVerifica->bindParam(':turma', $turma, PDO::PARAM_STR);
            $stmtVerifica->bindParam(':disciplina', $disciplina, PDO::PARAM_STR);
            $stmtVerifica->bindParam(':bimestre', $bimestre, PDO::PARAM_STR);
            $stmtVerifica->execute();
            $count = $stmtVerifica->fetchColumn();

            if ($count > 0) {
                // Atualiza as notas se já existir
                $sqlUpdate = "
                    UPDATE notas 
                    SET av1 = :av1, av2 = :av2, av3 = :av3,
                        reav1 = :reav1, reav2 = :reav2, reav3 = :reav3,
                        total = :total
                    WHERE aluno_id = :aluno_id
                    AND turma_id = (SELECT id FROM turma WHERE nome = :turma LIMIT 1)
                    AND disciplina_id = (SELECT id_disciplina FROM disciplinas WHERE nome = :disciplina LIMIT 1)
                    AND bimestre_id = (SELECT id FROM bimestres WHERE nome = :bimestre LIMIT 1)
                ";
                $stmt = $pdo->prepare($sqlUpdate);
            } else {
                // Insere novas notas se não existir
                $sqlInsert = "
                    INSERT INTO notas (aluno_id, turma_id, disciplina_id, bimestre_id, 
                                      av1, av2, av3, reav1, reav2, reav3, total)
                    VALUES (:aluno_id, 
                            (SELECT id FROM turma WHERE nome = :turma LIMIT 1),
                            (SELECT id_disciplina FROM disciplinas WHERE nome = :disciplina LIMIT 1),
                            (SELECT id FROM bimestres WHERE nome = :bimestre LIMIT 1),
                            :av1, :av2, :av3, :reav1, :reav2, :reav3, :total)
                ";
                $stmt = $pdo->prepare($sqlInsert);
            }

            // Bind dos parâmetros
            $stmt->bindParam(':av1', $notaAv1, PDO::PARAM_STR);
            $stmt->bindParam(':av2', $notaAv2, PDO::PARAM_STR);
            $stmt->bindParam(':av3', $notaAv3, PDO::PARAM_STR);
            $stmt->bindParam(':reav1', $notaReav1, PDO::PARAM_STR);
            $stmt->bindParam(':reav2', $notaReav2, PDO::PARAM_STR);
            $stmt->bindParam(':reav3', $notaReav3, PDO::PARAM_STR);
            $stmt->bindParam(':total', $totalNota, PDO::PARAM_STR);
            $stmt->bindParam(':aluno_id', $alunoId, PDO::PARAM_INT);
            $stmt->bindParam(':turma', $turma, PDO::PARAM_STR);
            $stmt->bindParam(':disciplina', $disciplina, PDO::PARAM_STR);
            $stmt->bindParam(':bimestre', $bimestre, PDO::PARAM_STR);

            // Executa a consulta de inserção ou atualização
            $stmt->execute();
        }

        // Finaliza a transação
        $pdo->commit();

        // Redireciona de volta com uma mensagem de sucesso
        header('Location: nota1bi.php?msg=Notas salvas com sucesso');
        exit;
    } catch (PDOException $e) {
        // Caso ocorra um erro, faz o rollback da transação
        $pdo->rollBack();
        die("Erro ao salvar as notas: " . $e->getMessage());
    }
}
?>