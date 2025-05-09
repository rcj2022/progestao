<?php
include 'config.php';
session_start();

// Função para definir o período de cada bimestre
function getBimestrePeriodo($bimestre_id) {
    $ano = date('Y');
    switch ($bimestre_id) {
        case 1: return [$ano . '-02-10', $ano . '-04-23'];
        case 2: return [$ano . '-04-24', $ano . '-06-30'];
        case 3: return [$ano . '-08-01', $ano . '-10-06'];
        case 4: return [$ano . '-10-07', $ano . '-12-13'];
        default: return [date('Y-m-d'), date('Y-m-d')];
    }
}

// Meses correspondentes para cada bimestre
$bimestreMeses = [
    1 => [2 => "Fevereiro", 3 => "Março", 4 => "Abril"],
    2 => [4 => "Abril", 5 => "Maio", 6 => "Junho"],
    3 => [8 => "Agosto", 9 => "Setembro", 10 => "Outubro"],
    4 => [10 => "Outubro", 11 => "Novembro", 12 => "Dezembro"]
];

$clearFilters = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['status']) && !empty($_POST['status'])) {
    $bimestre_id = $_POST['bimestre_id'] ?? null;
    $turma_id = $_POST['turma_id'] ?? null;
    $disciplina_id = $_POST['disciplina_id'] ?? null; // ID da disciplina
    $status = $_POST['status'];

    try {
        $pdo->beginTransaction();

        $stmt = $pdo->prepare("INSERT INTO chamada (aluno_id, data, status, bimestre_id, turma_id, aula_id, disciplina_id) 
            VALUES (:aluno_id, :data, :status, :bimestre_id, :turma_id, :aula_id, :disciplina_id)
            ON DUPLICATE KEY UPDATE status = :status");

if (is_array($status)) {
    foreach ($status as $dia => $alunos) {
        if (is_array($alunos)) {
            foreach ($alunos as $aluno_id => $presenca) {
                $aula_id = $_POST['aula_id'][$dia] ?? null;

                // Valida e converte o valor para inteiro
                $valorStatus = (int)$presenca;

                // Garante que o valor esteja entre 0 e 2
                if ($valorStatus < 0 || $valorStatus > 2) {
                    $valorStatus = 0; // Define como 0 se o valor for inválido
                }

                if (!empty($aluno_id) && !empty($dia) && !empty($disciplina_id)) {
                    $stmt->execute([
                        ':aluno_id'      => $aluno_id,
                        ':data'          => $dia,
                        ':status'        => $valorStatus, // Valor numérico (0, 1 ou 2)
                        ':bimestre_id'   => $bimestre_id,
                        ':turma_id'      => $turma_id,
                        ':aula_id'       => $aula_id,
                        ':disciplina_id' => $disciplina_id
                    ]);
                }
            }
        }
    }
}
        $pdo->commit();
        $message = "Frequência em massa salva com sucesso!";
        $clearFilters = true; 
    } catch (Exception $e) {
        $pdo->rollBack();
        $message = "Erro ao salvar a frequência: " . $e->getMessage();
    }
}

// Obter ID do professor logado
$professor_id = $_SESSION['usuario_id'] ?? null;

if ($professor_id) {
    $sql = "
        SELECT DISTINCT t.id, t.nome 
        FROM turma t
        INNER JOIN vinculos v ON v.turma_id = t.id
        WHERE v.usuario_id = :usuario_id
        ORDER BY t.nome
    ";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':usuario_id', $professor_id, PDO::PARAM_INT);
    $stmt->execute();
    $turmas = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $turmas = [];
    echo "Professor não está logado.";
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
if (isset($_POST['turma_id'])) {
    $turma_id = $_POST['turma_id'];

    foreach ($disciplinas as $disciplina) {
        $disciplina_id = $disciplina['id_disciplina'];

        $sqlAlunos = "
            SELECT a.id, a.nome 
            FROM alunos a
            INNER JOIN vinculos v ON v.aluno_id = a.id
            WHERE v.disciplina_id = :disciplina_id
            AND v.usuario_id = :usuario_id
            AND v.turma_id = :turma_id
            ORDER BY a.nome
        ";

        $stmtAlunos = $pdo->prepare($sqlAlunos);
        $stmtAlunos->bindParam(':disciplina_id', $disciplina_id, PDO::PARAM_INT);
        $stmtAlunos->bindParam(':usuario_id', $professor_id, PDO::PARAM_INT);
        $stmtAlunos->bindParam(':turma_id', $turma_id, PDO::PARAM_INT);
        $stmtAlunos->execute();
        $alunos = $stmtAlunos->fetchAll(PDO::FETCH_ASSOC);

        $disciplinasComAlunos[] = [
            'disciplina' => $disciplina,
            'alunos' => $alunos
        ];
    }
}

// Bimestres disponíveis
$bimestres = [
    1 => '1º Bimestre',
    2 => '2º Bimestre',
    3 => '3º Bimestre',
    4 => '4º Bimestre'
];

// Manter os valores selecionados
$selectedBimestre = $clearFilters ? '' : ($_POST['bimestre_id'] ?? '');
$selectedTurma = $clearFilters ? '' : ($_POST['turma_id'] ?? '');
$selectedMes = $clearFilters ? '' : ($_POST['mes'] ?? '');
$selectedDisciplina = $clearFilters ? '' : ($_POST['disciplina_id'] ?? '');
?>

<!---Aqui começa o HTML--->

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Frequência em Massa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .data-header {
            text-align: center;
            line-height: 1.2;
        }
        .data-header .dia {
            font-weight: bold;
        }
        .data-header .mes {
            border-top: 1px solid #000;
            display: block;
        }
        .aluno-column {
            min-width: 250px;
        }
        .is-invalid {
            border-color: red !important; /* Destaca o campo em vermelho */
        }
        @media (max-width: 768px) {
            .table-responsive {
                overflow-x: auto;
            }
            .data-header .mes {
                display: none; /* Oculta o mês em telas pequenas */
            }
            .aluno-column {
                min-width: 120px; /* Reduzido ainda mais para telas pequenas */
            }
            .form-select {
                font-size: 14px; /* Reduz o tamanho da fonte dos selects */
            }
        }
    </style>
    <script>
        // Função para submeter o formulário automaticamente quando algum filtro é alterado
        function autoSubmitFilters() {
            document.getElementById('filtroForm').submit();
        }

        // Função para carregar as disciplinas ao selecionar uma turma
        document.getElementById('turma').addEventListener('change', function() {
            const turmaId = this.value;
            const disciplinaSelect = document.getElementById('disciplina');

            if (turmaId) {
                // Limpa as opções atuais do filtro de disciplina
                disciplinaSelect.innerHTML = '<option value="">Carregando disciplinas...</option>';

                // Envia uma requisição AJAX para buscar as disciplinas
                fetch(`buscar_disciplinas.php?turma_id=${turmaId}`)
                    .then(response => response.json())
                    .then(data => {
                        // Atualiza o filtro de disciplina com as opções retornadas
                        disciplinaSelect.innerHTML = '<option value="">Selecione uma disciplina</option>';
                        data.forEach(disciplina => {
                            const option = document.createElement('option');
                            option.value = disciplina.id_disciplina;
                            option.textContent = disciplina.nome;
                            disciplinaSelect.appendChild(option);
                        });
                    })
                    .catch(error => {
                        console.error('Erro ao buscar disciplinas:', error);
                        disciplinaSelect.innerHTML = '<option value="">Erro ao carregar disciplinas</option>';
                    });
            } else {
                // Se nenhuma turma for selecionada, limpa o filtro de disciplina
                disciplinaSelect.innerHTML = '<option value="">Selecione uma disciplina</option>';
            }
        });
    </script>
</head>
<body>
<div class="container mt-2">
    <h2 class="text-start">Frequência Mensal</h2>
    <div class="text-end">
        <a href="painel_professor.php" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Voltar</a>
    </div>
    <hr>

    <?php if (!empty($message)) { ?>
        <div class="alert alert-info"><?php echo $message; ?></div>
    <?php } ?>
    <!-- Formulário de Filtros -->
    <form method="post" id="filtroForm">
        <div class="mb-3">
            <label for="bimestre" class="form-label fw-bold" style="text-transform: uppercase;">Bimestre:</label>
            <select class="form-select" id="bimestre" name="bimestre_id" required onchange="autoSubmitFilters();">
                <option value="">Selecione o bimestre</option>
                <?php foreach ($bimestres as $id => $nome) { ?>
                    <option value="<?php echo $id; ?>" <?php echo ($selectedBimestre == $id) ? 'selected' : ''; ?>>
                        <?php echo $nome; ?>
                    </option>
                <?php } ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="turma" class="form-label fw-bold" style="text-transform: uppercase;">Turma:</label>
            <select class="form-select" id="turma" name="turma_id" required onchange="autoSubmitFilters();">
                <option value="">Selecione uma turma</option>
                <?php foreach ($turmas as $turma) { ?>
                    <option value="<?php echo $turma['id']; ?>" <?php echo ($selectedTurma == $turma['id']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($turma['nome']); ?>
                    </option>
                <?php } ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="mes" class="form-label fw-bold" style="text-transform: uppercase;">Mês:</label>
            <select class="form-select" id="mes" name="mes" onchange="autoSubmitFilters();">
                <?php 
                if (!empty($selectedBimestre)) {
                    foreach ($bimestreMeses[$selectedBimestre] as $num => $mesNome) {
                        $selected = ($selectedMes == $num) ? 'selected' : '';
                        echo "<option value=\"$num\" $selected>$mesNome</option>";
                    }
                } else {
                    echo '<option value="">Selecione o bimestre para ver os meses</option>';
                }
                ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="disciplina" class="form-label fw-bold" style="text-transform: uppercase;">Disciplina:</label>
            <select class="form-select" id="disciplina" name="disciplina_id" onchange="autoSubmitFilters();">
                <?php foreach ($disciplinas as $disciplina) { ?>
                    <option value="<?php echo htmlspecialchars($disciplina['id_disciplina']); ?>" 
                        <?php echo (isset($selectedDisciplina) && $selectedDisciplina == $disciplina['id_disciplina']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($disciplina['nome']); ?>
                    </option>
                <?php } ?>
            </select>
        </div>
    </form>

    <?php
    // A tabela será exibida somente se os filtros Bimestre, Turma e Mês estiverem preenchidos
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && !$clearFilters && !empty($_POST['turma_id']) && !empty($_POST['bimestre_id']) && !empty($_POST['mes'])) {
        $turma_id = $_POST['turma_id'];
        $bimestre_id = $_POST['bimestre_id'];
        [$inicio, $fim] = getBimestrePeriodo($bimestre_id);
        $data_inicio = $inicio;
        $data_fim = $fim;
        $mes = $_POST['mes'];
        
        $query = "SELECT id, dia FROM aulas WHERE turma_id = :turma_id AND dia BETWEEN :inicio AND :fim";
        $params = [
            ':turma_id' => $turma_id,
            ':inicio'   => $data_inicio,
            ':fim'      => $data_fim
        ];
        // Filtra pelo mês
        $query .= " AND MONTH(dia) = :mes";
        $params[':mes'] = $mes;
        
        $query .= " ORDER BY dia";
        
        $stmtAulas = $pdo->prepare($query);
        $stmtAulas->execute($params);
        $aulas = $stmtAulas->fetchAll(PDO::FETCH_ASSOC);
        
        $stmtAlunos = $pdo->prepare("SELECT DISTINCT alunos.id, alunos.nome 
        FROM alunos 
        INNER JOIN vinculos ON alunos.id = vinculos.aluno_id 
        WHERE vinculos.turma_id = :turma_id 
        AND vinculos.usuario_id = :usuario_id 
        ORDER BY alunos.nome");
        $stmtAlunos->execute([
            ':turma_id' => $turma_id,
            ':usuario_id' => $professor_id
        ]);
        $alunos = $stmtAlunos->fetchAll(PDO::FETCH_ASSOC);

        // Recuperar os valores de frequência já gravados
        $frequenciaSalva = [];
        $sqlFrequencia = "
            SELECT aluno_id, data, status 
            FROM chamada 
            WHERE turma_id = :turma_id 
            AND bimestre_id = :bimestre_id 
            AND MONTH(data) = :mes
        ";
        $stmtFrequencia = $pdo->prepare($sqlFrequencia);
        $stmtFrequencia->execute([
            ':turma_id' => $turma_id,
            ':bimestre_id' => $bimestre_id,
            ':mes' => $mes
        ]);
        $frequencias = $stmtFrequencia->fetchAll(PDO::FETCH_ASSOC);

        // Organizar os valores em um array multidimensional
        foreach ($frequencias as $frequencia) {
            $frequenciaSalva[$frequencia['data']][$frequencia['aluno_id']] = $frequencia['status'];
        }
    ?>
    
    <form method="post">
        <input type="hidden" name="bimestre_id" value="<?php echo $bimestre_id; ?>">
        <input type="hidden" name="turma_id" value="<?php echo $turma_id; ?>">
        <input type="hidden" name="mes" value="<?php echo $mes; ?>">
        <input type="hidden" name="disciplina_id" value="<?php echo $disciplina_id; ?>">

        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th class="aluno-column">Aluno</th>
                        <?php foreach ($aulas as $aula) { 
                            $dia = date('d', strtotime($aula['dia']));
                            $mesAula = date('n', strtotime($aula['dia']));
                        ?>
                            <th>
                                <div class="data-header">
                                    <div class="dia"><?php echo $dia; ?></div>
                                    <div class="mes"><?php echo $mesAula; ?></div>
                                </div>
                            </th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($alunos as $aluno) { ?>
                        <tr>
                            <td class="aluno-column"><?php echo htmlspecialchars($aluno['nome']); ?></td>
                            <?php foreach ($aulas as $aula) { 
                                // Verifica se há um valor salvo para essa combinação de aluno e aula
                                $valorSalvo = $frequenciaSalva[$aula['dia']][$aluno['id']] ?? '0';
                            ?>
                                <td>
                                    <input 
                                        type="text" 
                                        name="status[<?php echo $aula['dia']; ?>][<?php echo $aluno['id']; ?>]" 
                                        required 
                                        class="form-control text-center" 
                                        value="<?php echo htmlspecialchars($valorSalvo); ?>" 
                                        oninput="validarValorTexto(this)"
                                    >
                                    <input type="hidden" name="aula_id[<?php echo $aula['dia']; ?>]" value="<?php echo $aula['id']; ?>">
                                </td>
                            <?php } ?>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <div class="container mt-3 mb-3 border">
            <button type="submit" class="btn btn-success ms-auto d-block mb-2 mt-2">Salvar Frequência</button>
        </div>
    </form>
    <?php } ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
function validarValorTexto(input) {
    // Remove qualquer caractere que não seja número
    input.value = input.value.replace(/[^0-9]/g, '');

    // Converte o valor para número
    let valor = parseInt(input.value);

    // Garante que o valor seja 0, 1 ou 2
    if (isNaN(valor)) {
        input.value = 0; // Se não for um número, define como 0
        input.classList.add('is-invalid'); // Adiciona classe de erro
    } else if (valor < 0 || valor > 2) {
        input.value = 0; // Se for menor que 0 ou maior que 2, define como 0
        input.classList.add('is-invalid'); // Adiciona classe de erro
    } else {
        input.value = valor; // Mantém o valor entre 0 e 2
        input.classList.remove('is-invalid'); // Remove classe de erro
    }
}
</script>
</body>
</html>