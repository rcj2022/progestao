<?php
include 'config.php';
session_start();

// Verifica se o usuário está autenticado
$professor_id = $_SESSION['usuario_id'] ?? null;
if (!$professor_id) {
    die('Usuário não autenticado.');
}

// Verifica se o ID da chamada foi fornecido
$id_chamada = $_GET['id'] ?? null;
if (!$id_chamada) {
    die('ID da chamada não fornecido.');
}

// Busca os dados da chamada
$sql = "SELECT c.*, a.nome AS aluno_nome FROM chamada c INNER JOIN alunos a ON c.aluno_id = a.id WHERE c.id = :id_chamada";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id_chamada', $id_chamada, PDO::PARAM_INT);
$stmt->execute();
$chamada = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$chamada) {
    die('Chamada não encontrada.');
}

// Processa o formulário de edição
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $status = $_POST['status'] ?? null;
    $data = $_POST['data'] ?? null;

    if ($status && $data) {
        // Atualiza o status e a data da chamada
        $sqlUpdate = "UPDATE chamada SET status = :status, data = :data WHERE id = :id_chamada";
        $stmtUpdate = $pdo->prepare($sqlUpdate);
        $stmtUpdate->bindParam(':status', $status);
        $stmtUpdate->bindParam(':data', $data);
        $stmtUpdate->bindParam(':id_chamada', $id_chamada, PDO::PARAM_INT);
        $stmtUpdate->execute();

        header('Location: listar_chamada.php'); // Redireciona de volta para a lista
        exit;
    } else {
        $error = "Status e data não podem ser vazios.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Chamada</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5 border border-3">
    <h2>Editar Chamada</h2>

    <?php if (isset($error)) : ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($error, ENT_QUOTES); ?></div>
    <?php endif; ?>

    <form action="editar_chamada.php?id=<?php echo $chamada['id']; ?>" method="post">
        <div class="mb-3">
            <label class="form-label">Aluno</label>
            <input type="text" class="form-control" value="<?php echo htmlspecialchars($chamada['aluno_nome'], ENT_QUOTES); ?>" disabled>
        </div>

        <div class="mb-3">
            <label for="data" class="form-label">Data</label>
            <input type="date" class="form-control" id="data" name="data" value="<?php echo date('Y-m-d', strtotime($chamada['data'])); ?>" required>
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select class="form-select" id="status" name="status" required>
                <option value="Presente" <?php echo ($chamada['status'] == 'Presente') ? 'selected' : ''; ?>>Presente</option>
                <option value="Ausente" <?php echo ($chamada['status'] == 'Ausente') ? 'selected' : ''; ?>>Ausente</option>
                <option value="Justificado" <?php echo ($chamada['status'] == 'Justificado') ? 'selected' : ''; ?>>Justificado</option>
            </select>
        </div>

        <div class="d-flex justify-content-end">
    <button type="submit" class="btn btn-success me-2">Salvar Alterações</button>
    <a href="listar_chamada.php" class="btn btn-secondary">Cancelar</a>
</div>

    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
