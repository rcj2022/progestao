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
    $nomeDisciplina = $_POST['nome_disciplina'];
    $cargaHoraria = $_POST['carga_horaria'];
    $descricao = $_POST['descricao'];

    try {
        // Conectar ao banco de dados usando PDO
        include 'config.php';

        // Configura o PDO para lançar exceções em caso de erro
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepara a query SQL para inserir os dados
        $sql = "INSERT INTO disciplinas (nome, carga_horaria, descricao) VALUES (:nome, :carga_horaria, :descricao)";
        $stmt = $pdo->prepare($sql);

        // Vincula os parâmetros
        $stmt->bindParam(':nome', $nomeDisciplina, PDO::PARAM_STR);
        $stmt->bindParam(':carga_horaria', $cargaHoraria, PDO::PARAM_INT);
        $stmt->bindParam(':descricao', $descricao, PDO::PARAM_STR);

        // Executa a query
        $stmt->execute();

        // Redireciona para uma página de sucesso
        header('Location: painel_secretario.php');
        exit();
    } catch (PDOException $e) {
        // Trata erros de conexão ou consulta
        die("Erro ao cadastrar disciplina: " . $e->getMessage());
    }
} else {
    // Se o formulário não foi enviado, redireciona para o painel
    header('Location: painel_secretario.php');
    exit();
}
?>