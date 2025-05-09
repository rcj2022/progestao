<?php
session_start();
include 'config.php'; // Arquivo de conexão com o banco de dados
// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php'); // Redireciona para a página de login
    exit();
}

$usuario_id = $_SESSION['usuario_id'];
// Obtém a escola do usuário logado na tabela vinculo_esc_usuario
$sql = "SELECT escola_id FROM vinculo_esc_usuario WHERE usuario_id = :usuario_id LIMIT 1";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
$stmt->execute();
$escola = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$escola) {
    die("Erro: Usuário não está vinculado a nenhuma escola.");
}

$escola_id = $escola['escola_id'];
// Buscar turmas
$sql_turmas = "SELECT id, nome FROM turma ORDER BY nome";
$result_turmas = $pdo->query($sql_turmas);

// Buscar disciplinas
$sql_disciplinas = "SELECT id_disciplina, nome FROM disciplinas ORDER BY nome";
$result_disciplinas = $pdo->query($sql_disciplinas);

/// Buscar professores únicos apenas da escola logada
// Consulta para carregar apenas os professores da escola do usuário logado
$stmtProfessores = $pdo->prepare("SELECT id, nome FROM usuarios WHERE tipo = 'professor' AND escola_id = :escola_id ORDER BY nome");
$stmtProfessores->execute(['escola_id' => $escola_id]);
$professores = $stmtProfessores->fetchAll(PDO::FETCH_ASSOC);
// Inicializa a variável da escola
$escola_usuario = null;

if ($usuario_id) {
    // Busca o ID da escola na tabela vinculo_escola_usuario
    $stmt = $pdo->prepare("SELECT escola_id FROM vinculo_esc_usuario WHERE usuario_id = ?");
    $stmt->execute([$usuario_id]);
    $vinculo = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($vinculo) {
        $escola_id = $vinculo['escola_id'];

        // Busca os detalhes da escola
        $stmt = $pdo->prepare("SELECT * FROM escola WHERE id = ?");
        $stmt->execute([$escola_id]);
        $escola_usuario = $stmt->fetch(PDO::FETCH_ASSOC);
    }
}


?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Disciplina</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card {
            max-width: 600px;
            margin: auto;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }
        .card-header {
            text-align: center;
            font-weight: bold;
            font-size: 1.3rem;
        }
    </style>
</head>
<body class="bg-light">

    <div class="container mt-5">
        <div class="card">
            <div class="card-header bg-primary text-white">Cadastro de Disciplina</div>
            <div class="card-body">
                <form action="salvar_disciplina.php" method="POST">

                <div class="mb-3">
                <label for="escola" class="form-label fw-bold" style="text-transform: uppercase">Escola:</label>
                <select class="form-select" id="escola" name="escola_id" required readonly>
                    <?php if ($escola_usuario): ?>
                        <option value="<?= $escola_usuario['id'] ?>" selected><?= $escola_usuario['nome'] ?></option>
                    <?php else: ?>
                        <option value="">Nenhuma escola encontrada</option>
                    <?php endif; ?>
                </select>
            </div>
                    
                   <!-- Seleção de Turmas -->
<div class="mb-3">
    <label class="form-label">Turma</label>
    <select name="turma_ids[]" class="form-control" multiple required>
        <option value="" selected disabled>Selecione as turmas</option>
        <?php 
        // Supondo que você já tenha a variável $result_turmas com as turmas recuperadas
        while ($row = $result_turmas->fetch(PDO::FETCH_ASSOC)): ?>
            <option value="<?php echo $row['id']; ?>"><?php echo htmlspecialchars($row['nome']); ?></option>
        <?php endwhile; ?>
    </select>
</div>


                    <!-- Seleção da Disciplina -->
                    <div class="mb-3">
                        <label class="form-label">Disciplina</label>
                        <select name="disciplina_id[]" class="form-control"  multiple required>
                            <option value="" selected disabled>Selecione a disciplina</option>
                            <?php while ($row = $result_disciplinas->fetch(PDO::FETCH_ASSOC)): ?>
                                <option value="<?php echo $row['id_disciplina']; ?>"><?php echo htmlspecialchars($row['nome']); ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <!-- Tipo de Disciplina -->
                    <div class="mb-3">
                        <label class="form-label">Tipo de Disciplina</label>
                        <select name="tipo_disciplina" class="form-control" required>
                            <option value="" selected disabled>Selecione</option>
                            <option value="Obrigatória">Obrigatória</option>
                            <option value="Optativa">Optativa</option>
                        </select>
                    </div>

                    <!-- Seleção do Professor -->
                    <div class="mb-3">
                        <label class="form-label">Professor</label>
                        <select name="professor_id" class="form-control" required>
    <option value="">Selecione o professor</option>
    <?php foreach ($professores as $professor): ?>
        <option value="<?= htmlspecialchars($professor['id']) ?>">
            <?= htmlspecialchars($professor['nome']) ?>
        </option>
    <?php endforeach; ?>
</select>

                    </div>

                    <!-- Carga Horária Total -->
                    <div class="mb-3">
                        <label class="form-label">Carga Horária Total</label>
                        <input type="number" name="carga_horaria" class="form-control" required>
                    </div>

                    <!-- Carga Horária Semanal -->
                    <div class="mb-3">
                        <label class="form-label">Carga Horária Semanal</label>
                        <input type="number" name="carga_horaria_semanal" class="form-control" required>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary w-100">Cadastrar</button>
                        <a href="painel_secretario.php" class="btn btn-secondary mb-2 mt-2 w-100">Voltar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>
</html>

