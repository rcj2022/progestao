<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php'); // Redireciona para a página de login
    exit();
}

try {
    // Conectar ao banco de dados usando PDO
    include 'config.php'; // Certifique-se de que este arquivo configura a conexão $pdo

    // Configura o PDO para lançar exceções em caso de erro
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Recupera o ID do usuário da sessão
    $usuarioId = $_SESSION['usuario_id'];

    // Consulta para buscar o nome do usuário, tipo e nome da escola
    $sql = "
        SELECT u.nome, u.tipo, e.nome as nome_escola, e.id as escola_id
        FROM usuarios u
        LEFT JOIN vinculo_esc_usuario v ON u.id = v.usuario_id
        LEFT JOIN escola e ON v.escola_id = e.id
        WHERE u.id = :id
        
    ";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $usuarioId, PDO::PARAM_INT); // Vincula o parâmetro
    $stmt->execute();

    // Busca o resultado
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC); // Busca a linha como um array associativo

    // Verifica se o usuário foi encontrado
    if ($usuario) {
        $nomeUsuario = $usuario['nome']; // Nome do usuário
        $tipoUsuario = $usuario['tipo']; // Tipo de usuário (ex: "secretario", "admin", etc.)
        $nomeEscola = $usuario['nome_escola']; // Nome da escola
        $escolaId = $usuario['escola_id']; // ID da escola
    } else {
        $nomeUsuario = "Usuário Desconhecido"; // Caso o usuário não seja encontrado
        $tipoUsuario = "Tipo Desconhecido"; // Tipo padrão caso o usuário não seja encontrado
        $nomeEscola = "Escola Desconhecida"; // Nome padrão caso a escola não seja encontrada
        $escolaId = null; // ID da escola como nulo
    }
} catch (PDOException $e) {
    // Trata erros de conexão ou consulta
    die("Erro no banco de dados: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel do Secretário</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome para ícones -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="painel_secretario.css">


    <style>
    .user-name {
    white-space: nowrap; /* Impede a quebra de linha */
    margin-left: -100px; /* Ajusta para alinhar à esquerda sem ficar colado */
    padding-right: 50px; /* Ajusta o espaçamento entre o nome e o botão de saída */
    display: flex;
    align-items: center;
    gap: 15px; /* Adiciona espaçamento entre o ícone, o nome e o botão de saída */
}

 </style>
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <ul class="nav flex-column p-3">
            <!-- Item principal -->
            <li class="nav-item has-submenu">
                <a class="nav-link" href="#">
                    <i class="fas fa-home"></i>
                    <span>Usuários</span>
                </a>
                <!-- Submenu -->
                <ul class="submenu nav flex-column ps-3">
                    <li class="nav-item">
                        <a class="nav-link" href="frm_user.php">
                            <i class="fas fa-plus"></i>
                            <span>Cadastrar Usuário</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="listar_user.php">
                            <i class="fas fa-list"></i>
                            <span>Listar Usuários</span>
                        </a>
                    </li>
                </ul>
            </li>
        
            <li class="nav-item has-submenu">
                <a class="nav-link" href="#">
                    <i class="fas fa-chalkboard-teacher"></i>
                    <span>Turmas</span>
                </a>
                <ul class="submenu nav flex-column ps-3">
                    <li class="nav-item">
                        <a class="nav-link" href="#" id="cadastrarTurmaLink">
                            <i class="fas fa-plus"></i>
                            <span>Cadastrar</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="listar_turmas.php">
                            <i class="fas fa-list"></i>
                            <span>Listar Turmas</span>
                        </a>
                    </li>
                   
                    <li class="nav-item">
                        <a class="nav-link" href="listar_matriculas.php">
                            <i class="fas fa-list"></i>
                            <span>Listar Matrícula</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="frm_vinculos.php">
                            <i class="fas fa-list"></i>
                            <span>Matricular</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item has-submenu">
                <a class="nav-link" href="#">
                    <i class="fas fa-calendar-check"></i>
                    <span>Alunos</span>
                </a>
                <ul class="submenu nav flex-column ps-3">
                    <li class="nav-item">
                        <a class="nav-link" href="frm_aluno.php">
                            <i class="fas fa-plus"></i>
                            <span>Cadastrar</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="listar_alunos.php">
                            <i class="fas fa-list"></i>
                            <span>Listar Alunos</span>
                        </a>
                    </li>
                </ul>
            </li>

            <!---professores--->
            <li class="nav-item has-submenu">
                <a class="nav-link" href="#">
                    <i class="fas fa-calendar-check"></i>
                    <span>Professor</span>
                </a>
                <ul class="submenu nav flex-column ps-3">
                    <li class="nav-item">
                        <a class="nav-link" href="frm_professor.php">
                            <i class="fas fa-plus"></i>
                            <span>Cadastrar</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="listar_professor.php">
                            <i class="fas fa-list"></i>
                            <span>Listar Professores</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item has-submenu">
                <a class="nav-link" href="#">
                    <i class="fas fa-calendar-check"></i>
                    <span>Disciplinas</span>
                </a>
                <ul class="submenu nav flex-column ps-3">
                    <li class="nav-item">
                        <a class="nav-link" href="#" id="cadastrarDisciplinaLink">
                            <i class="fas fa-plus"></i>
                            <span>Cadastro</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="listar_disciplinas.php">
                            <i class="fas fa-list"></i>
                            <span>Listar Disciplina</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="frm_disc_individual.php">
                            <i class="fas fa-list"></i>
                            <span>Disciplinas</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="disciplina_listar.php">
                            <i class="fas fa-list"></i>
                            <span>Disciplinas Listar</span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>

<!-- Navbar -->
<!-- Navbar -->

<nav class="navbar navbar-expand-lg navbar-white bg-success fixed-top">
    <div class="container-fluid">
        <button class="btn" id="sidebarToggle">
            <i class="fas fa-bars"></i>
        </button>
        <a class="navbar-brand fw-bold text-white custom-indent" href="#">
            <?php echo htmlspecialchars($nomeEscola ?? 'Escola Desconhecida'); ?>
        </a>
        <span class="user-name text-white" id="userName">
            <i class="fas fa-user-circle"></i>
            <?php echo htmlspecialchars(strtoupper($nomeUsuario)); ?>
            <a href="acesso.php" title="Sair" class="text-warning">
                <i class="fas fa-sign-out-alt"></i>
            </a>
        </span>
    </div>
</nav>



<!-- Conteúdo Principal -->
<div class="main-content" id="mainContent">
    <?php
    // Verifica se o ID da escola foi encontrado
    if ($escolaId) {
        try {
            // Consulta para buscar as turmas da escola do usuário logado (sem repetição)
            $sqlTurmas = "
                SELECT DISTINCT t.id, t.nome
                FROM vinculos v
                JOIN turma t ON v.turma_id = t.id
                WHERE v.escola_id = :escola_id
                 ORDER BY t.nome
            ";
            $stmtTurmas = $pdo->prepare($sqlTurmas);
            $stmtTurmas->bindParam(':escola_id', $escolaId, PDO::PARAM_INT);
            $stmtTurmas->execute();
            $turmas = $stmtTurmas->fetchAll(PDO::FETCH_ASSOC);

            if (!empty($turmas)) {
                echo '<div class="row justify-content-start offset-md-0" style="margin-top: 40px;">'; 
                foreach ($turmas as $turma) {
                    echo '
                    <div class="col-md-3 mb-4"> <!-- Reduz o tamanho da coluna -->
                        <div class="card shadow-lg" style="width: 18rem;"> <!-- Define um tamanho fixo para o card -->
                            <div class="card-body text-center"> <!-- Centraliza o texto -->
                                <h5 class="text-muted fw-bold">Turma</h5> <!-- Adiciona o título "Turma" -->
                                <h5 class="card-title">' . htmlspecialchars($turma['nome']) . '</h5>
                               
                                <!-- Botões de ação (detalhe) -->
                                <div class="d-flex justify-content-center"> 
                                    <a href="obter_alunos_turma.php?turma_id=' . $turma['id'] . '" 
                                       class="btn btn-warning btn-sm me-2">
                                       Detalhe
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>';
                }
                echo '</div>';
            } else {
                echo '<div class="alert alert-info" role="alert">Nenhuma turma cadastrada para esta escola.</div>';
            }
        } catch (PDOException $e) {
            die("Erro ao buscar turmas: " . $e->getMessage());
        }
    } else {
        echo '<div class="alert alert-warning" role="alert">Escola não encontrada para o usuário logado.</div>';
    }
    ?>
</div>

 <!-- Modal de Cadastro de Turma -->
<!-- Modal -->
<div class="modal fade" id="cadastroTurmaModal" tabindex="-1" aria-labelledby="cadastroTurmaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cadastroTurmaModalLabel">Cadastro de Turma em Lote</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="cadastrar_turma.php" method="POST">
                    <div class="mb-3">
                        <label for="turma" class="form-label">Turma: *</label>
                        <input type="text" class="form-control" id="turma" name="turma" required>
                    </div>
                    <div class="mb-3">
                        <label for="turno" class="form-label">Turno: *</label>
                        <select class="form-select" id="turno" name="turno" required>
                            <option value="NOITE">NOITE</option>
                            <option value="MANHA">MANHÃ</option>
                            <option value="TARDE">TARDE</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="quantidade_alunos" class="form-label">Quantidade máxima de alunos: *</label>
                        <input type="number" class="form-control" id="quantidade_alunos" name="quantidade_alunos" required>
                    </div>
                    <div class="mb-3">
                        <label for="exercicio" class="form-label">Exercício: *</label>
                        <input type="text" class="form-control" id="exercicio" name="exercicio" required>
                    </div>
                    <div class="mb-3">
                        <label for="curso" class="form-label">Curso: *</label>
                        <input type="text" class="form-control" id="curso" name="curso" required>
                    </div>
                    <div class="mb-3">
                        <label for="etapa" class="form-label">Etapa: *</label>
                        <select class="form-select" id="etapa" name="etapa" required>
                            <option value="1º ANO">1º ANO</option>
                            <option value="2º ANO">2º ANO</option>
                            <option value="3º ANO">3º ANO</option>
                            <option value="3º ANO">4º ANO</option>
                            <option value="3º ANO">5º ANO</option>
                            <option value="3º ANO">6º ANO</option>
                            <option value="3º ANO">7º ANO</option>
                            <option value="3º ANO">8º ANO</option>
                            <option value="3º ANO">9º ANO</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-primary">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Alternar sidebar
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('collapsed');
            document.getElementById('mainContent').classList.toggle('collapsed');
            document.querySelector('.navbar').classList.toggle('collapsed');
        });

        // Alternar submenus
        document.querySelectorAll('.nav-item.has-submenu > .nav-link').forEach(function(item) {
            item.addEventListener('click', function(e) {
                e.preventDefault(); // Evita o comportamento padrão do link
                const parent = item.parentElement;
                const submenu = parent.querySelector('.submenu');

                // Fecha todos os submenus abertos
                document.querySelectorAll('.submenu').forEach(function(sub) {
                    if (sub !== submenu && sub.style.display === 'block') {
                        sub.style.display = 'none';
                        sub.parentElement.classList.remove('open');
                    }
                });

                // Alterna o submenu atual
                if (submenu.style.display === 'block') {
                    submenu.style.display = 'none';
                    parent.classList.remove('open');
                } else {
                    submenu.style.display = 'block';
                    parent.classList.add('open');
                }
            });
        });

        // Fechar submenus ao recolher a sidebar
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            if (document.getElementById('sidebar').classList.contains('collapsed')) {
                document.querySelectorAll('.submenu').forEach(function(sub) {
                    sub.style.display = 'none';
                    sub.parentElement.classList.remove('open');
                });
            }
        });

        // Abrir o modal de cadastro de turmas
        document.getElementById('cadastrarTurmaLink').addEventListener('click', function(event) {
            event.preventDefault(); // Evita o comportamento padrão do link
            const modal = new bootstrap.Modal(document.getElementById('cadastroTurmaModal'));
            modal.show(); // Abre o modal
        });

        // Abrir o modal de cadastro de disciplinas
        document.getElementById('cadastrarDisciplinaLink').addEventListener('click', function(event) {
            event.preventDefault(); // Evita o comportamento padrão do link
            const modal = new bootstrap.Modal(document.getElementById('cadastroDisciplinaModal'));
            modal.show(); // Abre o modal
        });

        
    </script>
</body>
</html>