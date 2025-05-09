<?php
session_start(); // Inicia a sessão

// Definir tempo de expiração da sessão (30 minutos)
$inativo = 1800; // 1800 segundos = 30 minutos

// Verificar se o tempo de inatividade foi excedido
if (isset($_SESSION['ultimo_acesso']) && (time() - $_SESSION['ultimo_acesso'] > $inativo)) {
    // Destruir a sessão e redirecionar para o login
    session_unset(); // Remove todas as variáveis de sessão
    session_destroy(); // Destrói a sessão
    header('Location: acesso.php');
    exit();
}

// Atualizar o tempo do último acesso
$_SESSION['ultimo_acesso'] = time();

// Verificar se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    // Redirecionar para a página de login se o usuário não estiver logado
    header('Location: acesso.php');
    exit();
}

// Verificar o tipo de usuário (opcional)
$tipo_usuario = $_SESSION['tipo_usuario'];
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciamento de Usuários</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="painel_principal.css">
    
</head>
<body>
   <!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-success fixed-top">
    <div class="container-fluid">
        <!-- Logo -->
        <a class="navbar-brand" href="#">
            <img src="logo.png" alt="Logo" width="50" height="50" class="d-inline-block align-text-top">
        </a>

        <!-- Título -->
        <h4 class="text-white mb-0">SECRETARIA MUNICIPAL DE EDUCAÇÃO</h4>

        <!-- Botão "Sair" -->
        <div class="ms-auto d-flex align-items-center">
            <a href="acesso.php" class="btn btn-danger me-3">
                <i class="fas fa-sign-out-alt"></i> Sair
            </a>
            <button class="btn" id="sidebarToggle">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </div>
</nav>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <ul class="nav flex-column p-3">
            <li class="nav-item">
                <a class="nav-link" href="#" data-submenu="usuarioSubmenu">
                    <i class="fas fa-user"></i>
                    <span>SEMED</span>
                </a>
                <ul class="nav flex-column submenu" id="usuarioSubmenu">
                    <li class="nav-item">
                        <a class="nav-link" href="#" id="cadastroUsuario">
                            <i class="fas fa-chevron-right"></i>
                            <span>Cadastrar Usuário</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" id="listarUsuarios">
                            <i class="fas fa-chevron-right"></i>
                            <span>Listar Usuário</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
    <a class="nav-link" href="#" data-submenu="escolasSubmenu">
    <i class="fa-solid fa-school"></i>
        <span>ESCOLAS</span>
    </a>
    <ul class="nav flex-column submenu" id="escolasSubmenu">
        <li class="nav-item">
            <a class="nav-link" href="#" id="cadastrarEscola">
                <i class="fas fa-chevron-right"></i>
                <span>Cadastrar Escolas</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#" id="listarEscolas">
                <i class="fas fa-chevron-right"></i>
                <span>Listar Escolas</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="frm_vinculo_esc.php" id="">
                <i class="fas fa-chevron-right"></i>
                <span>Vincular Escolas</span>
            </a>
        </li>
    </ul>
