<?php
session_start();
include 'config.php';

// Definição padrão do nome do usuário
$usuario_nome = "Usuário não logado";
$usuario_username = "Nome de usuário não encontrado";  
$usuario_id = $_SESSION['usuario_id'] ?? null;

// Verifica se o usuário está logado
if (!$usuario_id) {
    die("Erro: Usuário não autenticado.");
}

try {
    // Consulta para obter o nome do usuário
    $sql = "SELECT nome FROM usuarios WHERE id = :usuario_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
    $stmt->execute();
    $usuario_username = $stmt->fetchColumn() ?: $usuario_username;
} catch (PDOException $e) {
    die("Erro ao buscar nome de usuário: " . $e->getMessage());
}

// Verifica se o professor está logado e obtém o nome
if (isset($_SESSION['usuario_id'])) {
    $usuario_id = $_SESSION['usuario_id'];

    try {
        // Consulta para buscar o nome do professor
        $sql_usuario = "SELECT usuario_id FROM vinculos WHERE id = :usuario_id";
        $stmt = $pdo->prepare($sql_usuario);
        $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
        $stmt->execute();
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario) {
            $usuario_nome = $usuario['nome'];
        } else {
            $usuario_nome = "Usuário não encontrado no banco de dados.";
        }
    } catch (PDOException $e) {
        die("Erro ao buscar nome de professor: " . $e->getMessage());
    }
}

// Consultar as turmas do usuário logado
$sqlTurma = "
    SELECT DISTINCT t.nome 
    FROM vinculos v
    INNER JOIN turma t ON v.turma_id = t.id
    WHERE v.usuario_id = :usuario_id
    ORDER BY t.nome
";
$stmtTurma = $pdo->prepare($sqlTurma);
$stmtTurma->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
$stmtTurma->execute();
$turmas = $stmtTurma->fetchAll(PDO::FETCH_ASSOC);

// Consultar as disciplinas do usuário logado
$sqlDisciplina = "
    SELECT DISTINCT d.nome 
    FROM vinculos v
    INNER JOIN disciplinas d ON v.disciplina_id = d.id_disciplina
    WHERE v.usuario_id = :usuario_id
    ORDER BY d.nome
";
$stmtDisciplina = $pdo->prepare($sqlDisciplina);
$stmtDisciplina->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
$stmtDisciplina->execute();
$disciplinas = $stmtDisciplina->fetchAll(PDO::FETCH_ASSOC);

$sqlBimestre = "SELECT DISTINCT nome FROM bimestres ORDER BY nome";
$stmtBimestre = $pdo->prepare($sqlBimestre);
$stmtBimestre->execute();
$bimestres = $stmtBimestre->fetchAll(PDO::FETCH_ASSOC);

// Verificar se a turma, disciplina e bimestre foram selecionados
$mostrarTabela = false;

