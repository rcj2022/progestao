<?php
session_start(); // Inicia a sessão

include 'config.php'; // Certifique-se de que o arquivo de configuração está incluído corretamente

try {
    // Verificar se os dados do formulário foram enviados
    if (empty($_POST['email']) || empty($_POST['senha'])) {
        throw new Exception("Por favor, preencha todos os campos do formulário.");
    }

    // Capturar dados do formulário
    $email = trim($_POST['email']); // Remove espaços em branco no início e no fim
    $senha = trim($_POST['senha']); // Remove espaços em branco no início e no fim

    // Verificar se o email é válido
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new Exception("Por favor, insira um email válido.");
    }

    // Verificar se o usuário existe
    $sql = "SELECT id, senha, tipo FROM usuarios WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['email' => $email]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario && password_verify($senha, $usuario['senha'])) {
        // Login bem-sucedido
        $_SESSION['usuario_id'] = $usuario['id']; // Armazenar ID do usuário na sessão
        $_SESSION['tipo_usuario'] = $usuario['tipo']; // Armazenar tipo de usuário na sessão

        // Redirecionar com base no tipo de usuário
        switch ($usuario['tipo']) {
            case 'admin':
                header('Location: painel_principal.php');
                break;
            case 'secretario':
                header('Location: painel_secretario.php');
                break;
            case 'professor':
                header('Location: painel_professor.php');
                break;
            case 'aluno':
                header('Location: painel_aluno.php');
                break;
            default:
                // Tipo de usuário desconhecido
                throw new Exception("Tipo de usuário desconhecido.");
        }
        exit(); // Encerrar o script após o redirecionamento
    } else {
        // Login falhou
        throw new Exception("Email ou senha incorretos.");
    }
} catch (PDOException $e) {
    // Tratar erros de conexão ou query
    echo "<script>alert('Erro ao processar o login: " . addslashes($e->getMessage()) . "'); window.location.href = 'login.php';</script>";
    exit();
} catch (Exception $e) {
    // Tratar outros erros
    echo "<script>alert('" . addslashes($e->getMessage()) . "'); window.location.href = 'login.php';</script>";
    exit();
}
?>