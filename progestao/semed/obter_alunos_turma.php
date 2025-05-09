<?php
session_start();
include 'config.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit();
}

$usuario_id = $_SESSION['usuario_id'];

// Obtém a escola do usuário logado
$sql = "SELECT escola_id FROM vinculo_esc_usuario WHERE usuario_id = :usuario_id LIMIT 1";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
$stmt->execute();
$escola = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$escola) {
    die("Erro: Usuário não está vinculado a nenhuma escola.");
}

$escola_id = $escola['escola_id'];

// Filtros recebidos
$turma_id = $_GET['turma_id'] ?? null;
$disciplina_id = $_GET['disciplina_id'] ?? null;
$turma_especifica = !empty($turma_id) && $turma_id !== "todas";
$disciplina_especifica = !empty($disciplina_id) && $disciplina_id !== "todas";

// Se uma turma específica for selecionada, obter seu nome
$turma_nome = "Todas";
if ($turma_especifica) {
    $stmtTurma = $pdo->prepare("SELECT nome FROM turma WHERE id = ?");
    $stmtTurma->execute([$turma_id]);
    $turma = $stmtTurma->fetch(PDO::FETCH_ASSOC);
    if ($turma) {
        $turma_nome = $turma['nome'];
    }
}

// Buscar disciplinas associadas à turma selecionada
$disciplinas = [];
if ($turma_especifica) {
    $stmtDisciplinas = $pdo->prepare("
        SELECT DISTINCT d.id_disciplina, d.nome 
        FROM vinculos v
        JOIN disciplinas d ON v.disciplina_id = d.id_disciplina
        WHERE v.turma_id = ?
        ORDER BY d.nome ASC
    ");
    $stmtDisciplinas->execute([$turma_id]);
    $disciplinas = $stmtDisciplinas->fetchAll(PDO::FETCH_ASSOC);
}

// Buscar alunos apenas se uma disciplina específica for selecionada
$alunos = [];
if ($turma_especifica && $disciplina_especifica) {
    $query = "
        SELECT DISTINCT a.nome AS aluno_nome, d.nome AS disciplina_nome
        FROM vinculos v
        JOIN alunos a ON v.aluno_id = a.id
        JOIN disciplinas d ON v.disciplina_id = d.id_disciplina
        WHERE v.turma_id = ? AND v.disciplina_id = ?
        ORDER BY a.nome ASC
    ";
    
    $stmtAlunos = $pdo->prepare($query);
    $stmtAlunos->execute([$turma_id, $disciplina_id]);
    $alunos = $stmtAlunos->fetchAll(PDO::FETCH_ASSOC);
}

// Consultas para os selects de turmas
$turmas = $pdo->prepare("
    SELECT DISTINCT t.id, t.nome 
    FROM vinculos v 
    JOIN turma t ON v.turma_id = t.id 
    WHERE v.escola_id = :escola_id 
    ORDER BY t.nome ASC
");
$turmas->execute(['escola_id' => $escola_id]);
$turmas = $turmas->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes da Turma</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script>
        function autoSubmit() {
            document.getElementById('filterForm').submit();
        }

        function imprimirTabela() {
            var conteudo = document.getElementById('tabelaAlunos').innerHTML;
            var janela = window.open('', '', 'width=800,height=600');
            janela.document.write('<html><head><title>Impressão</title>');
            janela.document.write('<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">');
            janela.document.write('</head><body>');
            janela.document.write(conteudo);
            janela.document.write('</body></html>');
            janela.document.close();
            janela.print();
        }
    </script>
</head>
<body>
<div class="container mt-5">
    <form method="GET" id="filterForm" class="row g-3">
        <div class="col-md-4">
            <label class="form-label">Turma:</label>
            <select name="turma_id" class="form-select" onchange="autoSubmit()">
                <option value="todas" <?= !$turma_especifica ? 'selected' : '' ?>>Todas</option>
                <?php foreach ($turmas as $turma): ?>
                    <option value="<?= $turma['id'] ?>" <?= ($turma_id == $turma['id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($turma['nome']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <?php if ($turma_especifica): ?>
        <div class="col-md-4">
            <label class="form-label">Disciplina:</label>
            <select name="disciplina_id" class="form-select" onchange="autoSubmit()">
                <option value="todas" <?= !$disciplina_especifica ? 'selected' : '' ?>>Todas</option>
                <?php foreach ($disciplinas as $disciplina): ?>
                    <option value="<?= $disciplina['id_disciplina'] ?>" <?= ($disciplina_id == $disciplina['id_disciplina']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($disciplina['nome']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <?php endif; ?>
    </form>

    <?php if ($turma_especifica && $disciplina_especifica): ?>
        <?php if (!empty($alunos)): ?>
            <div id="tabelaAlunos">
                <table class="table table-striped table-bordered mt-3">
                    <thead>
                        <tr>
                            <th>Nº</th>
                            <th>Aluno</th>
                            <th>Disciplina</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $contador = 1;
                        foreach ($alunos as $aluno): ?>
                            <tr>
                                <td><?= $contador++ ?></td>
                                <td><?= htmlspecialchars($aluno['aluno_nome']) ?></td>
                                <td><?= htmlspecialchars($aluno['disciplina_nome']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <button class="btn btn-primary mt-3" onclick="imprimirTabela()">Imprimir</button>
        <?php else: ?>
            <p class="mt-3">Nenhum aluno encontrado para os filtros selecionados.</p>
        <?php endif; ?>
    <?php endif; ?>

    <a href="painel_secretario.php" class="btn btn-secondary mt-3">Voltar</a>
</div>
</body>
</html>