</li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content p-4" id="mainContent">
        <h1>Bem-vindo ao Sistema</h1>
        <p>Gerencie seus usuários de forma fácil.</p>
    </div>

    <!-- Modal de Cadastro de Usuário -->
    <div class="modal fade" id="cadastroModal" tabindex="-1" aria-labelledby="cadastroModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cadastroModalLabel">Cadastrar Usuário</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="cadastroForm">
                        <div class="mb-3">
                            <label for="nome" class="form-label">Nome:</label>
                            <input type="text" class="form-control" id="nome" name="nome" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email:</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="senha" class="form-label">Senha:</label>
                            <input type="password" class="form-control" id="senha" name="senha" required>
                        </div>
                        <div class="mb-3">
                            <label for="tipo" class="form-label">Tipo de Usuário:</label>
                            <select class="form-select" id="tipo" name="tipo" required>
                                <option value="admin">Administrador</option>
                                <option value="secretario">Secretário</option>
                                <option value="professor">Professor</option>
                                <option value="aluno">Aluno</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success">Salvar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Edição de Usuário -->
    <div class="modal fade" id="editarUsuarioModal" tabindex="-1" aria-labelledby="editarUsuarioModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editarUsuarioModalLabel">Editar Usuário</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editarUsuarioForm">
                        <input type="hidden" id="editarUsuarioId" name="id"> <!-- Campo oculto para armazenar o ID do usuário -->
                        <div class="mb-3">
                            <label for="editarNome" class="form-label">Nome:</label>
                            <input type="text" class="form-control" id="editarNome" name="nome" required>
                        </div>
                        <div class="mb-3">
                            <label for="editarEmail" class="form-label">Email:</label>
                            <input type="email" class="form-control" id="editarEmail" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="editarSenha" class="form-label">Senha:</label>
                            <input type="password" class="form-control" id="editarSenha" name="senha">
                            <small class="text-muted">Deixe em branco para manter a senha atual.</small>
                        </div>
                        <div class="mb-3">
                            <label for="editarTipo" class="form-label">Tipo de Usuário:</label>
                            <select class="form-select" id="editarTipo" name="tipo" required>
                                <option value="admin">Administrador</option>
                                <option value="secretario">Secretário</option>
                                <option value="professor">Professor</option>
                                <option value="aluno">Aluno</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success">Salvar Alterações</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Erro (E-mail já cadastrado) -->
    <div class="modal fade" id="emailExistenteModal" tabindex="-1" aria-labelledby="emailExistenteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="emailExistenteModalLabel">Erro</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Este e-mail já está cadastrado.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Listar Usuários -->
    <div class="modal fade" id="listarUsuariosModal" tabindex="-1" aria-labelledby="listarUsuariosModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="listarUsuariosModalLabel">USUÁRIOS CADASTRADOS</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Email</th>
                                <th>Tipo</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody id="usuariosTableBody">
                            <!-- Dados dos usuários serão carregados aqui -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
        <!-- Modal de Cadastro de Escola -->
<div class="modal fade" id="cadastroEscolaModal" tabindex="-1" aria-labelledby="cadastroEscolaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cadastroEscolaModalLabel">Cadastrar Escola</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="cadastroEscolaForm">
                    <div class="mb-3">
                        <label for="nomeEscola" class="form-label">Nome da Escola:</label>
                        <input type="text" class="form-control" style="text-transform: uppercase;" id="nomeEscola" name="nome" required>
                    </div>
                    <div class="mb-3">
                        <label for="enderecoEscola" class="form-label">Endereço:</label>
                        <input type="text" class="form-control" style="text-transform: uppercase;" id="enderecoEscola" name="endereco">
                    </div>
                    <div class="mb-3">
                        <label for="telefoneEscola" class="form-label">Telefone:</label>
                        <input type="text" class="form-control" style="text-transform: uppercase;" id="telefoneEscola" name="telefone">
                    </div>
                    <div class="mb-3">
                        <label for="emailEscola" class="form-label">Email:</label>
                        <input type="email" class="form-control" style="text-transform: uppercase;" id="emailEscola" name="email">
                    </div>
                    <div class="mb-3">
                        <label for="dataFundacaoEscola" class="form-label">Data de Fundação:</label>
                        <input type="date" class="form-control" id="dataFundacaoEscola" name="data_fundacao">
                    </div>
                    <div class="mb-3">
                        <label for="ativoEscola" class="form-label">Ativo:</label>
                        <select class="form-select" id="ativoEscola" name="ativo">
                            <option value="1">Sim</option>
                            <option value="0">Não</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success">Salvar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Edição de Escola -->
