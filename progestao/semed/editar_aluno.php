<?php
// Inclui o arquivo de configuração do banco de dados
include 'config.php';

// Verifica se o ID do aluno foi passado na URL
if (!isset($_GET['id'])) {
    header("Location: listar_alunos.php");
    exit();
}

$id = $_GET['id'];

// Busca os dados do aluno no banco de dados
$sql = "SELECT id, nome, nome_social, tipo_pessoa, data_nascimento, sexo, mae, pai, cpf_cnpj, email, celular FROM alunos WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$aluno = $stmt->fetch(PDO::FETCH_ASSOC);

// Verifica se o aluno existe
if (!$aluno) {
    header("Location: listar_alunos.php");
    exit();
}

// Processa o formulário de edição
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $nome_social = $_POST['nome_social'];
    $tipo_pessoa = $_POST['tipo_pessoa'];
    $data_nascimento = !empty($_POST['data_nascimento']) ? date('Y-m-d', strtotime(str_replace('/', '-', $_POST['data_nascimento']))) : null;
    $sexo = $_POST['sexo'];
    $mae = $_POST['mae'];
    $pai = $_POST['pai'];
    $cpf_cnpj = $_POST['cpf_cnpj'];
    $email = $_POST['email'];
    $celular = $_POST['celular'];

    // Verifica se o CPF/CNPJ já está cadastrado para outro aluno
    $sql_check_cpf = "SELECT COUNT(*) FROM alunos WHERE cpf_cnpj = :cpf_cnpj AND id != :id";
    $stmt_check_cpf = $pdo->prepare($sql_check_cpf);
    $stmt_check_cpf->bindParam(':cpf_cnpj', $cpf_cnpj);
    $stmt_check_cpf->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt_check_cpf->execute();
    $cpf_exists = $stmt_check_cpf->fetchColumn();

    if ($cpf_exists > 0) {
        // Emite uma mensagem de erro se o CPF/CNPJ já estiver em uso
        echo "<div class='alert alert-danger'>Erro: O CPF/CNPJ informado já está cadastrado para outro aluno.</div>";
    } else {
        // Atualiza os dados do aluno no banco de dados
        $sql_update = "UPDATE alunos SET 
            nome = :nome, 
            nome_social = :nome_social, 
            tipo_pessoa = :tipo_pessoa, 
            data_nascimento = :data_nascimento, 
            sexo = :sexo, 
            mae = :mae, 
            pai = :pai, 
            cpf_cnpj = :cpf_cnpj, 
            email = :email, 
            celular = :celular 
            WHERE id = :id";
        
        $stmt_update = $pdo->prepare($sql_update);
        $stmt_update->bindParam(':nome', $nome);
        $stmt_update->bindParam(':nome_social', $nome_social);
        $stmt_update->bindParam(':tipo_pessoa', $tipo_pessoa);
        $stmt_update->bindParam(':data_nascimento', $data_nascimento);
        $stmt_update->bindParam(':sexo', $sexo);
        $stmt_update->bindParam(':mae', $mae);
        $stmt_update->bindParam(':pai', $pai);
        $stmt_update->bindParam(':cpf_cnpj', $cpf_cnpj);
        $stmt_update->bindParam(':email', $email);
        $stmt_update->bindParam(':celular', $celular);
        $stmt_update->bindParam(':id', $id, PDO::PARAM_INT);

        if ($stmt_update->execute()) {
            header("Location: listar_alunos.php");
            exit();
        } else {
            echo "<div class='alert alert-danger'>Erro ao atualizar os dados do aluno.</div>";
            var_dump($stmt_update->errorInfo()); // Exibe erros do banco de dados para depuração
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Aluno</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center mb-4">Editar Aluno</h1>
    <form method="POST">
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <td class="fw-bold">Nome Completo</td>
                    <td><input type="text" name="nome" class="form-control" value="<?= htmlspecialchars($aluno['nome']) ?>" required></td>
                </tr>
                <tr>
                    <td class="fw-bold">Nome Social</td>
                    <td><input type="text" name="nome_social" class="form-control" value="<?= htmlspecialchars($aluno['nome_social']) ?>"></td>
                </tr>
                <tr>
                    <td class="fw-bold">Tipo de Pessoa</td>
                    <td>
                        <select name="tipo_pessoa" class="form-select">
                            <option value="Física" <?= ($aluno['tipo_pessoa'] == 'Física') ? 'selected' : '' ?>>Física</option>
                            <option value="Jurídica" <?= ($aluno['tipo_pessoa'] == 'Jurídica') ? 'selected' : '' ?>>Jurídica</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="fw-bold">Data de Nascimento</td>
                    <td><input type="text" name="data_nascimento" class="form-control" value="<?= date('d/m/Y', strtotime($aluno['data_nascimento'])) ?>" required></td>
                </tr>
                <tr>
                    <td class="fw-bold">Sexo</td>
                    <td>
                        <select name="sexo" class="form-select">
                            <option value="Masculino" <?= ($aluno['sexo'] == 'Masculino') ? 'selected' : '' ?>>Masculino</option>
                            <option value="Feminino" <?= ($aluno['sexo'] == 'Feminino') ? 'selected' : '' ?>>Feminino</option>
                            <option value="Outro" <?= ($aluno['sexo'] == 'Outro') ? 'selected' : '' ?>>Outro</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="fw-bold">Nome da Mãe</td>
                    <td><input type="text" name="mae" class="form-control" value="<?= htmlspecialchars($aluno['mae']) ?>"></td>
                </tr>
                <tr>
                    <td class="fw-bold">Nome do Pai</td>
                    <td><input type="text" name="pai" class="form-control" value="<?= htmlspecialchars($aluno['pai']) ?>"></td>
                </tr>
                <tr>
                    <td class="fw-bold">CPF/CNPJ</td>
                    <td><input type="text" name="cpf_cnpj" class="form-control" value="<?= htmlspecialchars($aluno['cpf_cnpj']) ?>" required></td>
                </tr>
                <tr>
                    <td class="fw-bold">E-mail</td>
                    <td><input type="email" name="email" class="form-control" value="<?= htmlspecialchars($aluno['email']) ?>" required></td>
                </tr>
                <tr>
                    <td class="fw-bold">Celular</td>
                    <td><input type="text" name="celular" class="form-control" value="<?= htmlspecialchars($aluno['celular']) ?>" required></td>
                </tr>
            </tbody>
        </table>
        <div class="d-flex justify-content-end mt-4">
            <button type="submit" class="btn btn-success me-2">Atualizar</button>
            <a href="painel_secretario.php" class="btn btn-secondary">Voltar</a>
        </div>
    </form>
</div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script>
        $(document).ready(function() {
            $('input[name="data_nascimento"]').mask('00/00/0000');
            $('input[name="cpf_cnpj"]').mask('000.000.000-00', {reverse: true});
            $('input[name="celular"]').mask('(00) 00000-0000');
        });
    </script>
</body>
</html>
