<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php'); // Redireciona para a página de login
    exit();
}

// Recupera o ID da turma da URL
$id = $_GET['id'];

// Conectar ao banco de dados
include 'config.php';

try {
    // Busca os dados da turma com base no ID
    $sql = "SELECT * FROM turma WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    // Busca o resultado
    $turma = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$turma) {
        die("Turma não encontrada.");
    }
} catch (PDOException $e) {
    die("Erro ao buscar turma: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Turma</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-3 border p-3 bg-light w-50">
    <div class="d-flex justify-content-between align-items-center">
        <h4>Registro/Editar</h4>
        <a href="painel_secretario.php" class="btn btn-primary">Voltar</a>
    </div>
</div>
    <div class="container mt-3 border p-3 w-50">   
        <form action="atualizar_turma.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $turma['id']; ?>">
            <div class="mb-3">
                <label for="turma" class="form-label">Turma:</label>
                <input type="text" class="form-control" id="turma" name="turma" value="<?php echo htmlspecialchars($turma['nome']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="turno" class="form-label">Turma:</label>
                <input type="text" class="form-control" id="turno" name="turno" value="<?php echo htmlspecialchars($turma['turno']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="qtde_aluno" class="form-label">Turma:</label>
                <input type="text" class="form-control" id="qtde_aluno" name="qtde_aluno" value="<?php echo htmlspecialchars($turma['quantidade_maxima_alunos']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="exercicio" class="form-label">Turma:</label>
                <input type="text" class="form-control" id="exercicio" name="exercicio" value="<?php echo htmlspecialchars($turma['exercicio']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="curso" class="form-label">Turma:</label>
                <input type="text" class="form-control" id="curso" name="curso" value="<?php echo htmlspecialchars($turma['curso']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="etapa" class="form-label">Turma:</label>
                <input type="text" class="form-control" id="etapa" name="etapa" value="<?php echo htmlspecialchars($turma['etapa']); ?>" required>
            </div>
            
            <!-- Adicione os outros campos do formulário aqui -->
            <button type="submit" class="btn btn-primary">Salvar</button>
        </form>
    </div>
</body>
</html>