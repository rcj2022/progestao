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
    <div class="row p-4">
        <div class="col-sm-6"><h3 class="mb-0">Pessoas / Programa Social</h3></div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-end"><li class="breadcrumb-item"><a href="<?=$base;?>">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">pessoas</li>
            </ol>
        </div>
    </div>
    <div class="container mt-2">
        <div class="modal-dialog modal-dialog-centered modal-dialog modal-xl">    
            <div class="modal-content">               
                <div class="modal-header">
                    <h1 class="modal-title fs-5 titulo_modal ">
                        <?php 
                            $nome = strtoupper($pessoa[0]['nome']);
                            echo $nome;
                        ?>                        
                    </h1>                                      
                </div>
            <div class="modal-body m-2">
            <hr> 
            <form id="formAlterarGrupo" action="<?=$base;?>pessoa/addPrograma" method="post"  enctype="multipart/form-data" autocomplete="off">
                <div class="checkbox-grid">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="opcao1" value="Bolsa Família" name="opcoes[]">
                            <label class="form-check-label" for="opcao1">
                                Bolsa Família
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="opcao2" value="Auxílio Gás"  name="opcoes[]">
                            <label class="form-check-label" for="opcao2">
                                Auxílio Gás
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="opcao3" value="Programa Criança Feliz" name="opcoes[]">
                            <label class="form-check-label" for="opcao3">
                                Programa Criança Feliz
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="opcao4" value="Bolsa Atleta"  name="opcoes[]">
                            <label class="form-check-label" for="opcao4">
                                Bolsa Atleta
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="opcao5"  value="Pé de meia"  name="opcoes[]">
                            <label class="form-check-label" for="opcao5">
                                Pé de meia
                            </label>
                        </div>                       
                </div> 
                <hr>                           
                <div class="mb-3 mt-4 row  d-flex justify-content-end me-1">
                   <a href="<?=$base;?>pessoa/editar/<?=$_SESSION['idPessoa'];?>" class="btn btn-outline-danger col-sm-2 me-2"><i class="bi bi-arrow-left-circle me-2"></i>Voltar</a>
                   <button type="submit" class="btn btn-outline-secondary col-sm-2" >
                       <i class="bi bi-floppy me-2"></i>
                                Adicionar
                    </button>
                </div>
            </form>
            </div>
        </div>
    </div>
</main>
<?php $render('footer');?>
