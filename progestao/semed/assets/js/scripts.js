// Função para buscar o nome do usuário
async function fetchUserName() {
    try {
        const response = await fetch('get_user_name.php');
        const data = await response.json();
        if (data.nome) {
            document.getElementById('userName').textContent = data.nome;
        } else {
            document.getElementById('userName').textContent = 'Usuário não encontrado';
        }
    } catch (error) {
        console.error('Erro ao buscar o nome do usuário:', error);
        document.getElementById('userName').textContent = 'Erro ao carregar';
    }
}

// Busca o nome do usuário ao carregar a página
fetchUserName();

// Alternar sidebar
document.getElementById('sidebarToggle').addEventListener('click', function() {
    document.getElementById('sidebar').classList.toggle('collapsed');
    document.getElementById('mainContent').classList.toggle('collapsed');
    document.querySelector('.navbar').classList.toggle('collapsed');
});

// Alternar submenus
document.querySelectorAll('.nav-item.has-submenu > .nav-link').forEach(function(item) {
    item.addEventListener('click', function(e) {
        e.preventDefault();
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