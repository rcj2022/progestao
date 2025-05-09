<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit();
}

// Verifica se o ID do usuário foi passado na URL
if (!isset($_GET['id'])) {
    header('Location: listar_usuarios.php');
    exit();
}

$usuario_id = $_GET['id'];

// Conectar ao banco de dados
include 'config.php';

try {
    // Busca os dados do usuário
    $sql = "SELECT id, nome, email, tipo FROM usuarios WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $usuario_id, PDO::PARAM_INT);
    $stmt->execute();
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$usuario) {
        die("Usuário não encontrado.");
    }
} catch (PDOException $e) {
    die("Erro ao buscar usuário: " . $e->getMessage());
}

// Processamento do formulário de edição
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $tipo = $_POST['tipo'];

    try {
        // Atualiza os dados do usuário
        $sql = "UPDATE usuarios SET nome = :nome, email = :email, tipo = :tipo WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':tipo', $tipo, PDO::PARAM_STR);
        $stmt->bindParam(':id', $usuario_id, PDO::PARAM_INT);
        $stmt->execute();

        // Agora vamos atualizar a tabela 'vinculos', passando o usuario_id
        // Vamos assumir que o id dos alunos e outros dados relacionados ao vínculo vêm de um formulário (ou de alguma outra origem)
        // Exemplo de como atualizar os vínculos com o usuario_id (adicione a lógica conforme necessário)

        if (isset($_POST['aluno_ids']) && is_array($_POST['aluno_ids'])) {
            $aluno_ids = $_POST['aluno_ids']; // Supondo que você tenha esses dados no formulário
            foreach ($aluno_ids as $aluno_id) {
                $sql_vinculos = "UPDATE vinculos SET usuario_id = :usuario_id WHERE aluno_id = :aluno_id";
                $stmt_vinculos = $pdo->prepare($sql_vinculos);
                $stmt_vinculos->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
                $stmt_vinculos->bindParam(':aluno_id', $aluno_id, PDO::PARAM_INT);
                $stmt_vinculos->execute();
            }
        }

        // Redireciona para a lista de usuários
        header('Location: listar_user.php');
        exit();
    } catch (PDOException $e) {
        die("Erro ao atualizar usuário: " . $e->getMessage());
    }
}
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuário</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
      <!-- Font Awesome para ícones -->
      <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
<div class="row justify-content-center">
<div class="col-md-6">
    <div class="card">
        <div class="card-header">
            <h2>Editar Usuário</h2>
        </div>
        <div class="card-body">
            <form method="POST">
                <div class="mb-3">
                    <label for="nome" class="form-label">Nome</label>
                    <input type="text" class="form-control" id="nome" name="nome" value="<?php echo htmlspecialchars($usuario['nome']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">E-mail</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($usuario['email']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="tipo" class="form-label">Tipo</label>
                    <select class="form-select" id="tipo" name="tipo" required>
                        <option value="admin" <?php echo ($usuario['tipo'] === 'admin') ? 'selected' : ''; ?>>Administrador</option>
                        <option value="secretario" <?php echo ($usuario['tipo'] === 'secretario') ? 'selected' : ''; ?>>Secretário</option>
                        <option value="aluno" <?php echo ($usuario['tipo'] === 'aluno') ? 'selected' : ''; ?>>Aluno</option>
                        <option value="professor" <?php echo ($usuario['tipo'] === 'professor') ? 'selected' : ''; ?>>Professor</option>
                        <option value="funcionario" <?php echo ($usuario['tipo'] === 'funcionario') ? 'selected' : ''; ?>>Funcionário</option>
                    </select>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Salvar</button>
                    <a href="painel_secretario.php" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Voltar
        </a>
                </div>
            </form>
        </div>
    </div>
    </div>
    </div>
</div>

</body>
</html>