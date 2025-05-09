<?php
include 'config.php';

// Verifica se o ID foi enviado para edição
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID da aula não fornecido.");
}

$id = intval($_GET['id']);

// Busca os dados da aula no banco
try {
    // Consulta para buscar os dados da aula com os nomes da turma e do bimestre
    $sql = "SELECT a.*, t.nome AS turma_nome, b.nome AS periodo_nome 
            FROM aulas a
            JOIN turma t ON a.turma_id = t.id
            JOIN bimestres b ON a.periodo_id = b.id
            WHERE a.id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $aula = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$aula) {
        die("Nenhuma aula encontrada.");
    }
} catch (PDOException $e) {
    die("Erro ao buscar a aula: " . $e->getMessage());
}

// Atualiza os dados da aula
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $turma_id = $_POST['turma_id']; // Recebe o ID da turma
    $periodo_id = $_POST['periodo_id']; // Recebe o ID do período
    $data = $_POST['dia'];
    $conteudo = $_POST['conteudo'];
    $quantidade = $_POST['quantidade'];

    try {
        $sql_update = "UPDATE aulas SET turma_id = :turma_id, periodo_id = :periodo_id, dia = :dia, conteudo = :conteudo, quantidade = :quantidade WHERE id = :id";
        $stmt = $pdo->prepare($sql_update);
        $stmt->execute([
            ':turma_id' => $turma_id,
            ':periodo_id' => $periodo_id,
            ':dia' => $data,
            ':conteudo' => $conteudo,
            ':quantidade' => $quantidade,
            ':id' => $id
        ]);
        header("Location: listar_aula.php");
        exit;
    } catch (PDOException $e) {
        echo "Erro ao atualizar a aula: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Aula</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <table class="table table-bordered">
        <tr>
            <td class="text-start">
                <h1 class="mb-3" style="color: green; font-size: 24px;">EDITAR AULAS</h1>
            </td>
        </tr>
    </table>
    <form method="POST">
        <div class="card">
            <div class="card-body">
                <!-- Campos ocultos para enviar os IDs -->
                <input type="hidden" name="turma_id" value="<?= htmlspecialchars($aula['turma_id'] ?? ''); ?>">
                <input type="hidden" name="periodo_id" value="<?= htmlspecialchars($aula['periodo_id'] ?? ''); ?>">

                <div class="mb-3">
                    <label for="turma" class="form-label">Turma</label>
                    <input type="text" class="form-control bg-light" id="turma" name="turma" value="<?= htmlspecialchars($aula['turma_nome'] ?? ''); ?>" readonly>
                </div>
                <div class="mb-3">
                    <label for="periodo" class="form-label">Período</label>
                    <input type="text" class="form-control bg-light" id="periodo" name="periodo" value="<?= htmlspecialchars($aula['periodo_nome'] ?? ''); ?>" readonly>
                </div>
                <div class="mb-3">
                    <label for="dia" class="form-label">Data</label>
                    <input type="date" class="form-control" id="dia" name="dia" value="<?= htmlspecialchars($aula['dia'] ?? ''); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="conteudo" class="form-label">Conteúdo</label>
                    <textarea class="form-control" id="conteudo" name="conteudo" rows="4" required><?= htmlspecialchars($aula['conteudo'] ?? ''); ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="quantidade" class="form-label">Aulas ministradas</label>
                    <input type="number" class="form-control" id="quantidade" name="quantidade" min="1" value="<?= htmlspecialchars($aula['quantidade'] ?? ''); ?>" required>
                </div>
                <div class="d-flex justify-content-end">
                    <a href="listar_aula.php" class="btn btn-secondary me-2">Cancelar</a>
                    <button type="submit" class="btn btn-success">Salvar Alterações</button>
                </div>
            </div>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>