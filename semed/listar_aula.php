<?php
session_start();
include 'config.php'; // Conexão com o banco de dados

// Inicializa variáveis com valores padrão
$usuario_username = "Nome de usuário não encontrado";  
$usuario_id = $_SESSION['usuario_id'] ?? null; // Obtém o ID do usuário logado da sessão

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

    // Consulta para obter as turmas do professor com o nome da turma
    $sqlTurmas = "SELECT DISTINCT t.id AS turma_id, t.nome AS turma_nome 
                  FROM aulas a 
                  JOIN turma t ON a.turma_id = t.id 
                  WHERE a.usuario_id = :usuario_id";
    $stmtTurmas = $pdo->prepare($sqlTurmas);
    $stmtTurmas->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
    $stmtTurmas->execute();
    $turmas = $stmtTurmas->fetchAll(PDO::FETCH_ASSOC);

    // Consulta para obter períodos com o nome do bimestre
    $sqlPeriodos = "SELECT DISTINCT b.id AS periodo_id, b.nome AS periodo_nome 
                    FROM aulas a 
                    JOIN bimestres b ON a.periodo_id = b.id 
                    WHERE a.usuario_id = :usuario_id";
    $stmtPeriodos = $pdo->prepare($sqlPeriodos);
    $stmtPeriodos->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
    $stmtPeriodos->execute();
    $resultPeriodos = $stmtPeriodos->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erro ao buscar dados: " . $e->getMessage());
}

// Exclusão em massa
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_ids'])) {
    $delete_ids = $_POST['delete_ids'];
    if (!empty($delete_ids)) {
        try {
            $placeholders = implode(',', array_fill(0, count($delete_ids), '?'));
            $sqlDelete = "DELETE FROM aulas WHERE id IN ($placeholders) AND usuario_id = ?";
            $stmt = $pdo->prepare($sqlDelete);
            $params = array_merge($delete_ids, [$usuario_id]);
            $stmt->execute($params);
            echo "<script>alert('Registros excluídos com sucesso!'); window.location.href='listar_aula.php';</script>";
        } catch (PDOException $e) {
            echo "<script>alert('Erro ao excluir registros!');</script>";
        }
    }
}

// Exclusão individual
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    try {
        $sqlDelete = "DELETE FROM aulas WHERE id = :delete_id AND usuario_id = :usuario_id";
        $stmt = $pdo->prepare($sqlDelete);
        $stmt->bindParam(':delete_id', $delete_id, PDO::PARAM_INT);
        $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
        $stmt->execute();
        echo "<script>alert('Registro excluído com sucesso!'); window.location.href='listar_aula.php';</script>";
    } catch (PDOException $e) {
        echo "<script>alert('Erro ao excluir o registro!');</script>";
    }
}

// Filtros
$filtroTurma = $_GET['turma_id'] ?? '';
$filtroPeriodo = $_GET['periodo_id'] ?? '';
$exibirTabela = !empty($filtroTurma) && !empty($filtroPeriodo);

// Buscar aulas com filtros
$sql = "SELECT a.id, a.dia, a.conteudo, a.quantidade, t.nome AS turma_nome, b.nome AS periodo_nome 
        FROM aulas a 
        JOIN turma t ON a.turma_id = t.id 
        JOIN bimestres b ON a.periodo_id = b.id 
        WHERE a.usuario_id = :usuario_id";
$params = [':usuario_id' => $usuario_id];

if (!empty($filtroTurma)) {
    $sql .= " AND a.turma_id = :filtroTurma";
    $params[':filtroTurma'] = $filtroTurma;
}
if (!empty($filtroPeriodo)) {
    $sql .= " AND a.periodo_id = :filtroPeriodo";
    $params[':filtroPeriodo'] = $filtroPeriodo;
}
$sql .= " ORDER BY a.dia ASC";

try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erro ao buscar registros: " . $e->getMessage());
}

