<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php'); // Redireciona para a página de login
    exit();
}

// Conectar ao banco de dados
include 'config.php';

$usuario_id = $_SESSION['usuario_id'];

try {
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

    // Consulta para buscar apenas professores da escola logada
    $sql = "SELECT id, nome, email, tipo FROM usuarios WHERE escola_id = :escola_id AND tipo = 'professor'";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':escola_id', $escola_id, PDO::PARAM_INT);
    $stmt->execute();

    // Busca todos os resultados
    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erro ao buscar professores: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar Professores</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome para ícones -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-3 p-3 border">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <h2>Listar Professores</h2>
        <div class="d-flex">
            <a href="frm_user.php" class="btn btn-primary me-2">
                <i class="fas fa-plus"></i> Cadastrar Novo Professor
            </a>
            <a href="painel_secretario.php" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Voltar
            </a>
        </div>
    </div>
</div>

<div class="container mt-3 p-3 border">
    <!-- Tabela de Professores -->
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>E-mail</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($usuarios) > 0): ?>
                <?php foreach ($usuarios as $usuario): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($usuario['id']); ?></td>
                        <td><?php echo htmlspecialchars($usuario['nome']); ?></td>
                        <td><?php echo htmlspecialchars($usuario['email']); ?></td>
                        <td>
                            <a href="editar_user.php?id=<?php echo $usuario['id']; ?>" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i> Editar
                            </a>
                            <a href="excluir_usuario.php?id=<?php echo $usuario['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir este professor?');">
                                <i class="fas fa-trash"></i> Excluir
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" class="text-center">Nenhum professor cadastrado nesta escola.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
