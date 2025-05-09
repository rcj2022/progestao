<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php'); // Redireciona para a página de login
    exit();
}

// Conectar ao banco de dados
include 'config.php';

try {
    // Configura o PDO para lançar exceções em caso de erro
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Consulta para buscar todas as disciplinas
    $sql = "SELECT * FROM disciplinas"; // Certifique-se de que o nome da tabela está correto
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    // Busca todos os resultados
    $disciplinas = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Trata erros de conexão ou consulta
    die("Erro ao buscar disciplinas: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar Disciplinas</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome para ícones -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-3 border p-3 bg-light">
    <div class="d-flex justify-content-between align-items-center">
        <h4>Registro/Listar</h4>
        <a href="painel_secretario.php" class="btn btn-primary">Voltar</a>
    </div>
</div>
<div class="container mt-3 border p-3">
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Disciplina</th>
                <th>Carga Horária</th>
                <th>Descrição</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($disciplinas) > 0): ?>
                <?php foreach ($disciplinas as $disciplina): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($disciplina['id_disciplina']); ?></td>
                        <td><?php echo htmlspecialchars($disciplina['nome']); ?></td>
                        <td><?php echo htmlspecialchars($disciplina['carga_horaria']); ?></td>
                        <td><?php echo htmlspecialchars($disciplina['descricao']); ?></td>
                        <td>
                            <a href="editar_disciplina.php?id_disciplina=<?php echo $disciplina['id_disciplina']; ?>" class="btn btn-sm btn-warning">Editar</a>
                            <a href="excluir_disciplina.php?id_disciplina=<?php echo $disciplina['id_disciplina']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir esta disciplina?')">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center">Nenhuma disciplina cadastrada.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>