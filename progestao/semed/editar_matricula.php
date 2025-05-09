<?php
include 'config.php';

// Verifica se o ID da matrícula foi passado na URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Busca os dados da matrícula no banco
    $sql = "SELECT * FROM matriculados WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    $matricula = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$matricula) {
        echo "<script>alert('Matrícula não encontrada!'); window.location='matricula.php';</script>";
        exit();
    }
} else {
    echo "<script>alert('ID inválido!'); window.location='matricula.php';</script>";
    exit();
}

// Consulta para buscar as turmas
$sql = "SELECT id, nome FROM turma";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$turmas = $stmt->fetchAll(PDO::FETCH_ASSOC);





// Processa a atualização no banco de dados
if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    $nomeAluno = $_POST['nomeAluno'];
    $numeroMatricula = $_POST['numeroMatricula'];
    $tipoMatricula = $_POST['tipoMatricula'];
    $situacaoAtual = $_POST['situacaoAtual'];
    $disciplinas = implode(", ", $_POST['disciplinas'] ?? []);
    $turma = $_POST['nomeTurma'];
  

    $sqlUpdate = "UPDATE matriculados SET nomeAluno_id=?, numeroMatricula=?, tipoMatricula=?, situacaoAtual=?, disciplinas=?, turmaMatricula_id=? WHERE id=?";
    $stmtUpdate = $pdo->prepare($sqlUpdate);
    $stmtUpdate->execute([$nomeAluno, $numeroMatricula, $tipoMatricula, $situacaoAtual, $disciplinas,$turma,  $id]);

    if ($stmtUpdate->rowCount() > 0) {
        echo "<script>alert('Matrícula atualizada com sucesso!'); window.location='listar_matriculas.php';</script>";
    } else {
        echo "<script>alert('Você precisa alterar os dados do aluno para continua a atualizar matrícula!');</script>";
    }
}
?>



<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Matrícula</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Editar Matrícula</h2>
   
    <form method="POST">
        <div class="row">
            <div class="col-md-6 border p-3">
            <div class="mb-3">
    <label for="nomeTurma" class="form-label">Turma</label>
    <select class="form-control" id="nomeTurma" name="nomeTurma" required>
        <option value="">Selecione uma turma</option>
        <?php foreach ($turmas as $turma): ?>
            <option value="<?= htmlspecialchars($turma['id']) ?>" <?= (isset($matricula['nome']) && $matricula['nome'] == $turma['id']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($turma['nome']) ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>
                <div class="mb-3">
                    <label for="nomeAluno" class="form-label">Nome do Aluno</label>
                    <input type="text" class="form-control" id="nomeAluno" name="nomeAluno" value="<?= htmlspecialchars($matricula['nomeAluno_id'] ?? '') ?>" required>
                </div>

                <div class="mb-3">
                    <label for="numeroMatricula" class="form-label">Número de Matrícula</label>
                    <input type="text" class="form-control" id="numeroMatricula" name="numeroMatricula" value="<?= htmlspecialchars($matricula['numeroMatricula'] ?? '') ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Tipo de Matrícula</label>
                    <div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="tipoMatricula" value="REGULAR" <?= ($matricula['tipoMatricula'] ?? '') == 'REGULAR' ? 'checked' : '' ?>>
                            <label class="form-check-label">Regular</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="tipoMatricula" value="OUTRO" <?= ($matricula['tipoMatricula'] ?? '') == 'OUTRO' ? 'checked' : '' ?>>
                            <label class="form-check-label">Outro</label>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Situação Atual</label>
                    <div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="situacaoAtual" value="CURSANDO" <?= ($matricula['situacaoAtual'] ?? '') == 'CURSANDO' ? 'checked' : '' ?>>
                            <label class="form-check-label">Cursando</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="situacaoAtual" value="TRANSFERIDO" <?= ($matricula['situacaoAtual'] ?? '') == 'TRANSFERIDO' ? 'checked' : '' ?>>
                            <label class="form-check-label">Transferido</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="situacaoAtual" value="FORMADO" <?= ($matricula['situacaoAtual'] ?? '') == 'FORMADO' ? 'checked' : '' ?>>
                            <label class="form-check-label">Formado</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 border p-3">
            <div class="mb-3">
    <label class="form-label">Disciplinas</label>
    <div>
        <?php
        // Lista de todas as disciplinas
        $todasDisciplinas = ["LÍNGUA PORTUGUESA", "LÍNGUA ESTRANGEIRA: INGLÊS", "CIÊNCIAS", "MATEMÁTICA", "GEOGRAFIA", "ARTE", "ENSINO RELIGIOSO", "EDUCAÇÃO FÍSICA", "HISTÓRIA"];

        // Loop para criar os checkboxes
        foreach ($todasDisciplinas as $disciplina) {
            // Marca todos os checkboxes como "checked"
            $checked = 'checked';
            echo "<div class='form-check'>
                    <input class='form-check-input' type='checkbox' name='disciplinas[]' value='$disciplina' $checked>
                    <label class='form-check-label'>$disciplina</label>
                  </div>";
        }
        ?>
    </div>
</div>
                </div>
            </div>
        </div>

        <div class="text-center mt-2">
            <button type="submit" class="btn btn-primary">Salvar</button>
            <a href="matricula.php" class="btn btn-secondary">Voltar</a>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>