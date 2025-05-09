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


<div class="modal-dialog modal-dialog-centered modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 titulo_modal ">
                        <?php 
                            echo 'DOCUMENTOS DE: '.$pessoa[0]['nome'];
                        ?>                        
                    </h1>                                      
                </div>
                <div class="modal-body m-5">
                    <form id="formAlterarGrupo" action="<?=$base;?>pessoa/addDocumento" method="post"  enctype="multipart/form-data" autocomplete="off">
                        
                    <input type="hidden" name="idPessoa" value="<?=$_SESSION['idPessoa'];?>"></input>
                    
                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label fw-bold" >Tipo de Documento</label>
                            <div class="col-sm-10">
                             <input type="text" class="form-control" name="title" required></input>
                            </div>
                        </div>  
                        <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">Buscar arquivo</label>
                                <div class="col-sm-10">                               
                                <input type="file" class="form-control" id="documento" name="documento" value="">
                                </div>                          
                            </div>
                        <hr>   
                        <div class="mb-3 row  d-flex justify-content-end me-1">
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
</div>
</div>
</main>
<?php $render('footer');?>
