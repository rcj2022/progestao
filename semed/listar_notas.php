<?php
session_start();
include 'config.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    die("Usuário não logado.");
}

$usuarioId = $_SESSION['usuario_id'];

// Consulta para buscar turmas, disciplinas e bimestres vinculados ao usuário logado
$sqlVinculos = "
    SELECT t.id AS turma_id, t.nome AS turma_nome,
           d.id_disciplina AS disciplina_id, d.nome AS disciplina_nome,
           b.id AS bimestre_id, b.nome AS bimestre_nome
    FROM vinculos v
    INNER JOIN turma t ON v.turma_id = t.id
    INNER JOIN disciplinas d ON v.disciplina_id = d.id_disciplina
    INNER JOIN bimestres b ON v.bimestre_id = b.id
    WHERE v.usuario_id = :usuario_id
";

$stmtVinculos = $pdo->prepare($sqlVinculos);
$stmtVinculos->bindParam(':usuario_id', $usuarioId, PDO::PARAM_INT);
$stmtVinculos->execute();
$vinculos = $stmtVinculos->fetchAll(PDO::FETCH_ASSOC);

// Extrai turmas, disciplinas e bimestres únicos
$turmas = [];
$disciplinas = [];
$bimestres = [];

foreach ($vinculos as $vinculo) {
    if (!in_array(['id' => $vinculo['turma_id'], 'nome' => $vinculo['turma_nome']], $turmas)) {
        $turmas[] = ['id' => $vinculo['turma_id'], 'nome' => $vinculo['turma_nome']];
    }
    if (!in_array(['id' => $vinculo['disciplina_id'], 'nome' => $vinculo['disciplina_nome']], $disciplinas)) {
        $disciplinas[] = ['id' => $vinculo['disciplina_id'], 'nome' => $vinculo['disciplina_nome']];
    }
    if (!in_array(['id' => $vinculo['bimestre_id'], 'nome' => $vinculo['bimestre_nome']], $bimestres)) {
        $bimestres[] = ['id' => $vinculo['bimestre_id'], 'nome' => $vinculo['bimestre_nome']];
    }
}

// Inicializa variáveis de filtro
$filtroTurma = $_GET['turma'] ?? '';
$filtroDisciplina = $_GET['disciplina'] ?? '';
$filtroBimestre = $_GET['bimestre'] ?? '';

// Verifica se pelo menos um filtro foi selecionado
$tabelaVisivel = !empty($filtroTurma) || !empty($filtroDisciplina) || !empty($filtroBimestre);

// Consulta para buscar as notas somente se houver filtros
$notas = [];
if ($tabelaVisivel) {
    $sql = "
        SELECT n.id, n.av1, n.av2, n.av3,reav1,reav2,reav3, n.total,
               a.nome AS aluno_nome,
               t.nome AS turma_nome,
               d.nome AS disciplina_nome,
               b.nome AS bimestre_nome
        FROM notas n
        INNER JOIN alunos a ON n.aluno_id = a.id
        INNER JOIN turma t ON n.turma_id = t.id
        INNER JOIN disciplinas d ON n.disciplina_id = d.id_disciplina
        INNER JOIN bimestres b ON n.bimestre_id = b.id
        WHERE (:turma = '' OR t.id = :turma)
        AND (:disciplina = '' OR d.id_disciplina = :disciplina)
        AND (:bimestre = '' OR b.id = :bimestre)
        AND t.id IN (SELECT turma_id FROM vinculos WHERE usuario_id = :usuario_id)
        AND d.id_disciplina IN (SELECT disciplina_id FROM vinculos WHERE usuario_id = :usuario_id)
        AND b.id IN (SELECT bimestre_id FROM vinculos WHERE usuario_id = :usuario_id)
        ORDER BY a.nome ASC;
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':turma', $filtroTurma, PDO::PARAM_INT);
    $stmt->bindParam(':disciplina', $filtroDisciplina, PDO::PARAM_INT);
    $stmt->bindParam(':bimestre', $filtroBimestre, PDO::PARAM_INT);
    $stmt->bindParam(':usuario_id', $usuarioId, PDO::PARAM_INT);
    $stmt->execute();
    $notas = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar Notas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h4>Lista de Notas</h4>
        <form method="GET" class="row g-3" id="filtroForm">
            <div class="col-md-4">
                <label class="form-label">Turma</label>
                <select name="turma" class="form-select" onchange="document.getElementById('filtroForm').submit();">
                    <option value="">Todas</option>
                    <?php foreach ($turmas as $turma): ?>
                        <option value="<?php echo $turma['id']; ?>" <?php echo ($filtroTurma == $turma['id']) ? 'selected' : ''; ?>>
                            <?php echo $turma['nome']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Disciplina</label>
                <select name="disciplina" class="form-select" onchange="document.getElementById('filtroForm').submit();">
                    <option value="">Todas</option>
                    <?php foreach ($disciplinas as $disciplina): ?>
                        <option value="<?php echo $disciplina['id']; ?>" <?php echo ($filtroDisciplina == $disciplina['id']) ? 'selected' : ''; ?>>
                            <?php echo $disciplina['nome']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Bimestre</label>
                <select name="bimestre" class="form-select" onchange="document.getElementById('filtroForm').submit();">
                    <option value="">Todos</option>
                    <?php foreach ($bimestres as $bimestre): ?>
                        <option value="<?php echo $bimestre['id']; ?>" <?php echo ($filtroBimestre == $bimestre['id']) ? 'selected' : ''; ?>>
                            <?php echo $bimestre['nome']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-12">
                <a href="painel_professor.php" class="btn btn-secondary">Voltar</a>
            </div>
        </form>

        <?php if ($tabelaVisivel && !empty($filtroBimestre)): ?>
            <div class="table-responsive mt-4">
                <table class="table table-bordered">
                    <thead class="table-light text-center">
                        <tr>
                            <th>Nº</th>
                            <th class="text-start">Aluno</th>
                            <th>AV1</th>
                            <th>REAV1</th>
                            <th>AV2</th>
                            <th>REAV2</th>
                            <th>AV3</th>
                            <th>REAV3</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        <?php $contador = 1; ?>
                        <?php foreach ($notas as $nota): ?>
                            <tr>
                                <td><?php echo $contador++; ?></td>
                                <td class="text-start"><?php echo htmlspecialchars($nota['aluno_nome']); ?></td>
                                <td><?php echo htmlspecialchars($nota['av1']); ?></td>
                                <td><?php echo htmlspecialchars($nota['reav1']); ?></td>
                                <td><?php echo htmlspecialchars($nota['av2']); ?></td>
                                <td><?php echo htmlspecialchars($nota['reav2']); ?></td>
                                <td><?php echo htmlspecialchars($nota['av3']); ?></td>
                                <td><?php echo htmlspecialchars($nota['reav3']); ?></td>
                                <td><?php echo htmlspecialchars($nota['total']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
