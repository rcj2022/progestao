<?php
session_start();

if (!isset($_SESSION['escola_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'ID da escola não encontrado na sessão.']);
    exit();
}

echo json_encode(['status' => 'success', 'escola_id' => $_SESSION['escola_id']]);
exit();
?>
