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
              <div class="col-sm-6"><h3 class="mb-0">Unidade/Escolar</h3></div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                  <li class="breadcrumb-item"><a href="<?=$base;?>">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Escola</li>
                </ol>
              </div>
            </div>
        <div class="container mt-4">
          <div class="row">
              <div class="col-md-12">
                  <h1 class="text-center">
                      <span class="float-end mb-2">
                          <a href="#" onclick="modalAddPessoa()" class="btn btn-success" title="Adicionar Novo Usuário">
                              <i class="bi bi-person-plus"></i> Adicionar Unidade
                          </a>
                      </span>
                      <hr>
                  </h1>
                  <div class="table-responsive">
      <table class="table table-hover">
          <thead>
              <tr>                
                  <th scope="col">Nome Unidade</th>
                  <th scope="col">Email</th>                                   
                  <th scope="col">Comandos</th>
              </tr>
          </thead>
          <tbody>
              <?php                  
              foreach ($unidades as $unidade) { ?>
                  <tr>                      
                      <td><?= $unidade['nomeUnidade']; ?></td>
                      <td><?= $unidade['emailUnidade']; ?></td>                     
                                    
                      <td class="d-flex justify-content-end">
                        <div class="btn-group" role="group" aria-label="Botões de comando">
                            
                            
                            
                                                    
                        <button type="button" class="btn btn-danger"> <a title="excluir dados" href="#" onclick="ExcluirEscola(<?=$unidade['id'];?>)" class="text-light">
                              <i class="bi bi-trash"></i>
                            </a></button>
                        </div>
                            
                      </td>
                  </tr>
              <?php }?>
          </tbody>
      </table>
      
  </div>
              </div>
          </div>
      </div>
       
</main>

<!--Inicio do Modal para adicionar pessoas-->
<div class="modal fade" id="addUsuarioModal" tabindex="-1" aria-labelledby="staticBackdropLabel">
        <div class="modal-dialog modal-dialog-centered modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-secondary">
                    <h1 class="modal-title fs-5 titulo_modal text-white">Inserir Registro</h1>
                    <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body m-5">
                    <form id="formUsuario" action="unidade/add" method="POST"  autocomplete="off">

                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label fw-bold">Nome da Unidade</label>
                            <div class="col-sm-10">                               
                                <input type="text" name="nome" class="form-control text-uppercase" />
                            </div>                          
                        </div>


                        
                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label fw-bold">Zona</label>
                            <div class="col-sm-10">
                            <select name="zona" class="form-select" required>
                                    <option selected value="">Selecione</option>
                                    <?php
                                    $pessoa = array(
                                        "Urbana",
                                        "Rural"
                                    );
                                    foreach ($pessoa as $pessoa) {
                                        echo "<option value='$pessoa'>$pessoa</option>";
                                    }
                                    ?>
                                </select>

                        </div>
                            
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label fw-bold">INEP</label>
                            <div class="col-sm-10">
                            <input type="text" name="inep" class="form-control" 
                                 inputmode="numeric" pattern="\d*" 
                             oninput="this.value = this.value.replace(/[^0-9]/g, '')" />
                            </div>    
                        </div>

                      
                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label fw-bold">CNPJ</label>
                            <div class="col-sm-10">
                                <input type="text" name="cnpj" class="form-control" />    
                            </div>
                            
                        </div>
                       

                     
                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label fw-bold">E-mail</label>
                            <div class="col-sm-10">
                                <input type="text" name="email" class="form-control" />    
                            </div>                            
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label fw-bold">Celular</label>
                            <div class="col-sm-10">
                                <input type="text" name="celular" id="celular" maxlength=15 class="form-control" />    
                            </div>                            
                        </div>   
                        <hr>   
                        <div class="mb-3 row  d-flex justify-content-end me-1">
                            <button type="submit" class="btn btn-secondary col-sm-2" >
                            <i class="bi bi-floppy"></i>
                                Salvar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
</div>
<!--Fim do Modal para adicionar pessoas-->
<?php
    if($_SESSION['flash']!=""){

        $msg = ($_SESSION['flash']);?>
        
        <script type="text/javascript">
            function alert(type, title, msg) {
                Swal.fire({        
                icon: type,
                title: title,
                text: msg,
                showConfirmButton: false,
                timer: 2000
        });
            }
            alert('<?=$msg['type'];?>', '<?= $msg['title'];?>', '<?= $msg['text'];?>');
        </script>';
    <?php
        $_SESSION['flash']="";
    }
?>


<?php $render('footer');?>

