<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php'); // Redireciona para a página de login
    exit();
}

// Recupera o ID da disciplina da URL
if (!isset($_GET['id_disciplina'])) {
    header('Location: painel_secretario.php'); // Redireciona se o ID não estiver presente
    exit();
}

$id_disciplina = $_GET['id_disciplina'];

// Conectar ao banco de dados
include 'config.php';

try {
    // Busca os dados da disciplina com base no ID
    $sql = "SELECT * FROM disciplinas WHERE id_disciplina = :id_disciplina";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id_disciplina', $id_disciplina, PDO::PARAM_INT);
    $stmt->execute();

    // Busca o resultado
    $disciplina = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$disciplina) {
        die("Disciplina não encontrada.");
    }
} catch (PDOException $e) {
    die("Erro ao buscar disciplina: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Disciplina</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-3 border p-3 bg-light w-50">
    <div class="d-flex justify-content-between align-items-center">
        <h4>Editar Disciplina</h4>
        <a href="painel_secretario.php" class="btn btn-primary">Voltar</a>
    </div>
</div>
<div class="container mt-3 border p-3 w-50">   
    <form action="atualizar_disciplina.php" method="POST">
        <input type="hidden" name="id_disciplina" value="<?php echo $disciplina['id_disciplina']; ?>">
        <div class="mb-3">
            <label for="nome" class="form-label">Nome da Disciplina:</label>
            <input type="text" class="form-control" id="nome" name="nome" value="<?php echo htmlspecialchars($disciplina['nome']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="carga_horaria" class="form-label">Carga Horária:</label>
            <input type="number" class="form-control" id="carga_horaria" name="carga_horaria" value="<?php echo htmlspecialchars($disciplina['carga_horaria']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="descricao" class="form-label">Descrição:</label>
            <textarea class="form-control" id="descricao" name="descricao" required><?php echo htmlspecialchars($disciplina['descricao']); ?></textarea>
        </div>
     
        <button type="submit" class="btn btn-primary">Salvar</button>
    </form>
</div>
</body>
</html>