<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php'); // Redireciona para a página de login
    exit();
}

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recebe os dados do formulário
    $id_disciplina = $_POST['id_disciplina'];
    $nome = $_POST['nome'];
    $carga_horaria = $_POST['carga_horaria'];
    $descricao = $_POST['descricao'];
    
    // Conectar ao banco de dados
    include 'config.php';

    try {
        // Prepara a query SQL para atualizar os dados
        $sql = "UPDATE disciplinas SET nome = :nome, carga_horaria = :carga_horaria, descricao = :descricao  WHERE id_disciplina = :id_disciplina";
        $stmt = $pdo->prepare($sql);

        // Vincula os parâmetros
        $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
        $stmt->bindParam(':carga_horaria', $carga_horaria, PDO::PARAM_INT);
        $stmt->bindParam(':descricao', $descricao, PDO::PARAM_STR);
        $stmt->bindParam(':id_disciplina', $id_disciplina, PDO::PARAM_INT);

        // Executa a query
        $stmt->execute();

        // Redireciona para uma página de sucesso
        header('Location: listar_disciplinas.php');
        exit();
    } catch (PDOException $e) {
        // Trata erros de conexão ou consulta
        die("Erro ao atualizar disciplina: " . $e->getMessage());
    }
} else {
    // Se o formulário não foi enviado, redireciona para o painel
    header('Location: painel_secretario.php');
    exit();
}
?>