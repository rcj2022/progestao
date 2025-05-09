<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit();
}

try {
    // Conectar ao banco de dados usando PDO
    include 'config.php';

    // Configura o PDO para lançar exceções em caso de erro
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Recupera o ID do usuário da sessão
    $usuarioId = $_SESSION['usuario_id'];

    // Consulta para buscar o nome do usuário e o nome da escola associada diretamente da tabela 'usuarios'
    $sql = "SELECT u.nome AS nome_usuario, e.nome AS nome_escola 
            FROM usuarios u
            JOIN escola e ON u.escola_id = e.id
            WHERE u.id = :usuario_id";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':usuario_id', $usuarioId, PDO::PARAM_INT);
    $stmt->execute();

    // Busca os resultados
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

    // Se encontrar os dados, armazena nas variáveis
    if ($resultado) {
        $nomeUsuario = $resultado['nome_usuario'];
        $nomeEscola = $resultado['nome_escola'];
    } else {
        $nomeUsuario = "Usuário Desconhecido";
        $nomeEscola = "Escola Desconhecida";
    }
} catch (PDOException $e) {
    die("Erro no banco de dados: " . $e->getMessage());
} finally {
    $pdo = null;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel do professor</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome para ícones -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .sidebar {
            width: 250px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background-color: rgb(43, 84, 25);
            color: white;
            overflow-y: auto;
            transition: width 0.3s;
        }

        .sidebar.collapsed {
            width: 60px;
        }

        .sidebar .nav-link {
            color: white;
            padding: 10px 15px;
            display: flex;
            align-items: center;
            white-space: nowrap;
        }

        .sidebar .nav-link:hover {
            background-color: rgb(40, 171, 108);
        }

        .sidebar .nav-link i {
            margin-right: 10px;
            font-size: 1.2rem;
        }

        .sidebar.collapsed .nav-link span {
            display: none;
        }

        #sidebarToggle {
            font-size: 24px;
            cursor: pointer;
            background: none;
            border: none;
            padding: 10px;
        }

        .main-content {
            margin-left: 250px;
            padding: 20px;
            transition: margin-left 0.3s;
            padding-top: 80px; /* Compensa a altura da navbar */
        }

        .main-content.collapsed {
            margin-left: 60px;
        }

        .navbar {
            position: fixed;
            top: 0;
            width: 100%; /* Ocupa toda a largura da tela */
            z-index: 1000;
            height: 60px;
            background-color: rgb(43, 84, 25); /* Cor de fundo da navbar */
        }

        .submenu {
            margin-left: 20px;
            display: none;
        }

        .submenu .nav-link {
            padding: 8px 15px;
        }

        .nav-item.has-submenu > .nav-link {
            position: relative;
        }

        .nav-item.has-submenu > .nav-link::after {
            content: '\f107';
            font-family: 'Font Awesome 5 Free';
            font-weight: 900;
            position: absolute;
            right: 15px;
            transition: transform 0.3s;
        }

        .nav-item.has-submenu.open > .nav-link::after {
            transform: rotate(180deg);
        }

        .sidebar.collapsed .submenu {
            display: none !important;
        }

        .user-name {
            margin-left: auto;
            margin-right: 20px;
            color: white;
            font-weight: bold;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-name a {
            color: white;
            text-decoration: none;
            transition: color 0.3s;
        }

        .user-name a:hover {
            color: #ff4444;
        }

        .calendar {
            margin-top: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        .calendar-table {
            width: auto;
            border-collapse: collapse;
        }

        .calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .calendar-header button {
            background: none;
            border: none;
            font-size: 30px;
            cursor: pointer;
        }

        .calendar-table {
            width: 60%;
            border-collapse: collapse;
        }

        .calendar-table th, .calendar-table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }

        .calendar-table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .calendar-table td {
            height: 50px;
        }

        .calendar-table td:hover {
            background-color: #f9f9f9;
            cursor: pointer;
        }

        .highlight-day {
            background-color: rgb(52, 151, 63);
            color: white;
            font-weight: bold;
            border-radius: 4px;
        }

        .highlight-day-blue {
            background-color: #add8e6;
            color: black;
            font-weight: bold;
            border-radius: 4px;
        }

        .calendar-header button {
            background: none;
            border: none;
            font-size: 30px;
            cursor: pointer;
            padding: 1px;
            margin: 0 15px;
        }

        /* Responsividade para tablets */
        @media (max-width: 768px) {
            .sidebar {
                width: 60px;
            }
            @media (max-width: 768px) {
    .user-name {
        font-size: 12px;
        gap: 5px;
        margin-right: 5px;
    }
}

            .sidebar .nav-link span {
                display: none;
            }

            .main-content {
                margin-left: 60px;
            }

            .calendar {
                margin-left: 60px;
            }

            .calendar-table {
                width: 90%;
            }
        }

        /* Responsividade para celulares */
        @media (max-width: 480px) {
            .sidebar {
                width: 200px;
            }
         @media (max-width: 480px) {
    .user-name {
        font-size: 5px;
        gap: 0px;
        margin-right: 5px; /* Aumenta o recuo para a direita */
        margin-top: -90px; /* Mantém o ajuste para subir o elemento */
    }
}

@media (max-width: 480px) {
    .navbar-brand {
        font-size: 14px; /* Reduz o tamanho da fonte */
        margin-left: 5px; /* Diminui a margem esquerda */
    }
}
@media (max-width: 480px) {
    .navbar-brand {
        font-size: 14px; 
        margin-left: auto;
        margin-right: auto;
        display: block;
        text-align: center;
    }
}

      /* Estilos para telas pequenas */
 @media (max-width: 768px) {
            .table-responsive {
                overflow-x: auto;
            }       

            .sidebar .nav-link i {
                margin-right: 0;
            }

            .main-content {
                margin-left: 50px;
            }

            .calendar {
                margin-left: 100px;
            }

            .calendar-table {
                width: 20px;
            }

            .calendar-header button {
                font-size: 20px;
            }

            .calendar-table th, .calendar-table td {
                padding: 8px;
            }

            .user-name {
    font-size: 14px; /* Aumentado para melhor visibilidade */
    margin-left: auto;
    margin-right: 10px;
    color: white;
    font-weight: bold;
    display: flex;
    align-items: center;
    gap: 8px;
}
        }
        

 }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <ul class="nav flex-column p-3">
            <!-- Logo da Escola -->
            <div class="logo-escola">
            <img src="logo.png" alt="Logo da Escola" style="width: 100%; max-width: 150px; display: block; margin: 40px auto 0 auto;">
</div>
            <hr style="border border-4">

            <li class="nav-item has-submenu">
                <a class="nav-link" href="#">
                    <i class="fas fa-chalkboard-teacher"></i>
                    <span>Aulas</span>
                </a>
                <ul class="submenu">
                    <li class="nav-item">
                        <a class="nav-link" href="lanca_aula.php">Lançar aulas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="listar_aula">Listar aulas</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item has-submenu">
                <a class="nav-link" href="#">
                    <i class="fas fa-calendar-check"></i>
                    <span>Notas</span>
                </a>
                <ul class="submenu">
                    <li class="nav-item">
                        <a class="nav-link" href="nota1bi.php">Lançar notas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="listar_notas.php">Listar notas</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item has-submenu">
                <a class="nav-link" href="#">
                    <i class="fas fa-calendar-check"></i>
                    <span>Frequências</span>
                </a>
                <ul class="submenu">
                    <li class="nav-item">
                        <a class="nav-link" href="frequencia_mensal.php">Frequência Mensal</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="listar_chamada.php">Listar Chamada</a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-sm navbar-dark bg-success">
        <div class="container-fluid">
            <button class="btn" id="sidebarToggle">
                <i class="fas fa-bars" id="toggleIcon"></i>
            </button>
            <a class="navbar-brand ms-3" href="#"><strong><?php echo htmlspecialchars($nomeEscola); ?></strong></a>
          
            <span class="user-name" id="userName">
                <div class="user-profile">
                    <img id="user-photo" alt="Foto do Usuário" class="user-photo">
                </div>
                <style>
                    .user-photo {
                        width: 40px; /* Tamanho da foto */
                        height: 40px; 
                        border-radius: 50%; /* Deixa a imagem redonda */
                        object-fit: cover; /* Garante o ajuste da imagem */
                        border: 2px solid #fff; /* Borda opcional */
                        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Sombra sutil */
                    }
                </style>
                <?php echo htmlspecialchars($nomeUsuario); ?> <!-- Nome do usuário -->
                <a href="#" onclick="confirmarSaida()" title="Sair"> 
                    <i class="fas fa-sign-out-alt"></i> <!-- Ícone de sair -->
                </a>
            </span>
        </div>
    </nav>

    <!-- Conteúdo Principal -->
    <div class="main-content" id="mainContent">
        <!-- Calendário Dinâmico -->
        <div class="calendar">
            <div class="calendar-header">
                <button id="prev-month">&lt;</button>
                <h3 id="current-month-year" class="month-year"></h3>
                <button id="next-month">&gt;</button>
            </div>
            <table class="calendar-table">
                <thead>
                    <tr>
                        <th>Dom</th>
                        <th>Seg</th>
                        <th>Ter</th>
                        <th>Qua</th>
                        <th>Qui</th>
                        <th>Sex</th>
                        <th>Sáb</th>
                    </tr>
                </thead>
                <tbody id="calendar-body">
                    <!-- Os dias do mês serão preenchidos aqui dinamicamente -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Alternar sidebar
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            const toggleIcon = document.getElementById('toggleIcon');

            // Alternar a classe 'collapsed' na sidebar e no conteúdo principal
            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('collapsed');

            // Verificar se a sidebar está recolhida
            if (sidebar.classList.contains('collapsed')) {
                toggleIcon.classList.remove('fa-bars'); // Remove o ícone de menu hambúrguer
                toggleIcon.classList.add('fa-times'); // Adiciona o ícone de "X" (fechar)
                // Fechar submenus
                document.querySelectorAll('.submenu').forEach(function(sub) {
                    sub.style.display = 'none';
                    sub.parentElement.classList.remove('open');
                });
            } else {
                toggleIcon.classList.remove('fa-times'); // Remove o ícone de "X"
                toggleIcon.classList.add('fa-bars'); // Adiciona o ícone de menu hambúrguer
            }
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

        // Função para confirmar saída
        function confirmarSaida() {
            const confirmacao = confirm("Você realmente deseja sair?");
            if (confirmacao) {
                window.location.href = "acesso.php"; // Redireciona para a página de logout
            }
        }

        // URL da foto do usuário (pode ser obtida de uma API ou do backend)
        const userPhotoUrl = 'logo.png'; // Substitua pela URL real da imagem

        // Define a imagem no elemento HTML
        const userPhotoElement = document.getElementById('user-photo');
        userPhotoElement.src = userPhotoUrl;

        // Exibe uma imagem padrão caso a foto do usuário não carregue
        userPhotoElement.onerror = () => {
            userPhotoElement.src = 'https://via.placeholder.com/40?text=User';
        };

        // Função para gerar o calendário
        const highlightedDates = [
            { day: 3, month: 1, color: 'blue' },  // 03 de fevereiro (mês 2 → 1) - Azul
            { day: 15, month: 1 }, // 15 de fevereiro (mês 2 → 1)
            { day: 22, month: 2 }, // 22 de março (mês 3 → 2)
            { day: 5, month: 3 },  // 05 de abril (mês 4 → 3)
            { day: 17, month: 3, color: 'blue' }, // 17 de abril (mês 4 → 3)
            { day: 22, month: 3, color: 'blue' }, // 22 de abril (mês 4 → 3)
            { day: 24, month: 4 }, // 24 de maio (mês 5 → 4)
            { day: 7, month: 5 },  // 07 de junho (mês 6 → 5)
            { day: 27, month: 5,  color: 'blue' }, // 27 de junho (mês 6 → 5)
            { day: 21, month: 5 }, // 21 de junho (mês 6 → 5)
            { day: 1, month: 7, color: 'blue' },  // 01 de agosto (mês 8 → 7)
            { day: 16, month: 7 }, // 16 de agosto (mês 8 → 7)
            { day: 20, month: 8 }, // 20 de setembro (mês 9 → 8)
            { day: 6, month: 9,  color: 'blue' },  // 06 de outubro (mês 10 → 9)
            { day: 7, month: 9,  color: 'blue' },  // 07 de outubro (mês 10 → 9)
            { day: 11, month: 9 }, // 11 de outubro (mês 10 → 9)
            { day: 22, month: 10 }, // 22 de novembro (mês 11 → 10)
            { day: 16, month: 11, color: 'blue' }  // 16 de dezembro (mês 12 → 11)
        ];

        function renderCalendar(date) {
            const calendarBody = document.getElementById('calendar-body');
            const currentMonthYear = document.getElementById('current-month-year');

            // Limpa o conteúdo anterior
            calendarBody.innerHTML = '';

            // Define o mês e o ano atual
            const month = date.getMonth();
            const year = date.getFullYear();

            // Exibe o mês e o ano no cabeçalho
            currentMonthYear.textContent = new Intl.DateTimeFormat('pt-BR', { month: 'short', year: 'numeric' }).format(date);

            // Obtém o primeiro dia do mês e o número de dias no mês
            const firstDay = new Date(year, month, 1);
            const lastDay = new Date(year, month + 1, 0);
            const daysInMonth = lastDay.getDate();
            const startDay = firstDay.getDay();

            // Preenche os dias do mês na tabela
            let day = 1;
            for (let i = 0; i < 6; i++) { // 6 semanas no máximo
                const row = document.createElement('tr');
                for (let j = 0; j < 7; j++) { // 7 dias na semana
                    const cell = document.createElement('td');
                    if (i === 0 && j < startDay) {
                        // Dias vazios antes do primeiro dia do mês
                        cell.textContent = '';
                    } else if (day > daysInMonth) {
                        // Dias vazios após o último dia do mês
                        cell.textContent = '';
                    } else {
                        // Dias do mês
                        cell.textContent = day;

                        // Verifica se o dia atual está na lista de datas a serem destacadas
                        const highlightedDate = highlightedDates.find(d => d.day === day && d.month === month);
                        if (highlightedDate) {
                            if (highlightedDate.color === 'blue') {
                                cell.classList.add('highlight-day-blue'); // Azul
                            } else {
                                cell.classList.add('highlight-day'); // Verde
                            }
                        }

                        day++;
                    }
                    row.appendChild(cell);
                }
                calendarBody.appendChild(row);
                if (day > daysInMonth) break; // Para de preencher após o último dia do mês
            }
        }

        // Navegação do calendário
        let currentDate = new Date(); // Data atual
        renderCalendar(currentDate); // Renderiza o calendário inicial

        document.getElementById('prev-month').addEventListener('click', () => {
            currentDate.setMonth(currentDate.getMonth() - 1); // Mês anterior
            renderCalendar(currentDate);
        });

        document.getElementById('next-month').addEventListener('click', () => {
            currentDate.setMonth(currentDate.getMonth() + 1); // Próximo mês
            renderCalendar(currentDate);
        });
        
    </script>
</body>
</html>