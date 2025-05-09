<?php
session_start();

// Verifica se o método de requisição é POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recupera os dados do formulário
    $turma = $_POST['turma'];
    $turno = $_POST['turno'];
    $quantidade_alunos = $_POST['quantidade_alunos'];
    $exercicio = $_POST['exercicio'];
    $curso = $_POST['curso'];
    $etapa = $_POST['etapa'];

    try {
        // Conectar ao banco de dados usando PDO
        include 'config.php';

        // Configura o PDO para lançar exceções em caso de erro
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepara a query de inserção
        $sql = "INSERT INTO turma (nome, turno, quantidade_maxima_alunos, exercicio, curso, etapa) 
                VALUES (:turma, :turno, :quantidade_alunos, :exercicio, :curso, :etapa)";
        $stmt = $pdo->prepare($sql);

        // Vincula os parâmetros
        $stmt->bindParam(':turma', $turma, PDO::PARAM_STR);
        $stmt->bindParam(':turno', $turno, PDO::PARAM_STR);
        $stmt->bindParam(':quantidade_alunos', $quantidade_alunos, PDO::PARAM_INT);
        $stmt->bindParam(':exercicio', $exercicio, PDO::PARAM_STR);
        $stmt->bindParam(':curso', $curso, PDO::PARAM_STR);
        $stmt->bindParam(':etapa', $etapa, PDO::PARAM_STR);

        // Executa a query
        $stmt->execute();

        // Redireciona para a página do painel do secretário
        header('Location: painel_secretario.php');
        exit(); // Encerra a execução do script
    } catch (PDOException $e) {
        // Captura e exibe erros
        echo "Erro ao cadastrar turma: " . $e->getMessage();
    } finally {
        // Fecha a conexão
        $pdo = null;
    }
} else {
    echo "Método de requisição inválido.";
}
?>