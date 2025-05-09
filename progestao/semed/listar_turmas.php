<?php
session_start();

// Conectar ao banco de dados
include 'config.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit();
}

try {
    // Obtém a escola do usuário logado
    $sql = "SELECT escola_id FROM vinculo_esc_usuario WHERE usuario_id = :usuario_id LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':usuario_id', $_SESSION['usuario_id'], PDO::PARAM_INT);
    $stmt->execute();
    $escola = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$escola) {
        die("Erro: Usuário não está vinculado a nenhuma escola.");
    }

    $escola_id = $escola['escola_id'];

    // Busca todas as turmas dessa escola
    $sql = "SELECT id, nome, turno, quantidade_maxima_alunos, curso, etapa 
            FROM turma 
            WHERE escola_id = :escola_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':escola_id', $escola_id, PDO::PARAM_INT);
    $stmt->execute();
    $turmas = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erro ao buscar turmas: " . htmlspecialchars($e->getMessage()));
}
?>




<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar Turmas</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome para ícones -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-3 border p-3 bg-light">
    <div class="d-flex justify-content-between align-items-center">
        <h4>Resgistro/Listar</h4>
      
        <a href="painel_secretario.php" class="btn btn-primary">Voltar</a>
    </div>
</div>
    <div class="container mt-3 border p-3">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Turma</th>
                    <th>Turno</th>
                    <th>Quantidade de Alunos</th>
                    <th>Curso</th>
                    <th>Etapa</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($turmas) > 0): ?>
                    <?php foreach ($turmas as $turma): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($turma['id']); ?></td>
                            <td><?php echo htmlspecialchars($turma['nome']); ?></td>
                            <td><?php echo htmlspecialchars($turma['turno']); ?></td>
                            <td><?php echo htmlspecialchars($turma['quantidade_maxima_alunos']); ?></td>
                            <td><?php echo htmlspecialchars($turma['curso']); ?></td>
                            <td><?php echo htmlspecialchars($turma['etapa']); ?></td>
                            <td>
                                <a href="editar_turma.php?id=<?php echo $turma['id']; ?>" class="btn btn-sm btn-warning">Editar</a>
                                <a href="excluir_turma.php?id=<?php echo $turma['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir esta turma?')">Excluir</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center">Nenhuma turma cadastrada.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>