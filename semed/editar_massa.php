<?php
session_start();
include 'config.php';

// Inicializa as variáveis com valores padrão
$usuario_id = null;
$usuario_nome = "Usuário não logado";
$disciplina_nome = "Disciplina não encontrada";

// Verifica se o usuário está logado
if (isset($_SESSION['usuario_id'])) {
    $usuario_id = $_SESSION['usuario_id'];
}

// Consulta para obter o nome do usuário logado, se o ID estiver disponível
if ($usuario_id) {
    try {
        // Consulta para obter o nome do usuário
        $sql = "SELECT nome FROM usuarios WHERE id = :usuario_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':usuario_id' => $usuario_id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verifica se o resultado contém a chave 'nome'
        if (isset($row['nome'])) {
            $usuario_nome = $row['nome'];
        } else {
            $usuario_nome = "Nome não encontrado no banco de dados.";
        }
    } catch (PDOException $e) {
        die("Erro na consulta SQL: " . $e->getMessage());
    }
}

// Recupera os filtros da URL
$filtroTurma = isset($_GET['turma']) ? $_GET['turma'] : '';
$filtroPeriodo = isset($_GET['periodo']) ? $_GET['periodo'] : '';

// Verifica se o formulário foi enviado para atualização
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Iterar por todos os IDs presentes no formulário
        foreach ($_POST['ids'] as $id) {
            // Coleta os dados atualizados
            $data = $_POST['dia_' . $id];
            $conteudo = $_POST['conteudo_' . $id];
            $quantidade = $_POST['quantidade_' . $id];

            // Atualiza os dados da aula no banco
            $sql_update = "UPDATE aulas 
                           SET dia = :data, 
                               conteudo = :conteudo,
                               quantidade = :quantidade
                           WHERE id = :id AND usuario_id = :usuario_id";
            $stmt = $pdo->prepare($sql_update);
            $stmt->execute([
                ':data' => $data,
                ':conteudo' => $conteudo,
                ':quantidade' => $quantidade,
                ':id' => $id,
                ':usuario_id' => $usuario_id
            ]);
        }
        echo "Aulas atualizadas com sucesso!";
        header("Location: listar_aula.php");
        exit;
    } catch (PDOException $e) {
        die("Erro ao atualizar aulas: " . $e->getMessage());
    }
}

// Construção da consulta SQL com filtros
$sql = "SELECT * FROM aulas WHERE usuario_id = :usuario_id";

if (!empty($filtroTurma)) {
    $sql .= " AND turma_id = :turma_id";
}

if (!empty($filtroPeriodo)) {
    $sql .= " AND periodo_id = :periodo_id";
}

// Ordenação por data em ordem decrescente
$sql .= " ORDER BY dia ASC";

try {
    $stmt = $pdo->prepare($sql);
    $params = [':usuario_id' => $usuario_id];

    if (!empty($filtroTurma)) {
        $params[':turma_id'] = $filtroTurma;
    }

    if (!empty($filtroPeriodo)) {
        $params[':periodo_id'] = $filtroPeriodo;
    }

    $stmt->execute($params);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erro na consulta SQL: " . $e->getMessage());
}

// Fecha a conexão com o banco de dados
$pdo = null;
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Aulas em Massa</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .table {
            max-width: 90%;
            margin: 0 auto;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <table class="table table-bordered">
        <tr>
            <td class="text-start" style="text-transform: uppercase;">
                <h1 class="mb-3" style="color: green; font-size: 24px;">
                    Professor(a): <?php echo htmlspecialchars($usuario_nome); ?><br>
                   
                </h1>
            </td>
        </tr>
    </table>
    <form action="editar_massa.php?turma=<?php echo urlencode($filtroTurma); ?>&periodo=<?php echo urlencode($filtroPeriodo); ?>" method="POST" class="mt-4">
        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>Data <p></th>
                    <th>Conteúdo <p></th>
                    <th>Aulas <p> ministradas</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($result)): ?>
                    <?php foreach ($result as $row): ?>
                        <tr>
                            <input type="hidden" name="ids[]" value="<?= $row['id']; ?>">
                            <td><input type="date" class="form-control" name="dia_<?= $row['id']; ?>" value="<?= htmlspecialchars($row['dia']); ?>"></td>
                            <td>
                                <textarea class="form-control" name="conteudo_<?= $row['id']; ?>" rows="3" required><?= htmlspecialchars($row['conteudo']); ?></textarea>
                            </td>
                            <td><input type="text" class="form-control" name="quantidade_<?= $row['id']; ?>" value="<?= htmlspecialchars($row['quantidade']); ?>" min="1"></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center">Nenhuma aula encontrada.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <table class="table table-bordered">
            <tfoot>
                <tr>
                    <td colspan="2" class="text-end">
                        <button type="submit" class="btn btn-success">Salvar Alterações</button>
                        <a href="listar_aula.php?turma=<?php echo urlencode($filtroTurma); ?>&periodo=<?php echo urlencode($filtroPeriodo); ?>" class="btn btn-secondary">Cancelar</a>
                    </td>
                </tr>
            </tfoot>
        </table>
    </form>
</div>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>