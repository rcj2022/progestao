<?php
include 'config.php';
session_start();

// Verifica se o usuário está autenticado
$professor_id = $_SESSION['usuario_id'] ?? null;
if (!$professor_id) {
    die('Usuário não autenticado.');
}

// Define a data atual como padrão
$data_atual = date('Y-m-d');
$data_inicio = $_GET['data_inicio'] ?? $data_atual;
$data_fim = $_GET['data_fim'] ?? null;
$turma_id = $_GET['turma_id'] ?? null;

// Consulta para buscar as chamadas registradas com base nos filtros
$sql = "SELECT c.*, a.nome AS aluno_nome, t.nome AS turma_nome
        FROM chamada c
        INNER JOIN alunos a ON c.aluno_id = a.id
        INNER JOIN turma t ON c.turma_id = t.id
        WHERE c.turma_id IN (
            SELECT turma.id FROM turma 
            INNER JOIN vinculos ON turma.id = vinculos.turma_id 
            WHERE vinculos.usuario_id = :usuario_id
        )";

if ($data_inicio) {
    $sql .= " AND c.data >= :data_inicio";
}
if ($data_fim) {
    $sql .= " AND c.data <= :data_fim";
}
if ($turma_id) {
    $sql .= " AND c.turma_id = :turma_id";
}

$sql .= " ORDER BY a.nome ASC;";

$stmt = $pdo->prepare($sql);
$stmt->bindParam(':usuario_id', $professor_id, PDO::PARAM_INT);

if ($data_inicio) {
    $stmt->bindParam(':data_inicio', $data_inicio);
}
if ($data_fim) {
    $stmt->bindParam(':data_fim', $data_fim);
}
if ($turma_id) {
    $stmt->bindParam(':turma_id', $turma_id, PDO::PARAM_INT);
}

$stmt->execute();
$chamadas = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Buscar turmas do professor sem duplicatas
$turmaStmt = $pdo->prepare("SELECT DISTINCT turma.id, turma.nome FROM turma INNER JOIN vinculos ON turma.id = vinculos.turma_id WHERE vinculos.usuario_id = :usuario_id");
$turmaStmt->bindParam(':usuario_id', $professor_id, PDO::PARAM_INT);
$turmaStmt->execute();
$turmas = $turmaStmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listagem de Chamadas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script>
        function autoSubmitFilters() {
            document.getElementById("filtersForm").submit();
        }

        function showTable() {
            var table = document.getElementById("chamadasTable");
            var dataInicio = document.getElementById("data_inicio").value;
            var dataFim = document.getElementById("data_fim").value;
            var turma = document.getElementById("turma_id").value;
            table.style.display = (dataInicio && dataFim && turma) ? "table" : "none";
        }

        window.onload = showTable;
    </script>
</head>
<body>
<div class="container mt-5">
    <h2>Registro/Chamada</h2>
    <div class="mb-3 text-end border">
        <a href="painel_professor.php" class="btn btn-secondary mt-3 mb-3 me-3">Voltar</a>
    </div>

    <!-- Filtro de busca -->
    <form id="filtersForm" action="listar_chamada.php" method="get">
        <div class="mb-3">
            <label for="turma_id" class="form-label">Turma:</label>
            <select class="form-control" id="turma_id" name="turma_id" onchange="autoSubmitFilters(); showTable();">
                <option value="">Selecione a Turma</option>
                <?php
                $turmas_exibidas = [];
                foreach ($turmas as $turma) {
                    if (!in_array($turma['id'], $turmas_exibidas)) {
                        echo '<option value="' . htmlspecialchars($turma['id'], ENT_QUOTES) . '" ' . 
                            (($turma_id == $turma['id']) ? 'selected' : '') . '>' . 
                            htmlspecialchars($turma['nome'], ENT_QUOTES) . 
                            '</option>';
                        $turmas_exibidas[] = $turma['id'];
                    }
                }
                ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="data_inicio" class="form-label">Data Inicial:</label>
            <input type="date" class="form-control" id="data_inicio" name="data_inicio" value="<?php echo htmlspecialchars($data_inicio, ENT_QUOTES); ?>" onchange="autoSubmitFilters(); showTable();">
        </div>
        <div class="mb-3">
            <label for="data_fim" class="form-label">Data Final:</label>
            <input type="date" class="form-control" id="data_fim" name="data_fim" value="<?php echo htmlspecialchars($data_fim ?? '', ENT_QUOTES); ?>" onchange="autoSubmitFilters(); showTable();">
        </div>
    </form>

    <hr>

    <!-- Tabela de chamadas -->
    <table id="chamadasTable" class="table table-bordered mt-3" style="display:none;">
        <thead>
            <tr>
                <th>Nº</th>
                <th>Aluno</th>
                <th>Status</th>
                <th>Ação</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($chamadas)) : ?>
                <tr>
                    <td colspan="5" class="text-center">Nenhuma chamada encontrada.</td>
                </tr>
            <?php else : ?>
                <?php foreach ($chamadas as $index => $chamada) : ?>
                    <tr>
                        <td><?php echo $index + 1; ?></td>
                        <td><?php echo htmlspecialchars($chamada['aluno_nome'] ?? 'Nome não disponível', ENT_QUOTES); ?></td>
                        <td><?php echo htmlspecialchars($chamada['status'] ?? 'Indefinido', ENT_QUOTES); ?></td>
                        <td>
                            <a href="editar_chamada.php?id=<?php echo $chamada['id']; ?>" class="btn btn-warning btn-sm">Editar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>