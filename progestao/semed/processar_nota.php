<?php
// Conexão com o banco de dados utilizando PDO (arquivo config.php)
include 'config.php';

try {
    // Inicia uma transação (opcional, mas recomendado para operações em massa)
    $pdo->beginTransaction();

    // Verifica se os arrays de notas foram enviados
    if (isset($_POST['nota1'], $_POST['nota2'], $_POST['nota3'], $_POST['total'])) {
        $nota1Array = $_POST['nota1'];
        $nota2Array = $_POST['nota2'];
        $nota3Array = $_POST['nota3'];
        $totalArray = $_POST['total'];

        // Prepara o statement para inserir os registros na tabela "notas"
        $stmt = $pdo->prepare("
            INSERT INTO 1bimestre (id_aluno, nota1, nota2, nota3, total)
            VALUES (:id_aluno, :nota1, :nota2, :nota3, :total)
        ");

        // Itera sobre cada aluno (usando o índice do array, que corresponde ao id do aluno)
        foreach ($nota1Array as $id_aluno => $nota1) {
            // Obtém os valores correspondentes dos outros arrays
            $nota2 = isset($nota2Array[$id_aluno]) ? $nota2Array[$id_aluno] : null;
            $nota3 = isset($nota3Array[$id_aluno]) ? $nota3Array[$id_aluno] : null;
            $total = isset($totalArray[$id_aluno]) ? $totalArray[$id_aluno] : null;

            // Executa o insert para cada aluno
            $stmt->execute([
                ':id_aluno' => $id_aluno,
                ':nota1'    => $nota1,
                ':nota2'    => $nota2,
                ':nota3'    => $nota3,
                ':total'    => $total,
            ]);
        }

        // Confirma a transação
        $pdo->commit();
        echo "<div class='container mt-5'><div class='alert alert-success'>Notas salvas com sucesso!</div></div>";
    } else {
        echo "<div class='container mt-5'><div class='alert alert-danger'>Dados inválidos!</div></div>";
    }
} catch (Exception $e) {
    // Em caso de erro, desfaz a transação
    $pdo->rollBack();
    echo "<div class='container mt-5'><div class='alert alert-danger'>Erro ao salvar as notas: " . $e->getMessage() . "</div></div>";
}

// "Fechamento" da conexão PDO (opcional)
$pdo = null;
?>
