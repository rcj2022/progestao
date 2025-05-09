<?php
session_start(); // Inicia a sessão

// Verificar se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    // Redirecionar para a página de login se o usuário não estiver logado
    header('Location: index.html');
    exit();
}

// Verificar o tipo de usuário (opcional)
$tipo_usuario = $_SESSION['tipo_usuario'];
?>