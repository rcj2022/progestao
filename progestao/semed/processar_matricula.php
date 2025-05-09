<?php
include 'config.php'; // Conexão com o banco de dados

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Captura e sanitiza os dados do formulário
    $turmaMatricula = filter_input(INPUT_POST, 'turma', FILTER_SANITIZE_NUMBER_INT);
    $nomeAluno = filter_input(INPUT_POST, 'Aluno', FILTER_SANITIZE_STRING); // Agora captura o nome diretamente
    $numeroMatricula = filter_input(INPUT_POST, 'numeroMatricula', FILTER_SANITIZE_NUMBER_INT);
    $tipoMatricula = filter_input(INPUT_POST, 'tipoMatricula', FILTER_SANITIZE_STRING);
    $situacaoAtual = filter_input(INPUT_POST, 'situacaoAtual', FILTER_SANITIZE_STRING);
    $disciplinas = filter_input(INPUT_POST, 'disciplinas', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

    // Validação dos campos obrigatórios
    if (empty($turmaMatricula) || empty($nomeAluno) || empty($numeroMatricula) || 
        empty($tipoMatricula) || empty($situacaoAtual) || empty($disciplinas)) {
        echo "<p class='text-danger'>Erro: Todos os campos são obrigatórios.</p>";
        exit;
    }

    try {
        // Serializa as disciplinas em formato JSON
        $disciplinasJson = json_encode($disciplinas);

        $sql = "INSERT INTO matriculados 
                (nomeAluno_id, numeroMatricula, tipoMatricula, situacaoAtual, disciplinas, turmaMatricula_id) 
                VALUES 
                (:nomeAluno, :numeroMatricula, :tipoMatricula, :situacaoAtual, :disciplinas, :turmaMatricula)";

        $stmt = $pdo->prepare($sql);
        
        $stmt->bindValue(':nomeAluno', $nomeAluno, PDO::PARAM_STR); // Agora usa o nome do aluno
        $stmt->bindValue(':numeroMatricula', $numeroMatricula, PDO::PARAM_INT);
        $stmt->bindValue(':tipoMatricula', $tipoMatricula, PDO::PARAM_STR);
        $stmt->bindValue(':situacaoAtual', $situacaoAtual, PDO::PARAM_STR);
        $stmt->bindValue(':disciplinas', $disciplinasJson, PDO::PARAM_STR);
        $stmt->bindValue(':turmaMatricula', $turmaMatricula, PDO::PARAM_INT);

        if ($stmt->execute()) {
            header("Location: listar_matriculas.php");
            exit;
        } else {
            echo "<p class='text-danger'>Erro ao cadastrar a matrícula.</p>";
        }

    } catch (PDOException $e) {
        echo "<p class='text-danger'>Erro no banco de dados: " . htmlspecialchars($e->getMessage()) . "</p>";
    }
} else {
    echo "<p class='text-danger'>Método de requisição inválido.</p>";
}
?>
