<?php
include 'config.php';

if (isset($_GET['nome_turma'])) {
    $nome_turma = $_GET['nome_turma'];

    // Consulta SQL para buscar as turmas com base no nome
    $sql_turmas = "SELECT id, nome 
                   FROM turma 
                   WHERE nome LIKE :nome_turma
                   ORDER BY nome";

    // Prepare e execute a consulta
    $stmt_turmas = $pdo->prepare($sql_turmas);
    $stmt_turmas->bindValue(':nome_turma', '%' . $nome_turma . '%', PDO::PARAM_STR); // Pesquisa com LIKE
    $stmt_turmas->execute();

    // Recupera os resultados
    $turmas = $stmt_turmas->fetchAll(PDO::FETCH_ASSOC);

    // Exibe os resultados encontrados
    if ($turmas) {
        foreach ($turmas as $turma) {
            echo "<div class='turma-item' data-id='" . htmlspecialchars($turma['id']) . "'>" . htmlspecialchars($turma['nome']) . "</div>";
        }
    } else {
        echo "Nenhuma turma encontrada.";
    }
}
?>
