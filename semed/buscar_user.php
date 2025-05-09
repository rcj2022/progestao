<?php
session_start();

include 'config.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    die("Usuário não está logado.");
}



// Busca o nome do usuário
$user_id = $_SESSION['user_id'];
$sql = "SELECT nome FROM usuarios WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($nome);
$stmt->fetch();
$stmt->close();
$conn->close();

// Retorna o nome do usuário como JSON
echo json_encode(['nome' => $nome]);
?>