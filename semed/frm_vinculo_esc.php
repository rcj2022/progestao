<?php
// Conexão com o banco de dados
include 'config.php';

// Buscar escolas
$escolas = $pdo->query("SELECT id, nome FROM escola")->fetchAll();

// Buscar usuários do tipo "secretario"
$usuarios = $pdo->query("SELECT id, nome FROM usuarios WHERE tipo = 'secretario'")->fetchAll();

// Processar o formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $escola_id = $_POST['escola_id'];
    $usuario_id = $_POST['usuario_id'];

    $stmt = $pdo->prepare("INSERT INTO vinculo_esc_usuario (escola_id, usuario_id) VALUES (?, ?)");
    $stmt->execute([$escola_id, $usuario_id]);
// Redirecionar para painel_principal.php após a inserção
header("Location: painel_principal.php");
exit(); // Certifique-se de sair do script após o redirecionamento
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vincular Escola e Secretário</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Vincular Escola e Secretário</h2>
        <form method="POST">
            <div class="mb-3">
                <label for="escola_id" class="form-label">Escola</label>
                <select class="form-select" id="escola_id" name="escola_id" required>
                    <option value="">Selecione uma escola</option>
                    <?php foreach ($escolas as $escola): ?>
                        <option value="<?= $escola['id'] ?>"><?= htmlspecialchars($escola['nome']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="usuario_id" class="form-label">Secretário</label>
                <select class="form-select" id="usuario_id" name="usuario_id" required>
                    <option value="">Selecione um secretário</option>
                    <?php foreach ($usuarios as $usuario): ?>
                        <option value="<?= $usuario['id'] ?>"><?= htmlspecialchars($usuario['nome']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Vincular</button>
        </form>
    </div>
</body>
</html>