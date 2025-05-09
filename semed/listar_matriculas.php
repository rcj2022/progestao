<?php
session_start();
include 'config.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit();
}

$usuario_id = $_SESSION['usuario_id'];
$vinculos = [];

// Captura os filtros
$filtro_professor = $_GET['professor'] ?? '';
$filtro_disciplina = $_GET['disciplina'] ?? '';
$filtro_turma = $_GET['turma'] ?? '';
$filtro_bimestre = $_GET['bimestre'] ?? '';

// Verifica se algum filtro foi preenchido
$filtros_preenchidos = !empty($filtro_professor) || !empty($filtro_disciplina) || !empty($filtro_turma) || !empty($filtro_bimestre);

if ($filtros_preenchidos) {
    try {
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Obtém a escola vinculada ao usuário logado
        $stmt = $pdo->prepare("SELECT escola_id FROM vinculo_esc_usuario WHERE usuario_id = ?");
        $stmt->execute([$usuario_id]);
        $vinculo_escola = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($vinculo_escola) {
            $escola_id = $vinculo_escola['escola_id'];

            // Construção da query com filtros dinâmicos
            $sql = "
                SELECT DISTINCT a.nome AS aluno_nome, MIN(v.id) AS id
                FROM vinculos v
                JOIN alunos a ON v.aluno_id = a.id
                JOIN usuarios p ON v.usuario_id = p.id
                JOIN disciplinas d ON v.disciplina_id = d.id_disciplina
                JOIN turma t ON v.turma_id = t.id
                JOIN bimestres b ON v.bimestre_id = b.id
                JOIN escola e ON v.escola_id = e.id
                WHERE v.escola_id = ?
            ";

            $params = [$escola_id];

            if (!empty($filtro_professor)) {
                $sql .= " AND p.nome LIKE ?";
                $params[] = "%$filtro_professor%";
            }
            if (!empty($filtro_disciplina)) {
                $sql .= " AND d.nome LIKE ?";
                $params[] = "%$filtro_disciplina%";
            }
            if (!empty($filtro_turma)) {
                $sql .= " AND t.nome LIKE ?";
                $params[] = "%$filtro_turma%";
            }
            if (!empty($filtro_bimestre)) {
                $sql .= " AND b.nome LIKE ?";
                $params[] = "%$filtro_bimestre%";
            }

            // Agrupar por aluno para evitar repetições
            $sql .= " GROUP BY a.nome ORDER BY a.nome ASC";

            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);
            $vinculos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    } catch (PDOException $e) {
        die("Erro ao buscar vínculos: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar Vínculos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</head>
<body>
    <div class="container mt-4 border p-3">
        <form method="GET" class="row g-2">
            <div class="col-md-3">
                <input type="text" name="professor" class="form-control" placeholder="Professor" value="<?= htmlspecialchars($filtro_professor) ?>">
            </div>
            <div class="col-md-3">
                <input type="text" name="disciplina" class="form-control" placeholder="Disciplina" value="<?= htmlspecialchars($filtro_disciplina) ?>">
            </div>
            <div class="col-md-3">
                <input type="text" name="turma" class="form-control" placeholder="Turma" value="<?= htmlspecialchars($filtro_turma) ?>">
            </div>
            <div class="col-md-3">
                <input type="text" name="bimestre" class="form-control" placeholder="Bimestre" value="<?= htmlspecialchars($filtro_bimestre) ?>">
            </div>
            <div class="col-md-12 text-end">
                <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i> Filtrar</button>
                <a href="listar_matriculas.php" class="btn btn-secondary"><i class="bi bi-x-circle"></i> Limpar</a>
            </div>
        </form>
    </div>

    <div class="container d-flex justify-content-end mb-4 mt-4 border">
        <a href="frm_vinculos.php" class="btn btn-success mb-2 mt-2 me-2">
            <i class="bi bi-plus-lg"></i> Novo Vínculo
        </a>
        <a href="painel_secretario.php" class="btn btn-secondary mb-2 mt-2">Voltar</a>
    </div>

    <?php if ($filtros_preenchidos): ?>
    <div class="container mt-3 border">
        <div class="table-responsive">
        <table class="table table-striped table-hover table-bordered mt-3 p-3">
            <thead>
                <tr>
                    <th>Nº</th>
                    <th>Aluno</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($vinculos)): ?>
                    <?php $contador = 1; ?>
                    <?php foreach ($vinculos as $vinculo): ?>
                        <tr>
                            <td><?= $contador++; ?></td>
                            <td><?= htmlspecialchars($vinculo['aluno_nome']) ?></td>
                            <td>
                                <a href="editar_vinculo.php?id=<?= $vinculo['id'] ?>" class="btn btn-warning btn-sm mb-2">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <a href="excluir_vinculo.php?id=<?= $vinculo['id'] ?>" class="btn btn-danger btn-sm mb-2" onclick="return confirm('Tem certeza que deseja excluir este vínculo?');">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3" class="text-center">Nenhum vínculo encontrado.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        </div>
    </div>
    <?php endif; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