if (!empty($_GET['turma']) && !empty($_GET['disciplina']) && !empty($_GET['bimestre'])) {
    $mostrarTabela = true;

    // Consultar a tabela de alunos com INNER JOIN entre alunos, vinculos, turma e disciplina
    $sqlAlunos = "
        SELECT a.*, t.nome AS turma_nome, d.nome AS disciplina_nome, b.nome AS bimestre_nome
        FROM alunos a
        INNER JOIN vinculos v ON a.id = v.aluno_id
        INNER JOIN turma t ON v.turma_id = t.id
        INNER JOIN disciplinas d ON v.disciplina_id = d.id_disciplina
        INNER JOIN bimestres b ON v.bimestre_id = b.id
        WHERE t.nome = :turma AND d.nome = :disciplina AND b.nome = :bimestre
        ORDER BY a.nome
    ";
    $stmtAlunos = $pdo->prepare($sqlAlunos);
    $stmtAlunos->bindParam(':turma', $_GET['turma'], PDO::PARAM_STR);
    $stmtAlunos->bindParam(':disciplina', $_GET['disciplina'], PDO::PARAM_STR);
    $stmtAlunos->bindParam(':bimestre', $_GET['bimestre'], PDO::PARAM_STR);
    $stmtAlunos->execute();
    
    // Verificar se há resultados
    if ($stmtAlunos->rowCount() > 0) {
        $alunos = $stmtAlunos->fetchAll(PDO::FETCH_ASSOC);

        // Consultar as notas salvas para os alunos
        $sqlNotas = "
            SELECT aluno_id, av1, av2, av3, reav1, reav2, reav3
            FROM notas
            WHERE turma_id = (SELECT id FROM turma WHERE nome = :turma LIMIT 1)
            AND disciplina_id = (SELECT id_disciplina FROM disciplinas WHERE nome = :disciplina LIMIT 1)
            AND bimestre_id = (SELECT id FROM bimestres WHERE nome = :bimestre LIMIT 1)
        ";
        $stmtNotas = $pdo->prepare($sqlNotas);
        $stmtNotas->bindParam(':turma', $_GET['turma'], PDO::PARAM_STR);
        $stmtNotas->bindParam(':disciplina', $_GET['disciplina'], PDO::PARAM_STR);
        $stmtNotas->bindParam(':bimestre', $_GET['bimestre'], PDO::PARAM_STR);
        $stmtNotas->execute();
        $notasSalvas = $stmtNotas->fetchAll(PDO::FETCH_ASSOC);

        // Organizar as notas por aluno_id para facilitar o acesso
        $notasPorAluno = [];
        foreach ($notasSalvas as $nota) {
            $notasPorAluno[$nota['aluno_id']] = $nota;
        }
    } else {
        $alunos = [];
        $notasPorAluno = [];
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lançamento de Notas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .header { background-color: #d0e68c; font-weight: bold; }
        .total-col { background-color: #d0e68c; }
        .checkbox-col { width: 40px; }
        @media print {
            .no-print { display: none !important; }
        }
    </style>
</head>
<body>
<div class="container mt-3 border border-4">
    <!-- Exibição do nome do usuário -->
    <div class="d-flex justify-content-between align-items-center no-print">
        <h4>Registro/Notas</h4>
    </div>
    <div class="mb-3 no-print">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <p class="fw-bold">Bem-vindo, <?= htmlspecialchars($usuario_username); ?>!</p>
            <a href="painel_professor.php" class="btn btn-secondary">Voltar</a>
        </div>
    </div>
    <hr class="no-print">
    <!-- Filtros -->
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="filtroTurma" class="form-label fw-bold">Turma:</label>
            <select id="filtroTurma" class="form-control" onchange="aplicarFiltros()" required>
                <option value="">Selecione uma Turma (Campo Obrigatório)</option>
                <?php foreach ($turmas as $turma): ?>
                    <option value="<?= $turma['nome']; ?>" <?= (!empty($_GET['turma']) && $_GET['turma'] == $turma['nome']) ? 'selected' : ''; ?>>
                        <?= $turma['nome']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-4">
            <label for="filtroDisciplina" class="form-label fw-bold">Disciplina:</label>
            <select id="filtroDisciplina" class="form-control" onchange="aplicarFiltros()" required>
                <option value="">Selecione uma Disciplina</option>
                <?php foreach ($disciplinas as $disciplina): ?>
                    <option value="<?= $disciplina['nome']; ?>" <?= (!empty($_GET['disciplina']) && $_GET['disciplina'] == $disciplina['nome']) ? 'selected' : ''; ?>>
                        <?= $disciplina['nome']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-4">
            <label for="filtroBimestre" class="form-label fw-bold">Bimestre:</label>
            <select id="filtroBimestre" class="form-control" onchange="aplicarFiltros()" required>
                <option value="">Selecione um Bimestre</option>
                <?php foreach ($bimestres as $bimestre): ?>
                    <option value="<?= $bimestre['nome']; ?>" <?= (!empty($_GET['bimestre']) && $_GET['bimestre'] == $bimestre['nome']) ? 'selected' : ''; ?>>
                        <?= $bimestre['nome']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <!-- Exibir Tabela se Turma e Disciplina forem selecionados -->
    <button onclick="window.print()" class="btn btn-success no-print mb-3">Imprimir</button>
    <?php if ($mostrarTabela): ?>
        <form id="formNotas" method="POST" action="salvar_notas.php">
            <table class="table table-bordered table-striped table-hover">
                <thead class="header text-center table-infor">
                    <tr>
                        <th>ALUNO</th>
                        <th class="total-col">AV1</th>
                        <th class="total-col">AV2</th>
                        <th class="total-col">AV3</th>
                        <th class="total-col">REAV1</th>
                        <th class="total-col">REAV2</th>
                        <th class="total-col">REAV3</th>
                        <th class="total-col">TOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!empty($alunos)) {
                        foreach ($alunos as $row) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['nome']) . "</td>";
                            
                            // Recuperar as notas salvas para o aluno atual
                            $notasAluno = $notasPorAluno[$row['id']] ?? [
                                'av1' => 0,
                                'av2' => 0,
                                'av3' => 0,
                                'reav1' => 0,
                                'reav2' => 0,
                                'reav3' => 0,
                            ];

                            echo "<td><input type='number' class='form-control text-center av1' name='av1[" . $row['id'] . "]' value='" . htmlspecialchars($notasAluno['av1']) . "' step='0.1' min='0' max='8' oninput='validarNota(this, 8)'></td>";
                            echo "<td><input type='number' class='form-control text-center av2' name='av2[" . $row['id'] . "]' value='" . htmlspecialchars($notasAluno['av2']) . "' step='0.1' min='0' max='8' oninput='validarNota(this, 8)'></td>";
                            echo "<td><input type='number' class='form-control text-center av3' name='av3[" . $row['id'] . "]' value='" . htmlspecialchars($notasAluno['av3']) . "' step='0.1' min='0' max='9' oninput='validarNota(this, 9)'></td>";
                            echo "<td><input type='number' class='form-control text-center reav1' name='reav1[" . $row['id'] . "]' value='" . htmlspecialchars($notasAluno['reav1']) . "' step='0.1' min='0' max='8' oninput='validarNota(this, 8)'></td>";
                            echo "<td><input type='number' class='form-control text-center reav2' name='reav2[" . $row['id'] . "]' value='" . htmlspecialchars($notasAluno['reav2']) . "' step='0.1' min='0' max='8' oninput='validarNota(this, 8)'></td>";
                            echo "<td><input type='number' class='form-control text-center reav3' name='reav3[" . $row['id'] . "]' value='" . htmlspecialchars($notasAluno['reav3']) . "' step='0.1' min='0' max='9' oninput='validarNota(this, 9)'></td>";
                            echo "<td class='text-center fw-bold total'>0.0</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8'>Nenhum aluno encontrado</td></tr>";
                    }
                    ?>
                </tbody>
            </table>

            <!-- Campos escondidos para enviar os filtros -->
            <input type="hidden" name="turma" value="<?= htmlspecialchars($_GET['turma']) ?>">
            <input type="hidden" name="disciplina" value="<?= htmlspecialchars($_GET['disciplina']) ?>">
            <input type="hidden" name="bimestre" value="<?= htmlspecialchars($_GET['bimestre']) ?>">

            <div class="d-flex justify-content-end mt-2 mb-2 no-print">
                <a href="painel_professor.php" class="btn btn-secondary me-2"><i class="bi bi-arrow-left"></i> Voltar</a>
                <button type="submit" class="btn btn-primary ms-2">Salvar Notas</button>
            </div>
        </form>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Função para calcular o total de AV1, AV2, AV3, REAV1, REAV2 e REAV3
    function calcularTotal() {
        // Obtém todas as linhas da tabela
        var linhas = document.querySelectorAll('table tbody tr');
        
        linhas.forEach(function(linha) {
            // Obtém os valores de AV1, AV2, AV3, REAV1, REAV2 e REAV3
            var av1 = parseFloat(linha.querySelector('.av1').value) || 0;
            var av2 = parseFloat(linha.querySelector('.av2').value) || 0;
            var av3 = parseFloat(linha.querySelector('.av3').value) || 0;
            var reav1 = parseFloat(linha.querySelector('.reav1').value) || 0;
            var reav2 = parseFloat(linha.querySelector('.reav2').value) || 0;
            var reav3 = parseFloat(linha.querySelector('.reav3').value) || 0;

            // Aplica a lógica: se AV1 > REAV1, mantém AV1; caso contrário, usa REAV1
            var notaFinalAV1 = (av1 > reav1) ? av1 : reav1;

            // Aplica a lógica: se AV2 > REAV2, mantém AV2; caso contrário, usa REAV2
            var notaFinalAV2 = (av2 > reav2) ? av2 : reav2;

            // Aplica a lógica: se AV3 > REAV3, mantém AV3; caso contrário, usa REAV3
            var notaFinalAV3 = (av3 > reav3) ? av3 : reav3;

            // Calcula o total
            var total = notaFinalAV1 + notaFinalAV2 + notaFinalAV3;
            
            // Exibe o total na célula correspondente
            linha.querySelector('.total').textContent = total.toFixed(1);
        });
    }

    // Adiciona os eventos de input para os campos AV1, AV2, AV3, REAV1, REAV2 e REAV3
    document.querySelectorAll('.av1, .av2, .av3, .reav1, .reav2, .reav3').forEach(function(input) {
        input.addEventListener('input', calcularTotal);
    });

    // Função para aplicar os filtros na URL
    function aplicarFiltros() {
        var turma = document.getElementById('filtroTurma').value;
        var disciplina = document.getElementById('filtroDisciplina').value;
        var bimestre = document.getElementById('filtroBimestre').value;

        var url = new URL(window.location.href);
        var params = url.searchParams;

        if (turma) params.set('turma', turma);
        if (disciplina) params.set('disciplina', disciplina);
        if (bimestre) params.set('bimestre', bimestre);

        // Redireciona com os parâmetros de filtro
        window.location.search = params.toString();
    }

    // Inicializar o cálculo de totais ao carregar a página
    window.onload = function() {
        calcularTotal();
    };
</script>
<script>
function validarNota(input, maxValor) {
    // Converte o valor para número
    let valor = parseFloat(input.value);

    // Garante que o valor esteja dentro do intervalo permitido
    if (isNaN(valor)) {
        input.value = 0; // Se não for um número, define como 0
    } else if (valor < 0) {
        input.value = 0; // Se for menor que 0, define como 0
    } else if (valor > maxValor) {
        input.value = maxValor; // Se for maior que o valor máximo, define como o valor máximo
    } else {
        input.value = valor; // Mantém o valor dentro do intervalo
    }
}
</script>
</body>
</html>