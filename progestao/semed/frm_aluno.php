<?php
session_start();
include 'config.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    die("Erro: Usuário não autenticado.");
}

// Recupera o ID do usuário logado
$usuario_id = $_SESSION['usuario_id'];

// Recupera o ID da escola do usuário logado
try {
    // Consulta para buscar o escola_id na tabela vinculo_esc_usuario
    $sql_escola = "SELECT escola_id FROM vinculo_esc_usuario WHERE usuario_id = :usuario_id";
    $stmt_escola = $pdo->prepare($sql_escola);
    $stmt_escola->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
    $stmt_escola->execute();
    $escola_id = $stmt_escola->fetchColumn();

    if (!$escola_id) {
        die("Erro: Escola não encontrada para o usuário logado.");
    }
} catch (PDOException $e) {
    die("Erro ao buscar escola do usuário: " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $nome_social = $_POST['nome_social'];
    $tipo_pessoa = $_POST['tipo_pessoa'];
    $data_nascimento = date('Y-m-d', strtotime(str_replace('/', '-', $_POST['data_nascimento']))); // Formata para MySQL
    $sexo = $_POST['sexo'];
    $mae = $_POST['mae'];
    $pai = $_POST['pai'];
    $cpf_cnpj = $_POST['cpf_cnpj'];
    $email = $_POST['email'];
    $celular = $_POST['celular'];

    // 🔎 Verifica se o e-mail ou CPF/CNPJ já estão cadastrados
    $sql_check = "SELECT COUNT(*) FROM alunos WHERE email = :email OR cpf_cnpj = :cpf_cnpj";
    $stmt_check = $pdo->prepare($sql_check);
    $stmt_check->bindParam(':email', $email);
    $stmt_check->bindParam(':cpf_cnpj', $cpf_cnpj);
    $stmt_check->execute();
    $exists = $stmt_check->fetchColumn();

    if ($exists > 0) {
        echo "<div class='alert alert-warning'>Erro: E-mail ou CPF/CNPJ já cadastrados!</div>";
    } else {
        // Insere no banco de dados se não houver duplicata
        $sql_insert = "INSERT INTO alunos (nome, nome_social, tipo_pessoa, data_nascimento, sexo, mae, pai, cpf_cnpj, email, celular, escola_id)
                       VALUES (:nome, :nome_social, :tipo_pessoa, :data_nascimento, :sexo, :mae, :pai, :cpf_cnpj, :email, :celular, :escola_id)";

        $stmt_insert = $pdo->prepare($sql_insert);
        $stmt_insert->bindParam(':nome', $nome);
        $stmt_insert->bindParam(':nome_social', $nome_social);
        $stmt_insert->bindParam(':tipo_pessoa', $tipo_pessoa);
        $stmt_insert->bindParam(':data_nascimento', $data_nascimento);
        $stmt_insert->bindParam(':sexo', $sexo);
        $stmt_insert->bindParam(':mae', $mae);
        $stmt_insert->bindParam(':pai', $pai);
        $stmt_insert->bindParam(':cpf_cnpj', $cpf_cnpj);
        $stmt_insert->bindParam(':email', $email);
        $stmt_insert->bindParam(':celular', $celular);
        $stmt_insert->bindParam(':escola_id', $escola_id, PDO::PARAM_INT); // Adiciona o ID da escola

        if ($stmt_insert->execute()) {
            echo "<div class='alert alert-success'>Cadastro realizado com sucesso!</div>";
        } else {
            echo "<div class='alert alert-danger'>Erro ao cadastrar.</div>";
        }
    }
}

// Fecha a conexão (opcional, pois o PDO fecha automaticamente ao fim do script)
$pdo = null;
?>



<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Aluno</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-3 border bg-success text-white">
    <h2 class="mb-4">Registro/Aluno</h2>
</div>
<div class="container mt-3 border mb-2">
    <div class="row">
        <div class="col-md-6">
            <?php if (isset($mensagem)) echo $mensagem; ?>
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label fw-bold" style="text-transform: uppercase;">Nome Completo</label>
                    <input type="text" name="nome" class="form-control" style="text-transform: uppercase;" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold" style="text-transform: uppercase;">Nome Social</label>
                    <input type="text" name="nome_social" class="form-control" style="text-transform: uppercase;">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold" style="text-transform: uppercase;">Tipo de Pessoa</label>
                    <select name="tipo_pessoa" class="form-select">
                        <option value="Física">Física</option>
                        <option value="Jurídica">Jurídica</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold" style="text-transform: uppercase;">Data de Nascimento</label>
                    <input type="text" name="data_nascimento" class="form-control" id="dataNascimento" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold" style="text-transform: uppercase;">Sexo</label>
                    <select name="sexo" class="form-select">
                        <option value="Masculino">Masculino</option>
                        <option value="Feminino">Feminino</option>
                        <option value="Outro">Outro</option>
                    </select>
                </div>
        </div>
        <div class="col-md-6 border">
            <div class="mb-3">
                <label class="form-label fw-bold" style="text-transform: uppercase;">Nome da Mãe</label>
                <input type="text" name="mae" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold" style="text-transform: uppercase;">Nome do Pai</label>
                <input type="text" name="pai" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold" style="text-transform: uppercase;">CPF/CNPJ</label>
                <input type="text" name="cpf_cnpj" class="form-control" id="cpfCnpj" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold" style="text-transform: uppercase;">E-mail</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold" style="text-transform: uppercase;">Celular</label>
                <input type="text" name="celular" class="form-control" id="celular" required>
            </div>
            <div class="container mt-5 border mb-4 d-flex justify-content-end">
                <button type="submit" class="btn btn-primary mt-3 mb-2 me-2">Cadastrar</button>
                <a href="painel_secretario.php" class="btn btn-secondary mt-3 mb-2">Voltar</a>
            </div>
            </form>
        </div>
    </div>
</div>

<!-- Scripts para máscaras -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
<script>
    $(document).ready(function() {
        console.log("Scripts carregados corretamente!");
        $('#dataNascimento').mask('00/00/0000'); // Máscara para data de nascimento
        $('#cpfCnpj').mask('000.000.000-00', {reverse: true}); // Máscara para CPF/CNPJ
        $('#celular').mask('(00) 00000-0000'); // Máscara para celular
    });
</script>
</body>
</html>