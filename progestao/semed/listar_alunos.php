<?php
session_start();
include 'config.php';

// Obtém o ID do usuário logado (supondo que esteja na sessão)
$usuario_id = $_SESSION['usuario_id'] ?? null; 

// Inicializa a variável da escola
$escola_usuario = null;
$escola_id = null;

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

// Busca os alunos da escola do usuário logado
$alunos = getAlunos($pdo, $escola_id); // Passa o escola_id como parâmetro
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar Alunos</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    
</head>
<body>
    <!-- Botão Voltar -->
    <div class="container d-flex justify-content-end mb-4 mt-4 border">
        <a href="frm_aluno.php" class="btn btn-success mb-2 mt-2 me-2">
            <i class="bi bi-plus-lg"></i> Aluno
        </a>
        <a href="painel_secretario.php" class="btn btn-secondary mb-2 mt-2">Voltar</a>
    </div>

    <div class="container mt-3 border">
        <div class="table-responsive"> <!-- Div responsiva -->
            <table class="table table-striped table-hover table-bordered mt-3 p-3">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Social</th>
                        <th>Pessoa</th>
                        <th>Nascimento</th>
                        <th>Sexo</th>
                        <th>Mãe</th>
                        <th>Pai</th>
                        <th>CPF/CNPJ</th>
                        <th>E-mail</th>
                        <th>Celular</th>
                        <th>Ações</th> 
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($alunos as $aluno): ?>
                        <tr>
                            <td><?php echo htmlspecialchars(strtoupper($aluno['nome'])); ?></td>
                            <td><?php echo htmlspecialchars($aluno['nome_social']); ?></td>
                            <td><?php echo htmlspecialchars($aluno['tipo_pessoa']); ?></td>
                            <td><?php echo date('d/m/Y', strtotime($aluno['data_nascimento'])); ?></td>
                            <td><?php echo htmlspecialchars($aluno['sexo']); ?></td>
                            <td><?php echo htmlspecialchars($aluno['mae']); ?></td>
                            <td><?php echo htmlspecialchars($aluno['pai']); ?></td>
                            <td><?php echo htmlspecialchars($aluno['cpf_cnpj']); ?></td>
                            <td><?php echo htmlspecialchars($aluno['email']); ?></td>
                            <td><?php echo htmlspecialchars($aluno['celular']); ?></td>
                            <td>
    <a href="editar_aluno.php?id=<?php echo $aluno['id']; ?>" class="btn btn-warning btn-sm mb-2">
        <i class="bi bi-pencil"></i>
    </a>
    <a href="excluir_aluno.php?id=<?php echo $aluno['id']; ?>" class="btn btn-danger btn-sm mb-2" onclick="return confirm('Tem certeza que deseja excluir este aluno?');">
        <i class="bi bi-trash"></i>
    </a>
</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div> <!-- Fecha a div responsiva -->
    </div>

    <!-- Bootstrap 5 JS (opcional, apenas se precisar de funcionalidades JS) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>