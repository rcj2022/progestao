<?php
session_start(); // Inicia a sessão

include 'config.php'; // Certifique-se de que o arquivo config.php está configurado para PDO

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    die("Usuário não está logado.");
}

// Verifica se há uma mensagem de erro na URL
$erro_msg = '';
if (isset($_GET['erro']) && $_GET['erro'] == 1) {
    $erro_msg = 'Aulas já lançadas para essa turma, período e data!';
}

$usuario_id = $_SESSION['usuario_id']; // Recupera o ID do usuário logado

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Valida e sanitiza os dados do formulário
    $turma = isset($_POST['turma']) ? trim($_POST['turma']) : '';
    $periodo = isset($_POST['periodo']) ? trim($_POST['periodo']) : '';
    $data_inicial = isset($_POST['data_inicial']) ? trim($_POST['data_inicial']) : '';
    $data_final = isset($_POST['data_final']) ? trim($_POST['data_final']) : '';

    // Inicializa os valores das aulas
    $dias_da_semana = ['segunda', 'terca', 'quarta', 'quinta', 'sexta', 'sabado'];
    $dias_em_numeros = [
        'segunda' => 1,
        'terca' => 2,
        'quarta' => 3,
        'quinta' => 4,
        'sexta' => 5,
        'sabado' => 6
    ];

    // Preenche as quantidades para cada dia da semana
    $quantidades = [];
    foreach ($dias_da_semana as $dia) {
        $quantidades[$dia] = !empty($_POST[$dia]) ? (int)$_POST[$dia] : 0;
    }

    // Gera as datas entre a data inicial e final
    $periodo_datas = new DatePeriod(
        new DateTime($data_inicial),
        new DateInterval('P1D'),
        (new DateTime($data_final))->modify('+1 day')
    );

    // Prepara os dados para inserção
    $insercoes = [];
    foreach ($periodo_datas as $data) {
        $dia_semana = (int)$data->format('N');

        foreach ($dias_da_semana as $dia) {
            if ($dia_semana === $dias_em_numeros[$dia] && $quantidades[$dia] > 0) {
                $insercoes[] = [
                    'data' => $data->format('Y-m-d'),
                    'turma' => $turma,
                    'periodo' => $periodo,
                    'dia' => $dia,
                    'quantidade' => $quantidades[$dia],
                    'usuario_id' => $usuario_id
                ];
            }
        }
    }

    // Insere os dados no banco
    foreach ($insercoes as $insercao) {
        // Verifica se já existe uma aula para a mesma data, turma e bimestre
        $sql_check = "
            SELECT 1 
            FROM aulas 
            WHERE turma_id = :turma_id 
            AND periodo_id = :periodo_id 
            AND dia = :dia
        ";
        $stmt_check = $pdo->prepare($sql_check);
        $stmt_check->bindValue(':turma_id', $insercao['turma'], PDO::PARAM_STR);
        $stmt_check->bindValue(':periodo_id', $insercao['periodo'], PDO::PARAM_STR);
        $stmt_check->bindValue(':dia', $insercao['data'], PDO::PARAM_STR);
        
        $stmt_check->execute();

        if ($stmt_check->fetchColumn()) {
            // Se encontrar um registro, significa que já existe a combinação de turma, período e data
            // Exibe a mensagem de erro e não faz a inserção
            $erro_msg = 'Aulas já lançadas para essa turma, período e data!';
            header("Location: lanca_aula.php?erro=1");
            exit; // Interrompe o script, pois não é necessário continuar
        }

        // Se não encontrar registros duplicados, faz a inserção
        $sql = "
            INSERT INTO aulas (turma_id, periodo_id, dia, quantidade, usuario_id) 
            VALUES (:turma_id, :periodo_id, :dia, :quantidade, :usuario_id)
        ";

        $stmt = $pdo->prepare($sql);
        if (!$stmt) {
            die("Erro ao preparar a consulta: " . $pdo->errorInfo()[2]);
        }

        $stmt->bindValue(':turma_id', $insercao['turma'], PDO::PARAM_STR);
        $stmt->bindValue(':periodo_id', $insercao['periodo'], PDO::PARAM_STR);
        $stmt->bindValue(':dia', $insercao['data'], PDO::PARAM_STR);
        $stmt->bindValue(':quantidade', $insercao['quantidade'], PDO::PARAM_INT);
        $stmt->bindValue(':usuario_id', $insercao['usuario_id'], PDO::PARAM_INT);

        if (!$stmt->execute()) {
            die("Erro ao registrar aula para {$insercao['data']}: " . $stmt->errorInfo()[2]);
        }
    }

    // Se tudo ocorrer bem, redireciona para a lista de aulas
    if (empty($erro_msg)) {
        echo "Aulas registradas com sucesso!";
        header("Location: listar_aula.php");
        exit;
    }
}

$pdo = null; // Fecha a conexão com o banco de dados
?>