// Função para obter o dia da semana
function getDayOfWeek($date) {
    $days = ['Domingo', 'Segunda-feira', 'Terça-feira', 'Quarta-feira', 'Quinta-feira', 'Sexta-feira', 'Sábado'];
    return $days[date('w', strtotime($date))];
}

// Cálculo de totais
$totalDias = count($result);
$totalAulas = array_sum(array_column($result, 'quantidade'));
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aulas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2 class="mb-4">Professor(a): <?php echo htmlspecialchars($usuario_username); ?></h2>
    
    <!-- Filtros -->
    <form method="GET" class="mb-4" id="filtroForm">
        <table class="table">
            <thead>
                <tr>
                    <th>Turma</th>
                    <th>Período</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <select name="turma_id" id="turma" class="form-select" onchange="document.getElementById('filtroForm').submit()">
                            <option value="">Todas</option>
                            <?php foreach ($turmas as $turma): ?>
                                <option value="<?= htmlspecialchars($turma['turma_id']) ?>" <?= $filtroTurma == $turma['turma_id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($turma['turma_nome']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                    <td>
                        <select name="periodo_id" id="periodo" class="form-select" onchange="document.getElementById('filtroForm').submit()">
                            <option value="">Todos</option>
                            <?php foreach ($resultPeriodos as $row): ?>
                                <option value="<?= htmlspecialchars($row['periodo_id']) ?>" <?= $filtroPeriodo == $row['periodo_id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($row['periodo_nome']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                    <td class="text-center">
                        <div class="d-flex justify-content-center">
                            <a href="listar_aula.php" class="btn btn-secondary me-2">Limpar</a>
                            <a href="lanca_aula.php" class="btn btn-success me-2">Adicionar</a>
                            <a href="editar_massa.php?turma=<?php echo urlencode($filtroTurma); ?>&periodo=<?php echo urlencode($filtroPeriodo); ?>" class="btn btn-info me-2">Editar todos</a>
                            <a href="painel_professor.php" class="btn btn-danger me-2">Voltar</a>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </form> 

    <?php if ($exibirTabela): ?>
        <!-- Totais -->
        <div class="mb-4">
            <table class="table table-bordered table-hover">
                <tbody>
                    <tr>
                        <td><strong>Total de dias:</strong><br><span><?= $totalDias ?></span></td>
                        <td><strong>Total de aulas:</strong><br><span><?= $totalAulas ?></span></td>
                    </tr>
                </tbody>
            </table>
        </div>
      
        <!-- Tabela de aulas -->
        <form method="POST">
            <table class="table table-bordered table-hover">
                <thead class="table-light text-center">
                    <tr>
                        <th><input type="checkbox" onclick="toggleSelectAll(this)"></th>
                        <th>Data<p></th>
                        <th>Conteúdo<p></th>
                        <th>Aulas<P>Ministradas</th>
                        <th>Ações<p></th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    <?php foreach ($result as $row): ?>
                        <tr>
                            <td><input type="checkbox" name="delete_ids[]" value="<?= $row['id'] ?>"></td>
                            <td><?= date('d/m/Y', strtotime($row['dia'])) ?><p> (<?= getDayOfWeek($row['dia']) ?>)</td>
                            <td><?= htmlspecialchars($row['conteudo']) ?></td>
                            <td><?= htmlspecialchars($row['quantidade']) ?></td>
                           
                            <td>
                                <a href="editar_aula.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                                <a href="listar_aula.php?delete_id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir este registro?')">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <button type="submit" class="btn btn-danger">Excluir selecionados</button>
        </form>
    <?php endif; ?>
</div>

<script>
    // Função para selecionar/deselecionar todos os checkboxes
    function toggleSelectAll(checkbox) {
        const checkboxes = document.querySelectorAll('input[name="delete_ids[]"]');
        checkboxes.forEach(cb => cb.checked = checkbox.checked);
    }
</script>
</body>
</html>