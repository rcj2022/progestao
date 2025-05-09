<?php
include 'config.php'; // Conexão com o banco de dados

// Verifica se o ID foi passado na URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "ID inválido!";
    exit;
}

$id = $_GET['id'];

// Busca os dados da disciplina
$sql = "SELECT * FROM disciplina_individual WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$disciplina = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$disciplina) {
    echo "Disciplina não encontrada!";
    exit;
}

// Busca as turmas, disciplinas e professores para preencher os selects
$turmas = $pdo->query("SELECT id, nome FROM turma")->fetchAll(PDO::FETCH_ASSOC);
$disciplinas = $pdo->query("SELECT id_disciplina, nome FROM disciplinas")->fetchAll(PDO::FETCH_ASSOC);
$professores = $pdo->query("SELECT id, nome FROM professores")->fetchAll(PDO::FETCH_ASSOC);

// Atualiza os dados se o formulário for enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $turma_id = $_POST['turma_id'];
    $disciplina_id = $_POST['disciplina_id'];
    $professor_id = $_POST['usuario_id'];
    $tipo_disciplina = $_POST['tipo_disciplina'];
    $carga_horaria = $_POST['carga_horaria'];
    $carga_horaria_semanal = $_POST['carga_horaria_semanal'];

    $sql = "UPDATE disciplina_individual 
            SET turma_id = :turma_id, disciplina_id = :disciplina_id, usuario_id = :usuario_id, 
                tipo_disciplina = :tipo_disciplina, carga_horaria = :carga_horaria, 
                carga_horaria_semanal = :carga_horaria_semanal
            WHERE id = :id";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':turma_id', $turma_id);
    $stmt->bindParam(':disciplina_id', $disciplina_id);
    $stmt->bindParam(':usuario_id', $professor_id);
    $stmt->bindParam(':tipo_disciplina', $tipo_disciplina);
    $stmt->bindParam(':carga_horaria', $carga_horaria);
    $stmt->bindParam(':carga_horaria_semanal', $carga_horaria_semanal);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo "<script>alert('Disciplina atualizada com sucesso!'); window.location='disciplina_listar.php';</script>";
    } else {
        echo "<script>alert('Erro ao atualizar disciplina!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Disciplina</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Disciplina/Editar</h4>
        </div>
        <div class="card-body">
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Turma</label>
                    <select name="turma_id" class="form-control" required>
                        <option value="">Selecione uma turma</option>
                        <?php foreach ($turmas as $turma): ?>
                            <option value="<?= $turma['id']; ?>" <?= ($disciplina['turma_id'] == $turma['id']) ? 'selected' : ''; ?>>
                                <?= htmlspecialchars($turma['nome'] ?? ''); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Disciplina</label>
                    <select name="disciplina_id" class="form-control" required>
                        <option value="">Selecione uma disciplina</option>
                        <?php foreach ($disciplinas as $disc): ?>
                            <option value="<?= $disc['id_disciplina']; ?>" <?= ($disciplina['disciplina_id'] == $disc['id_disciplina']) ? 'selected' : ''; ?>>
                                <?= htmlspecialchars($disc['nome'] ?? ''); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Professor</label>
                    <select name="professor_id" class="form-control" required>
                        <option value="">Selecione um professor</option>
                        <?php foreach ($professores as $prof): ?>
                            <option value="<?= $prof['id']; ?>" <?= ($disciplina['usuario_id'] == $prof['id']) ? 'selected' : ''; ?>>
                                <?= htmlspecialchars($prof['nome'] ?? ''); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Tipo</label>
                    <input type="text" name="tipo_disciplina" class="form-control" value="<?= htmlspecialchars($disciplina['tipo_disciplina'] ?? ''); ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Carga Horária</label>
                    <input type="number" name="carga_horaria" class="form-control" value="<?= htmlspecialchars($disciplina['carga_horaria'] ?? ''); ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Carga Horária Semanal</label>
                    <input type="number" name="carga_horaria_semanal" class="form-control" value="<?= htmlspecialchars($disciplina['carga_horaria_semanal'] ?? ''); ?>" required>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="disciplina_listar.php" class="btn btn-secondary">Voltar</a>
                    <button type="submit" class="btn btn-success">Salvar Alterações</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>