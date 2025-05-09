<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    die(json_encode(['nome' => 'Usuário não logado']));
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT email FROM usuarios WHERE id = ?"; // Busca pelo email
$stmt = $pdo->prepare($sql);
$stmt->execute([$user_id]); // Executa a consulta com o ID do usuário
$result = $stmt->fetch(PDO::FETCH_ASSOC); // Obtém o resultado

if ($result) {
    echo json_encode(['email' => $result['email']]); // Retorna o email
} else {
    echo json_encode(['email' => 'Email não encontrado']);
}
?>