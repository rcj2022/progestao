<?php
session_start(); // Inicia a sessão
include 'config.php'; // Conexão com o banco de dados PDO

// Definição padrão do nome do usuário
$usuario_nome = "Usuário não logado";

if (isset($_SESSION['usuario_id'])) {
    $usuario_id = $_SESSION['usuario_id']; // Recupera o ID do usuário da sessão

    try {
        // Consulta para buscar o nome do usuário
        $sql_usuario = "SELECT nome FROM usuarios WHERE id = :id";
        $stmt = $pdo->prepare($sql_usuario);
        $stmt->bindParam(':id', $usuario_id, PDO::PARAM_INT);
        $stmt->execute();
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario) {
            $usuario_nome = $usuario['nome'];
        } else {
            $usuario_nome = "Usuário não encontrado no banco de dados.";
        }
    } catch (PDOException $e) {
        die("Erro ao buscar usuário: " . $e->getMessage());
    }

    
    try {
        // Consulta para buscar os bimestres
        $sql_bimestres = "SELECT id, nome FROM bimestres ORDER BY nome";
        $stmt_bimestres = $pdo->query($sql_bimestres);
        $bimestres = $stmt_bimestres->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Erro ao buscar dados dos bimestres: " . $e->getMessage());
    }
}
// Exibe a mensagem de erro se a query string contiver o parâmetro 'erro=1'
if (isset($_GET['erro']) && $_GET['erro'] == 1) {
    echo '<div class="alert alert-danger">Já existe uma aula cadastrada para a turma, período e data selecionados!</div>';
}
?>



<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Aulas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            margin-top: 90px; /* Deixa espaço para o título fixo */
        }
        /* Estilo para a lista de sugestões */
        #resultado_turmas {
            max-height: 150px;
            overflow-y: auto;
            border: 1px solid #ccc;
            margin-top: 5px;
            display: none; /* Inicialmente escondido */
        }
        .turma-item {
            padding: 5px;
            cursor: pointer;
        }
        .turma-item:hover {
            background-color: #f0f0f0;
        }
        .form-label {
    text-transform: uppercase; /* Transforma o texto em maiúsculas */
    text-align: right;        /* Alinha o texto à direita */
    margin-left: 10px;        /* Adiciona um espaço à esquerda para deslocar a label */
    display: block;           /* Garante que a label ocupe a linha inteira */
    font-weight: bold;        /* Deixa o texto em negrito */
}
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center border p-3 mx-auto" style="max-width: 1298px; width: 100%; position: fixed; top: 10px; z-index: 1030;">
            <h1 class="text-start h5 mb-0">Bem-vindo, <?php echo htmlspecialchars($usuario_nome); ?>!</h1>
            <a href="painel_professor.php" class="btn btn-danger btn-sm" data-bs-toggle="tooltip" title="Clique para voltar à página anterior">Voltar</a>
        </div>

        <form method="POST" action="Aulas.php">
            <table class="table table-bordered table-striped custom-table">
                <thead>
                    <tr>
                    <th style="text-align: right;">CAMPO</th>
                        <th>INFORMAÇÃO</th>
                    </tr>
                </thead>
                <tbody>
                <tr>
    <td><label for="turma" class="form-label">Turma:</label></td>
    <td>
    <select class="form-control" id="turma" name="turma" required>
    <option value="">Selecione a turma</option>
    <?php
    if (isset($_SESSION['usuario_id'])) {
        $usuario_id = $_SESSION['usuario_id']; // ID do usuário logado

        try {
            // Consulta SQL para buscar as turmas associadas ao usuário na tabela disciplina_individual
            $sql_turmas = "
                SELECT DISTINCT t.id, t.nome 
                FROM turma t
                INNER JOIN disciplina_individual di ON di.turma_id = t.id
                WHERE di.usuario_id = :usuario_id
                AND di.escola_id = (SELECT escola_id FROM disciplina_individual WHERE usuario_id = :usuario_id LIMIT 1)
                ORDER BY t.nome
            ";

            $stmt_turmas = $pdo->prepare($sql_turmas);
            $stmt_turmas->bindValue(':usuario_id', $usuario_id, PDO::PARAM_INT);
            $stmt_turmas->execute();

            $turmas = $stmt_turmas->fetchAll(PDO::FETCH_ASSOC);

            // Preenche o select com as turmas encontradas
            if ($turmas) {
                foreach ($turmas as $turma) {
                    echo '<option value="' . htmlspecialchars($turma['id']) . '">' . htmlspecialchars($turma['nome']) . '</option>';
                }
            } else {
                echo '<option value="">Nenhuma turma encontrada</option>';
            }

        } catch (PDOException $e) {
            echo '<option value="">Erro ao carregar turmas</option>';
        }
    } else {
        echo '<option value="">Usuário não logado</option>';
    }
    ?>
</select>

    </td>
</tr>


                    <tr>
                        <td><label for="periodo" class="form-label">Período:</label></td>
                        <td>
                            <select class="form-select form-select-sm" id="periodo" name="periodo" required>
                                <?php foreach ($bimestres as $bimestre): ?>
                                    <option value="<?= htmlspecialchars($bimestre['id']) ?>">
                                        <?= htmlspecialchars($bimestre['nome']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td><label for="data_inicial" class="form-label">Data Inicial:</label></td>
                        <td><input type="date" class="form-control" id="data_inicial" name="data_inicial" required></td>
                    </tr>
                    <tr>
                        <td><label for="data_final" class="form-label">Data Final:</label></td>
                        <td><input type="date" class="form-control" id="data_final" name="data_final" required></td>
                    </tr>
                    <tr>
                        <td colspan="2" class="text-center"><strong>Dias da Semana:</strong></td>
                    </tr>

                    <?php
                    $dias_da_semana = [
                        'segunda' => 'Segunda-feira:',
                        'terca' => 'Terça-feira:',
                        'quarta' => 'Quarta-feira:',
                        'quinta' => 'Quinta-feira:',
                        'sexta' => 'Sexta-feira:',
                        'sabado' => 'Sábado:'
                    ];
                    foreach ($dias_da_semana as $dia => $rotulo): ?>
                        <tr>
                            <td><label for="<?= $dia ?>" class="form-label"><?= $rotulo ?></label></td>
                            <td>
                                <input type="number" class="form-control" id="<?= $dia ?>" name="<?= $dia ?>" min="0" value="0">
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <table class="table table-bordered custom-table">
                <tfoot>
                    <tr>
                        <td colspan="2" class="text-end">
                            <button type="submit" class="btn btn-primary">Registrar Aulas</button>
                            <a href="listar_aula.php" class="btn btn-secondary me-2">Cancelar</a>  
                        </td>
                    </tr>
                </tfoot>
            </table>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
      // Inicializa o tooltip
      document.addEventListener('DOMContentLoaded', function () {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });

    
    </script>
</body>
</html>
