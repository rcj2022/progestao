<?php
include 'config.php'; // Arquivo de conexão com o banco de dados

// Query para buscar disciplinas com os nomes dos professores
$sql = "SELECT di.id, di.disciplina_id, t.nome AS turma, d.nome AS disciplina, 
               p.nome AS professor, di.tipo_disciplina, di.carga_horaria, 
               di.carga_horaria_semanal
        FROM disciplina_individual di
        JOIN turma t ON di.turma_id = t.id
        JOIN disciplinas d ON di.disciplina_id = d.id_disciplina
        JOIN usuarios p ON di.usuario_id = p.id  -- Verifique se 'usuario_id' é realmente a chave que se refere ao professor
        ORDER BY p.nome";  // Ordena pelo nome do professor

$result = $pdo->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Disciplinas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    <style>
        .container {
            max-width: 900px;
            margin-top: 30px;
        }
    </style>
</head>
<body class="bg-light">

    <div class="container">
        <h2 class="text-start">Vincular/Disciplinas</h2>
        <hr>
        <div class="d-flex justify-content-end my-3">
            <a href="frm_disc_individual.php" class="btn btn-primary px-4 py-2 shadow-lg me-2">
                <i class="bi bi-plus-lg"></i> Adicionar
            </a>
            <a href="painel_secretario.php" class="btn btn-secondary">Voltar</a>
        </div>

        <div class="card shadow">
            <div class="card-body">
                <table id="tabelaDisciplinas" class="table table-striped table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Turma</th>
                            <th>Disciplina</th>
                            <th>Professor</th>
                            <th>Tipo</th>
                            <th>Carga Horária</th>
                            <th>Semanal</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch(PDO::FETCH_ASSOC)): ?>
                        <tr>
                            <td><?php echo strtoupper(htmlspecialchars($row['turma'])); ?></td>
                            <td><?php echo htmlspecialchars($row['disciplina']); ?></td>
                            <td><?php echo htmlspecialchars($row['professor']); ?></td>
                            <td><?php echo htmlspecialchars($row['tipo_disciplina']); ?></td>
                            <td><?php echo $row['carga_horaria']; ?>h</td>
                            <td><?php echo $row['carga_horaria_semanal']; ?>h</td>
                            <td class="text-center">
                                <a href="editar_disc.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <a href="excluir_disciplina.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir?');">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#tabelaDisciplinas').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/pt-BR.json'
                }
            });
        });
    </script>

</body>
</html>
