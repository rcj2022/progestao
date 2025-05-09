<?php
include 'config.php';
session_start();

// Obtém o ID do usuário logado (supondo que esteja na sessão)
$usuario_id = $_SESSION['usuario_id'] ?? null; 

// Inicializa a variável da escola
$escola_usuario = null;

if ($usuario_id) {
    // Busca o ID da escola na tabela vinculo_escola_usuario
    $stmt = $pdo->prepare("SELECT escola_id FROM vinculo_esc_usuario WHERE usuario_id = ?");
    $stmt->execute([$usuario_id]);
    $vinculo = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($vinculo) {
        $escola_id = $vinculo['escola_id'];

        // Busca os detalhes da escola
        $stmt = $pdo->prepare("SELECT * FROM escola WHERE id = ?");
        $stmt->execute([$escola_id]);
        $escola_usuario = $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

// Busca os demais dados
$alunos = getAlunos($pdo, $escola_id); // Passa o escola_id como parâmetro
$professores = getProfessores($pdo,$escola_id);
$disciplinas = getDisciplinas($pdo,$usuario_id);
$turmas = getTurmas($pdo);
$bimestres = getBimestres($pdo);




?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vincular</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-3 border border-4">
        <form action="processar.php" method="POST">
            <div class="mb-3">
                <label for="escola" class="form-label fw-bold" style="text-transform: uppercase">Escola:</label>
                <select class="form-select" id="escola" name="escola_id" required readonly>
                    <?php if ($escola_usuario): ?>
                        <option value="<?= $escola_usuario['id'] ?>" selected><?= $escola_usuario['nome'] ?></option>
                    <?php else: ?>
                        <option value="">Nenhuma escola encontrada</option>
                    <?php endif; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="aluno" class="form-label fw-bold" style="text-transform: uppercase">Aluno:</label>
                <select class="form-select" id="aluno" name="aluno_id[]" multiple required>
                    <option value="">Selecione um ou mais alunos</option>
                    <?php foreach ($alunos as $aluno): ?>
                        <option value="<?= $aluno['id'] ?>"><?= $aluno['nome'] ?></option>
                    <?php endforeach; ?>
                </select>
                <small class="form-text text-muted">Segure a tecla Ctrl (ou Cmd no Mac) para selecionar múltiplas opções.</small>
            </div>

            <div class="mb-3">
                <label for="professor" class="form-label fw-bold" style="text-transform: uppercase">Professor:</label>
                <select class="form-select" id="professor" name="professor_id" required>
                    <option value="">Selecione um professor</option>
                    <?php foreach ($professores as $professor): ?>
                        <option value="<?= $professor['id'] ?>"><?= $professor['nome'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="disciplina" class="form-label fw-bold" style="text-transform: uppercase">Disciplina:</label>
                <select class="form-select" id="disciplina" name="disciplina_id[]" multiple required>
                    <option value="">Selecione uma disciplina</option>
                    <?php foreach ($disciplinas as $disciplina): ?>
                        <option value="<?= $disciplina['id_disciplina'] ?>"><?= $disciplina['nome'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="turma" class="form-label fw-bold" style="text-transform: uppercase">Turma:</label>
                <select class="form-select" id="turma" name="turma_id[]" multiple required>
                    <option value="">Selecione uma ou mais turmas</option>
                    <?php foreach ($turmas as $turma): ?>
                        <option value="<?= $turma['id'] ?>"><?= $turma['nome'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="bimestre" class="form-label fw-bold" style="text-transform: uppercase">Bimestre:</label>
                <select class="form-select" id="bimestre" name="bimestre_id[]" multiple required>
                    <option value="">Selecione um bimestre</option>
                    <?php foreach ($bimestres as $bimestre): ?>
                        <option value="<?= $bimestre['id'] ?>"><?= $bimestre['nome'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="text-end mt-3">
    <button type="submit" class="btn btn-primary">Vincular</button>
    <a href="listar_matriculas.php" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Voltar
    </a>
</div>

        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>