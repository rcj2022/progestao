<?php
include 'config.php';
session_start(); // Certifique-se de iniciar a sessão

// Garante que o ID do professor esteja na sessão
$professor_id = $_SESSION['usuario_id'] ?? null;
if (!$professor_id) {
    die('Usuário não autenticado.');
}

// Consultar as disciplinas vinculadas ao professor logado
$sqlDisciplina = "
    SELECT DISTINCT d.id_disciplina, d.nome 
    FROM vinculos v
    INNER JOIN disciplinas d ON v.disciplina_id = d.id_disciplina
    WHERE v.usuario_id = :usuario_id
    ORDER BY d.nome
";
$stmtDisciplina = $pdo->prepare($sqlDisciplina);
$stmtDisciplina->bindParam(':usuario_id', $professor_id, PDO::PARAM_INT);
$stmtDisciplina->execute();
$disciplinas = $stmtDisciplina->fetchAll(PDO::FETCH_ASSOC);

// Consultar alunos vinculados à disciplina e turma selecionada
$disciplinasComAlunos = [];
// Defina a variável $data com base no valor selecionado ou na data atual
$datasExistentes = [];
// Consulta para buscar as datas já registradas na tabela chamada, ordenando pelo mês
$sql = "SELECT DISTINCT DATE_FORMAT(data, '%d/%m/%Y') as data 
        FROM chamada 
        ORDER BY MONTH(data) ASC, DAY(data) ASC";
$stmt = $pdo->query($sql);
$datasExistentes = $stmt->fetchAll(PDO::FETCH_COLUMN);




?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Chamada Escolar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5 border p-3 w-50">
    <div style="text-align: center;" class="bg-success border text-white">
        <h4>Registro de Chamada</h4>
    </div>
    
    <hr>
    <form action="chamada.php" method="get">
    <div class="mb-3">
    <label for="data" class="form-label">Data:</label>
    <select class="form-select w-25" id="data" name="data" required onchange="this.form.submit();">
        <option value="">Selecione uma data</option>
        <?php
        // Exibe as datas já existentes como opções
        foreach ($datasExistentes as $dataExistente) {
            // Mantém a seleção correta da data no formato d/m/Y
            $selected = (isset($_GET['data']) && $_GET['data'] === $dataExistente) ? 'selected' : '';
            echo "<option value='" . htmlspecialchars($dataExistente) . "' $selected>" . htmlspecialchars($dataExistente) . "</option>";
        }
        ?>
    </select>
</div>




        <div class="mb-3">
            <label for="bimestre" class="form-label">Bimestre:</label>
            <select class="form-select w-25" id="bimestre" name="bimestre_id" required>
                <option value="">Selecione o bimestre</option>
                <?php
                $bimestreSelecionado = $_GET['bimestre_id'] ?? '';
                $bimestres = [
                    1 => '1º Bimestre',
                    2 => '2º Bimestre',
                    3 => '3º Bimestre',
                    4 => '4º Bimestre'
                ];

                foreach ($bimestres as $key => $label) {
                    $selected = ($bimestreSelecionado == $key) ? 'selected' : '';
                    echo "<option value='$key' $selected>$label</option>";
                }
                ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="turma" class="form-label">Turma:</label>
            <select class="form-select w-25" id="turma" name="turma_id" required onchange="this.form.submit()">
                <option value="">Selecione uma turma</option>
                <?php
                $turma_id = $_GET['turma_id'] ?? null;

                // Consulta apenas as turmas vinculadas ao professor logado
                $stmt = $pdo->prepare("
                    SELECT DISTINCT turma.id, turma.nome 
                    FROM turma
                    INNER JOIN vinculos ON turma.id = vinculos.turma_id
                    WHERE vinculos.usuario_id = :usuario_id
                    ORDER BY turma.nome
                ");
                $stmt->execute([':usuario_id' => $professor_id]);
                $turmas = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach ($turmas as $turma) {
                    $selected = ($turma['id'] == $turma_id) ? 'selected' : '';
                    echo '<option value="' . $turma['id'] . '" ' . $selected . '>' . htmlspecialchars($turma['nome']) . '</option>';
                }
                ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="disciplina" class="form-label fw-bold" style="text-transform: uppercase;">Disciplina:</label>
            <select class="form-select" id="disciplina" name="disciplina_id" onchange="autoSubmitFilters();">
                <option value="">Selecione uma disciplina</option>
                <?php foreach ($disciplinas as $disciplina) { ?>
                    <option value="<?php echo htmlspecialchars($disciplina['id_disciplina']); ?>" 
                        <?php echo (isset($selectedDisciplina) && $selectedDisciplina == $disciplina['id_disciplina']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($disciplina['nome']); ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <!-- Aqui, passamos o ID da aula como um campo oculto -->
      

    </form>

    <form action="salvar_chamada.php" method="post">
       
     

        <div class="mb-3">
    <label for="aluno" class="form-label">Selecione um Aluno</label>
    <select name="aluno_id" id="aluno" class="form-select" required>
        <option value="">Selecione um aluno</option>
        <?php
        if ($turma_id) {
            $stmt = $pdo->prepare("SELECT alunos.id, alunos.nome FROM alunos
                                    INNER JOIN vinculos ON alunos.id = vinculos.aluno_id
                                    WHERE vinculos.turma_id = :turma_id
                                    AND vinculos.usuario_id = :usuario_id
                                    ORDER BY alunos.nome");
            $stmt->execute([':turma_id' => $turma_id, ':usuario_id' => $professor_id]);
            $alunos = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($alunos) {
                foreach ($alunos as $aluno) {
                    echo '<option value="' . htmlspecialchars($aluno['id']) . '">' . htmlspecialchars($aluno['nome']) . '</option>';
                }
            } else {
                echo '<option value="">Nenhum aluno encontrado para esta turma.</option>';
            }
        } else {
            echo '<option value="">Selecione uma turma para exibir os alunos.</option>';
        }
        ?>
    </select>
</div>

<div class="mb-3">
    <label for="status" class="form-label">Status de Presença</label>
    <select name="status" id="status" class="form-select" required>
        <option value="">Selecione o status</option>
        <option value="Presente">Presente</option>
        <option value="Ausente">Ausente</option>
    </select>
</div>


        <?php if ($turma_id): ?>
            <button type="submit" class="btn btn-primary me-2">Salvar Chamada</button>
        <?php endif; ?>
            
        <a href="painel_professor.php" class="btn btn-secondary">Voltar</a>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
