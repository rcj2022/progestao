
<?php
include 'config.php';
session_start();

// Obtém o ID do usuário logado (supondo que esteja na sessão)
$usuario_id = $_SESSION['usuario_id'] ?? null; 

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
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Usuário</title>
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
                        <h4 class="card-title">Cadastrar Usuário</h4>
                    </div>
                    <div class="card-body">
                        <!-- Formulário de Cadastro -->
                        <form id="cadastroForm">
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

                            <div class="mb-3">
                                <label for="nome" class="form-label">Nome</label>
                                <input type="text" class="form-control" id="nome" name="nome" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">E-mail</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="senha" class="form-label">Senha</label>
                                <input type="password" class="form-control" id="senha" name="senha" required>
                            </div>
                            <div class="mb-3">
                                <label for="tipo" class="form-label">Tipo de Usuário</label>
                                <select class="form-select" id="tipo" name="tipo" required>
                                    <option value="admin">Administrador</option>
                                    <option value="secretario">Secretario</option>
                                    <option value="professor">Professor</option>
                                    <option value="aluno">Aluno</option>
                                    <option value="funcionario">Funcionario</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Cadastrar</button>
                            <a href="painel_secretario.php" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Voltar
                            </a>
                        </form>
                        <!-- Mensagem de Resposta -->
                        <div id="resposta" class="mt-3"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS e Dependências -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery (necessário para o AJAX) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#cadastroForm').on('submit', function(e) {
                e.preventDefault(); // Evita o envio tradicional do formulário

                $('#resposta').html(''); // Limpa a mensagem de resposta

                $.ajax({
                    url: 'cad_user.php', // Arquivo PHP que processa o cadastro
                    type: 'POST',
                    data: $(this).serialize(), // Serializa os dados do formulário
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            $('#resposta').html('<div class="alert alert-success">' + response.message + '</div>');
                            if (response.redirect) {
                                window.location.href = response.redirect; // Redirecionamento após sucesso
                            }
                        } else {
                            $('#resposta').html('<div class="alert alert-danger">' + response.message + '</div>');
                        }
                    },
                    error: function() {
                        $('#resposta').html('<div class="alert alert-danger">Erro ao processar a requisição.</div>');
                    }
                });
            });
        });
    </script>
</body>
</html>
