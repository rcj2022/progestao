    <?php

    $acesso = $_SESSION['user'];
    $nivel = $_SESSION['nivel'];

    if ($nivel == 'Administrador') {
        $render('header');
    } elseif($nivel == 'Professor') {
        $render('headerProfessor');
    }elseif($nivel == 'Secretaria'){
        $render('headerSecretaria');
    }elseif($nivel == 'Pedagogo'){
        $render('headerPedagogo');
    }elseif($nivel == 'Aluno'){
        $render('headerAluno');
    }
    ?>

    <main class="app-main">


    <div class="container mt-5">
        <h5>Cadastro/Escola</h5>
        <hr>
        <form action="<?=$base;?>escola/add" method="POST" enctype="multipart/form-data" autocomplete="off">
            <div class="row bg-light">
            <div class="col-sm-10">                               
    <img src="<?=$base."assets/img/avatar.jpg"?>" id="target" name="logo" class="form-control" style="width: 12rem; border-radius: 50%;" title="logo" value="avatar.jpg"/>
</div>

<div class="col-md-6 mb-3">
    <label>Logo da Escola:</label>
    <input type="file" class="form-control" id="logo" name="logo" onchange="carregarLogo()">
</div>



                <div class="col-md-6 mb-3">
                    <label>Marca D’água:</label>
                    <input type="file" name="marcaDagua" class="form-control">
                </div>
                <!-- Dados Institucionais -->
                <div class="col-md-6 mb-3">
                    <label>Nome da Unidade:</label>
                    <input type="text" name="nomeUnidade" class="form-control text-uppercase" required>
                </div>
                <div class="col-md-3 mb-3">
                    <label>Zona:</label>
                    <input type="text" name="zonaUnidade" class="form-control text-uppercase">
                </div>
                <div class="col-md-3 mb-3">
                    <label>Grupo:</label>
                    <input type="text" name="grupoUnidade" class="form-control">
                </div>
                <div class="col-md-4 mb-3">
                    <label>Código INEP:</label>
                    <input type="text" name="codigoInep" class="form-control">
                </div>
                <div class="col-md-4 mb-3">
                    <label>CNPJ:</label>
                    <input type="text" name="cnpjUnidade" class="form-control">
                </div>
                <div class="col-md-4 mb-3">
                    <label>Telefone:</label>
                    <input type="text" name="telefoneUnidade" class="form-control">
                </div>
                <div class="col-md-6 mb-3">
                    <label>Email:</label>
                    <input type="email" name="emailUnidade" class="form-control">
                </div>
                <div class="col-md-6 mb-3">
                    <label>Ato de Criação:</label>
                    <input type="text" name="atoDeCriacao" class="form-control">
                </div>
                <div class="col-md-6 mb-3">
                    <label>Decreto de Criação:</label>
                    <input type="text" name="decretoCriacao" class="form-control">
                </div>
                <div class="col-md-6 mb-3">
                    <label>Decreto de Autorização:</label>
                    <input type="text" name="decretoAutorizacao" class="form-control">
                </div>

                <!-- Endereço -->
                <div class="col-md-4 mb-3">
                    <label>CEP:</label>
                    <input type="text" name="cep" class="form-control">
                </div>
                <div class="col-md-8 mb-3">
                    <label>Endereço:</label>
                    <input type="text" name="endereco" class="form-control">
                </div>
                <div class="col-md-2 mb-3">
                    <label>Número:</label>
                    <input type="text" name="numero" class="form-control">
                </div>
                <div class="col-md-4 mb-3">
                    <label>Bairro:</label>
                    <input type="text" name="bairro" class="form-control">
                </div>
                <div class="col-md-3 mb-3">
                    <label>Cidade:</label>
                    <input type="text" name="cidade" class="form-control">
                </div>
                <div class="col-md-1 mb-3">
                    <label>UF:</label>
                    <input type="text" name="uf" class="form-control">
                </div>
                <div class="col-md-2 mb-3">
                    <label>UF Nome:</label>
                    <input type="text" name="ufNome" class="form-control">
                </div>
                <div class="col-md-4 mb-3">
                    <label>País:</label>
                    <input type="text" name="pais" class="form-control">
                </div>
                <hr>
                <!-- Equipe Gestora -->
                <h5>Equipe Gestora</h5>
                <div class="col-md-6 mb-3">
                    <label>Diretor:</label>
                    <input type="text" name="diretorUnidade" class="form-control">
                </div>
                <div class="col-md-3 mb-3">
                    <label>CPF Diretor:</label>
                    <input type="text" name="cpfDiretor" class="form-control">
                </div>
                <div class="col-md-3 mb-3">
                    <label>Decreto Diretor:</label>
                    <input type="text" name="decretoDiretor" class="form-control">
                </div>

                <div class="col-md-6 mb-3">
                    <label>Secretário:</label>
                    <input type="text" name="secretarioUnidade" class="form-control">
                </div>
                <div class="col-md-3 mb-3">
                    <label>CPF Secretário:</label>
                    <input type="text" name="cpfSecretario" class="form-control">
                </div>
                <div class="col-md-3 mb-3">
                    <label>Decreto Secretário:</label>
                    <input type="text" name="decretoSecretario" class="form-control">
                </div>

                <div class="col-md-6 mb-3">
                    <label>Especialista:</label>
                    <input type="text" name="especialistaUnidade" class="form-control">
                </div>
                <div class="col-md-3 mb-3">
                    <label>CPF Especialista:</label>
                    <input type="text" name="cpfEspecialista" class="form-control">
                </div>

                <!-- Uploads -->
            

                <!-- Botão -->
                <div class="col-12 mt-3 text-end">
                <a href="<?=$base;?>/unidadeEscolar"  class="btn btn-outline-danger col-sm-2 me-2" > <i class="bi bi-arrow-left-circle me-2"></i>Cancelar</a>
        <button type="submit" class="btn btn-primary mb-2">Cadastrar Escola</button>
    </div>

            </div>
        </form>
    </div>



    </main>
    <?php $render('footer'); ?> 

    <script>
function carregarLogo() {
    const input = document.getElementById('logo');
    const img = document.getElementById('target');

    if (input.files && input.files[0]) {
        const reader = new FileReader();

        reader.onload = function (e) {
            img.src = e.target.result;
        }

        reader.readAsDataURL(input.files[0]); // Converte o arquivo em base64 e carrega na imagem
    }
}
</script>