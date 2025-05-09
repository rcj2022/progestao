<?php
include 'config.php'; // Conexão com o banco de dados

try {
    // Preparando e executando a consulta
    $stmt = $pdo->prepare("SELECT * FROM professores");
    $stmt->execute();

    // Buscando os resultados
    $professores = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erro: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Professores</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h2>Lista de Professores</h2>

    <a href="painel_secretario.php" class="btn btn-secondary mb-2 mt-2">Voltar</a>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Nome</th>
                <th>CPF</th>
                <th>Endereço</th>
                <th>Formação</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($professores)) { ?>
                <?php foreach ($professores as $professor) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($professor['nome']); ?></td>
                        <td><?php echo htmlspecialchars($professor['cpf']); ?></td>
                        <td><?php echo htmlspecialchars($professor['endereco']); ?></td>
                        <td><?php echo htmlspecialchars($professor['formacao']); ?></td>
                        <td>
                            <a href="editar_professor.php?id=<?php echo $professor['id']; ?>" class="btn btn-warning btn-sm">Editar</a>
                            <a href="excluir_professor.php?id=<?php echo $professor['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir?');">Excluir</a>
                        </td>
                    </tr>
                <?php } ?>
            <?php } else { ?>
                <tr>
                    <td colspan="5" class="text-center">Nenhum professor encontrado.</td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
</body>
</html>