<div class="modal fade" id="editarEscolaModal" tabindex="-1" aria-labelledby="editarEscolaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editarEscolaModalLabel">Editar Escola</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editarEscolaForm">
                    <input type="hidden" id="editarEscolaId" name="id"> <!-- Campo oculto para armazenar o ID da escola -->
                    <div class="mb-3">
                        <label for="editarNomeEscola" class="form-label" style="text-transform: uppercase;">Nome da Escola:</label>
                        <input type="text" class="form-control" id="editarNomeEscola" name="nome" required>
                    </div>
                    <div class="mb-3">
                        <label for="editarEnderecoEscola" class="form-label">Endereço:</label>
                        <input type="text" class="form-control" id="editarEnderecoEscola" name="endereco">
                    </div>
                    <div class="mb-3">
                        <label for="editarTelefoneEscola" class="form-label">Telefone:</label>
                        <input type="text" class="form-control" id="editarTelefoneEscola" name="telefone">
                    </div>
                    <div class="mb-3">
                        <label for="editarEmailEscola" class="form-label">Email:</label>
                        <input type="email" class="form-control" id="editarEmailEscola" name="email">
                    </div>
                    <div class="mb-3">
                        <label for="editarDataFundacaoEscola" class="form-label">Data de Fundação:</label>
                        <input type="date" class="form-control" id="editarDataFundacaoEscola" name="data_fundacao">
                    </div>
                    <div class="mb-3">
                        <label for="editarAtivoEscola" class="form-label">Ativo:</label>
                        <select class="form-select" id="editarAtivoEscola" name="ativo">
                            <option value="1">Sim</option>
                            <option value="0">Não</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success">Salvar Alterações</button>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="listarEscolasModal" tabindex="-1" aria-labelledby="listarEscolasModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl"> <!-- Use modal-xl para aumentar a largura -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="listarEscolasModalLabel">ESCOLAS CADASTRADAS</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive"> <!-- Adicione esta div para tornar a tabela responsiva -->
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Endereço</th>
                                <th>Telefone</th>
                                <th>Email</th>
                                <th>Data de Fundação</th>
                                <th>Ativo</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody id="escolasTableBody">
                            <!-- Dados das escolas serão carregados aqui -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Alternar sidebar
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('collapsed');
            document.getElementById('mainContent').classList.toggle('collapsed');
        });

        // Alternar submenus
        document.querySelectorAll('.sidebar .nav-link[data-submenu]').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const submenu = document.getElementById(this.getAttribute('data-submenu'));
                submenu.classList.toggle('show');
            });
        });

        // Abrir modal de cadastro de usuário
        document.getElementById("cadastroUsuario").addEventListener("click", function (e) {
            e.preventDefault();
            new bootstrap.Modal(document.getElementById("cadastroModal")).show();
        });

        // Enviar formulário de cadastro via AJAX
        document.getElementById("cadastroForm").addEventListener("submit", function (e) {
            e.preventDefault(); // Impede o envio padrão do formulário

            const formData = new FormData(this); // Captura os dados do formulário

            fetch('cad_user.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'error') {
                    // Exibir modal de erro (e-mail já cadastrado)
                    new bootstrap.Modal(document.getElementById("emailExistenteModal")).show();
                } else if (data.status === 'success') {
                    // Fechar o modal de cadastro e exibir mensagem de sucesso
                    alert(data.message); // Ou use outro modal para sucesso
                    new bootstrap.Modal(document.getElementById("cadastroModal")).hide();
                }
            })
            .catch(error => console.error("Erro ao enviar formulário:", error));
        });

        // Abrir modal de listar usuários e carregar dados
        document.getElementById("listarUsuarios").addEventListener("click", function (e) {
            e.preventDefault();
            const modal = new bootstrap.Modal(document.getElementById("listarUsuariosModal"));
            modal.show();

            // Carregar dados dos usuários via AJAX
            fetch('listar_usuarios.php') // Arquivo PHP que retorna os usuários em JSON
                .then(response => response.json())
                .then(data => {
                    const tableBody = document.getElementById("usuariosTableBody");
                    tableBody.innerHTML = ""; // Limpa o conteúdo anterior

                    if (data.status === 'success') {
                        // Preenche a tabela com os dados dos usuários
                        data.data.forEach(usuario => {
                            const row = `
                                <tr>
                                    <td>${usuario.id}</td>
                                    <td>${usuario.nome}</td>
                                    <td>${usuario.email}</td>
                                    <td>${usuario.tipo}</td>
                                    <td>
                                        <button class="btn btn-primary btn-sm" onclick="editarUsuario(${usuario.id})">
                                            <i class="fas fa-edit"></i> 
                                        </button>
                                        <button class="btn btn-danger btn-sm" onclick="excluirUsuario(${usuario.id})">
                                            <i class="fas fa-trash"></i> 
                                        </button>
                                    </td>
                                </tr>
                            `;
                            tableBody.innerHTML += row;
                        });
                    } else {
                        // Exibe uma mensagem de erro caso não haja usuários
                        tableBody.innerHTML = `
                            <tr>
                                <td colspan="5" class="text-center">${data.message}</td>
                            </tr>
                        `;
                    }
                })
                .catch(error => console.error("Erro ao carregar usuários:", error));
        });

        // Função para editar usuário
        function editarUsuario(id) {
            // Fechar o modal de listar usuários
            bootstrap.Modal.getInstance(document.getElementById("listarUsuariosModal")).hide();

            // Buscar os dados do usuário via AJAX
            fetch(`buscar_usuario.php?id=${id}`)
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        // Preencher o formulário de edição com os dados do usuário
                        document.getElementById('editarUsuarioId').value = data.usuario.id;
                        document.getElementById('editarNome').value = data.usuario.nome;
                        document.getElementById('editarEmail').value = data.usuario.email;
                        document.getElementById('editarTipo').value = data.usuario.tipo;

                        // Abrir o modal de edição
                        new bootstrap.Modal(document.getElementById("editarUsuarioModal")).show();
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => console.error("Erro ao buscar usuário:", error));
        }

        // Enviar formulário de edição via AJAX
        document.getElementById("editarUsuarioForm").addEventListener("submit", function (e) {
            e.preventDefault(); // Impede o envio padrão do formulário

            const formData = new FormData(this); // Captura os dados do formulário

            fetch('editar_usuario.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    alert(data.message);
                    // Fechar o modal de edição
                    bootstrap.Modal.getInstance(document.getElementById("editarUsuarioModal")).hide();
                    // Recarregar a lista de usuários
                    document.getElementById("listarUsuarios").click();
                } else {
                    alert(data.message);
                }
            })
            .catch(error => console.error("Erro ao editar usuário:", error));
        });

        // Função para excluir usuário
        function excluirUsuario(id) {
            if (confirm("Tem certeza que deseja excluir este usuário?")) {
                fetch(`excluir_usuario.php?id=${id}`, {
                    method: 'DELETE'
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        alert(data.message);
                        // Recarregar a lista de usuários após a exclusão
                        document.getElementById("listarUsuarios").click();
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => console.error("Erro ao excluir usuário:", error));
            }
        }

        // Abrir modal de cadastro de escola
        document.getElementById("cadastrarEscola").addEventListener("click", function (e) {
    e.preventDefault();
    new bootstrap.Modal(document.getElementById("cadastroEscolaModal")).show();
});

    // Enviar formulário de cadastro de escola via AJAX
document.getElementById("cadastroEscolaForm").addEventListener("submit", function (e) {
    e.preventDefault(); // Impede o envio padrão do formulário

    const formData = new FormData(this); // Captura os dados do formulário

    fetch('cad_escola.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'error') {
            // Exibir modal de erro (e-mail já cadastrado ou outro erro)
            alert(data.message); // Ou use outro modal para exibir o erro
        } else if (data.status === 'success') {
            // Fechar o modal de cadastro e exibir mensagem de sucesso
            alert(data.message); // Ou use outro modal para sucesso
            new bootstrap.Modal(document.getElementById("cadastroEscolaModal")).hide();
        }
    })
    .catch(error => console.error("Erro ao enviar formulário:", error));
});

