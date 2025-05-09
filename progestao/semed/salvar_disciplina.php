<?php
include 'config.php'; // Arquivo de conexão com o banco

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $turma_ids = $_POST['turma_ids'];
    $disciplina_ids = $_POST['disciplina_id'];
    $tipo_disciplina = $_POST['tipo_disciplina'];
    $professor_id = $_POST['professor_id'];
    $carga_horaria = $_POST['carga_horaria'];
    $carga_horaria_semanal = $_POST['carga_horaria_semanal'];

    // Obtém a escola do professor
    $sql_escola = "SELECT escola_id FROM usuarios WHERE id = :professor_id";
    $stmt_escola = $pdo->prepare($sql_escola);
    $stmt_escola->bindValue(':professor_id', $professor_id);
    $stmt_escola->execute();
    $escola = $stmt_escola->fetch(PDO::FETCH_ASSOC);

    if (!$escola) {
        echo "<script>alert('Erro: Escola do professor não encontrada.'); history.back();</script>";
        exit;
    }

    $escola_id = $escola['escola_id'];

    // Prepara a consulta SQL com escola_id
    $sql = "INSERT INTO disciplina_individual (turma_id, disciplina_id, tipo_disciplina, usuario_id, carga_horaria, carga_horaria_semanal, escola_id) 
            VALUES (:turma_id, :disciplina_id, :tipo_disciplina, :usuario_id, :carga_horaria, :carga_horaria_semanal, :escola_id)";

    $pdo->beginTransaction();

    try {
        $stmt = $pdo->prepare($sql);

        foreach ($turma_ids as $turma_id) {
            foreach ($disciplina_ids as $disciplina_id) {
                $stmt->bindValue(':turma_id', $turma_id);
                $stmt->bindValue(':disciplina_id', $disciplina_id);
                $stmt->bindValue(':tipo_disciplina', $tipo_disciplina);
                $stmt->bindValue(':usuario_id', $professor_id);
                $stmt->bindValue(':carga_horaria', $carga_horaria);
                $stmt->bindValue(':carga_horaria_semanal', $carga_horaria_semanal);
                $stmt->bindValue(':escola_id', $escola_id);

                if (!$stmt->execute()) {
                    $errorInfo = $stmt->errorInfo();
                    throw new Exception("Erro ao cadastrar disciplina ID: $disciplina_id para a turma ID: $turma_id. Detalhes: " . $errorInfo[2]);
                }
            }
        }

        $pdo->commit();
        echo "<script>alert('Disciplinas cadastradas com sucesso!'); window.location='disciplina_listar.php';</script>";
    } catch (Exception $e) {
        $pdo->rollBack();
        echo "<script>alert('Erro ao cadastrar disciplinas: " . $e->getMessage() . "'); history.back();</script>";
    }
} else {
    echo "<script>alert('Acesso inválido!'); window.location='frm_disc_individual.php';</script>";
}
?>
