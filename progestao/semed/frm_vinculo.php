<?php
  include 'config.php'; // Arquivo que contém a conexão PDO
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Vincular Professor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">

    <h2 class="text-center">Vincular Professor a Turmas</h2>
    
    <form action="vincular.php" method="POST" class="card p-4 shadow-lg">
        <div class="mb-3">
            <label class="form-label">Professor:</label>
            <select name="professor_id" class="form-select" required>
                <option value="">Selecione um Professor</option>
                <?php
                try {
                    $stmt = $pdo->query("SELECT * FROM professores");
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='{$row['id']}'>{$row['nome']}</option>";
                    }
                } catch (PDOException $e) {
                    echo "<option value=''>Erro ao carregar professores</option>";
                }
                ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Disciplina:</label>
            <select name="id" class="form-select" required>
                <option value="">Selecione uma Disciplina</option>
                <?php
                try {
                    $stmt = $pdo->query("SELECT * FROM disciplinas");
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='{$row['id_disciplina']}'>{$row['nome']}</option>";
                    }
                } catch (PDOException $e) {
                    echo "<option value=''>Erro ao carregar disciplinas</option>";
                }
                ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Turmas:</label>
            <select name="turma_id[]" class="form-select" multiple required>
                <?php
                try {
                    $stmt = $pdo->query("SELECT * FROM turma"); // Corrigido nome da tabela
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='{$row['id']}'>{$row['nome_turma']}</option>";
                    }
                } catch (PDOException $e) {
                    echo "<option value=''>Erro ao carregar turmas</option>";
                }
                ?>
            </select>
            <small class="form-text text-muted">Segure Ctrl (ou Cmd no Mac) para selecionar várias turmas.</small>
        </div>

        <button type="submit" class="btn btn-primary w-100">Vincular</button>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