// Função para formatar a data no formato brasileiro (dd/mm/aaaa)
function formatarData(data) {
    const date = new Date(data); // Converte a string para um objeto Date
    const dia = String(date.getDate()).padStart(2, '0'); // Dia com dois dígitos
    const mes = String(date.getMonth() + 1).padStart(2, '0'); // Mês com dois dígitos
    const ano = date.getFullYear(); // Ano com quatro dígitos
    return `${dia}/${mes}/${ano}`; // Retorna a data formatada
}

// Abrir modal de listar escolas e carregar dados
document.getElementById("listarEscolas").addEventListener("click", function (e) {
    e.preventDefault();
    const modal = new bootstrap.Modal(document.getElementById("listarEscolasModal"));
    modal.show();

    // Carregar dados das escolas via AJAX
    fetch('listar_escola.php')
        .then(response => response.json())
        .then(data => {
            const tableBody = document.getElementById("escolasTableBody");
            tableBody.innerHTML = ""; // Limpa o conteúdo anterior

            if (data.status === 'success') {
                // Preenche a tabela com os dados das escolas
                data.data.forEach(escola => {
                    const dataFormatada = formatarData(escola.data_fundacao); // Formata a data
                    const row = `
                        <tr>
                            <td>${escola.id}</td>
                            <td>${escola.nome}</td>
                            <td>${escola.endereco}</td>
                            <td>${escola.telefone}</td>
                            <td>${escola.email}</td>
                            <td>${dataFormatada}</td> <!-- Data formatada -->
                            <td>${escola.ativo ? 'Sim' : 'Não'}</td>
                            <td>
                                <button class="btn btn-primary btn-sm d-inline me-2 mb-2" onclick="editarEscola(${escola.id})">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-danger btn-sm d-inline" onclick="excluirEscola(${escola.id})">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    `;
                    tableBody.innerHTML += row;
                });
            } else {
                // Exibe uma mensagem de erro caso não haja escolas
                tableBody.innerHTML = `
                    <tr>
                        <td colspan="8" class="text-center">${data.message}</td>
                    </tr>
                `;
            }
        })
        .catch(error => console.error("Erro ao carregar escolas:", error));
});
// Função para editar escola
function editarEscola(id) {
    // Fechar o modal de listar escolas
    bootstrap.Modal.getInstance(document.getElementById("listarEscolasModal")).hide();

    // Buscar os dados da escola via AJAX
    fetch(`buscar_escola.php?id=${id}`)
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                // Preencher o formulário de edição com os dados da escola
                document.getElementById('editarEscolaId').value = data.escola.id;
                document.getElementById('editarNomeEscola').value = data.escola.nome;
                document.getElementById('editarEnderecoEscola').value = data.escola.endereco;
                document.getElementById('editarTelefoneEscola').value = data.escola.telefone;
                document.getElementById('editarEmailEscola').value = data.escola.email;
                document.getElementById('editarDataFundacaoEscola').value = data.escola.data_fundacao;
                document.getElementById('editarAtivoEscola').value = data.escola.ativo;

                // Abrir o modal de edição
                new bootstrap.Modal(document.getElementById("editarEscolaModal")).show();
            } else {
                alert(data.message);
            }
        })
        .catch(error => console.error("Erro ao buscar escola:", error));
}

// Função para excluir escola
function excluirEscola(id) {
    if (confirm("Tem certeza que deseja excluir esta escola?")) {
        fetch(`excluir_escola.php?id=${id}`, {
            method: 'DELETE'
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                alert(data.message);
                // Recarregar a lista de escolas após a exclusão
                document.getElementById("listarEscolas").click();
            } else {
                alert(data.message);
            }
        })
        .catch(error => console.error("Erro ao excluir escola:", error));
    }
}

// Enviar formulário de edição de escola via AJAX
document.getElementById("editarEscolaForm").addEventListener("submit", function (e) {
    e.preventDefault(); // Impede o envio padrão do formulário

    const formData = new FormData(this); // Captura os dados do formulário

    fetch('editar_escola.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            alert(data.message);
            // Fechar o modal de edição
            bootstrap.Modal.getInstance(document.getElementById("editarEscolaModal")).hide();
            // Recarregar a lista de escolas
            document.getElementById("listarEscolas").click();
        } else {
            alert(data.message);
        }
    })
    .catch(error => console.error("Erro ao editar escola:", error));
});
    </script>
</body>
</html>