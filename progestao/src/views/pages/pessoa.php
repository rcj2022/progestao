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
              <div class="col-sm-6"><h3 class="mb-0">Pessoas</h3></div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                  <li class="breadcrumb-item"><a href="<?=$base;?>">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Pessoas</li>
                </ol>
              </div>
            </div>
  <!-- Tabela que lista as pessoas cadastradas no sistema -->          
        <div class="container mt-4">
          <div class="row">
              <div class="col-md-12">
                  <h1 class="text-center">
                      <span class="float-end mb-2">
                          <a href="#" onclick="modalAddPessoa()" class="btn btn-success" title="Adicionar Novo Pessoa">
                              <i class="bi bi-person-plus"></i> Adicionar Pessoa
                          </a>
                      </span>
                      <hr>
                  </h1>
                  <div class="table-responsive">
                    <table class="table table-hover" id="tabela_usuario">
                        <thead>
                            <tr>                
                                <th scope="col">Nome</th>
                                <th scope="col">CPF/CNPJ</th>                  
                                <th scope="col">Grupo</th>
                                <th scope="col">Comandos</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php                  
                            foreach ($pessoa as $pessoa) { ?>
                                <tr>                      
                                    <td><?= $pessoa->getNome(); ?></td>
                                    <td><?= $pessoa->getCpf(); ?></td>                     
                                    <td><?= $pessoa->getNomeGrupo(); ?></td>                     
                                    <td class="d-flex justify-content-end">
                                        
                                    <?php if ($pessoa->getNomeGrupo() == 'Administrador') {
                                        $botao = 'disabled';
                                    }else{

                                        $botao = '';
                                    
                                    }
                                        ?>

                                        <div class="btn-group" role="group" aria-label="Botões de comando">
                                            <button type="button" class="btn btn-outline-secondary "><a title="Editar dados" class="text-dark" href="<?=$base;?>pessoa/editar/<?= $pessoa->getId();?>">
                                            <i class="bi bi-pencil-square"></i>
                                            </a>  </button>
                                            <button type="button" class="btn btn-outline-secondary">
                                                <a title="visualizar dados" href="<?=$base;?>pessoa/ver/<?=$pessoa->getId(); ?>" class="text-dark"><i class="bi bi-eye"></i></a>
                                            </button>
                                            <button type="button" class="btn btn-outline-secondary" id="id_grupo"><a title="Altrar grupo" href="<?=$base;?>pessoa/alterar_grupo/<?= $pessoa->getId();?>" class="text-dark">
                                            <i class="bi bi-people"></i>
                                            </a></button>                           
                                            <button type="button" class="btn btn-danger <?=$botao;?>"> <a title="Excluir Pessoa" href="#" onclick="excluir(<?= $pessoa->getId();?>)" class="text-light" >
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
                    <form id="formUsuario" action="pessoa/add" method="POST"  autocomplete="off">

                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label fw-bold">Nome</label>
                            <div class="col-sm-10">                               
                                <input type="text" name="nome" class="form-control" />
                            </div>                          
                        </div>


                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label fw-bold">Nome Social</label>
                            <div class="col-sm-10">
                                <input type="text" name="nomeSocial" class="form-control" />    
                            </div>
                            
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label fw-bold">Tipo de Pessoa</label>
                            <div class="col-sm-10">
                            <select name="tipoPessoa" class="form-select" required>
                                    <option selected value="">Seleccione</option>
                                    <?php
                                    $pessoa = array(
                                        "Pessoa Física",
                                        "Pessoa Jurídica"
                                    );
                                    foreach ($pessoa as $pessoa) {
                                        echo "<option value='$pessoa'>$pessoa</option>";
                                    }
                                    ?>
                                </select>

                        </div>
                            
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label fw-bold">Data Nascimento</label>
                            <div class="col-sm-10">
                                <input type="date" name="dataNascimento" class="form-control" />    
                            </div>
                            
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label fw-bold">Sexo</label>
                            <div class="col-sm-10">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="sexo" value="Masculino" checked>
                                    <label class="form-check-label" for="inlineRadio1">Masculino</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="sexo" value="Feminino">
                                    <label class="form-check-label" for="inlineRadio1">Feminino</label>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label fw-bold">Mãe</label>
                            <div class="col-sm-10">
                                <input type="text" name="mae" class="form-control" />    
                            </div>
                            
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label fw-bold">Pai</label>
                            <div class="col-sm-10">
                                <input type="text" name="pai" class="form-control" />    
                            </div>
                            
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label fw-bold">Grupo</label>
                            <div class="col-sm-10">
                                 <select name="id_grupo" class="form-select" required>
                                    <option selected value="">Seleccione</option>
                                    <?php
                                    $grupo = array(
                                        "Administrador"=>1,
                                        "Professor"=>2,
                                        "Secretaria"=>3,
                                        "Pedagogo"=>4,
                                        "Aluno"=>5,
                                        "Diretor"=>6,
                                        "Funcionário"=>7                                        
                                    );
                                    foreach ($grupo as $grupo=>$grupoValor) {
                                        
                                        echo "<option value='$grupoValor'>$grupo</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label fw-bold">CPF/CNPJ</label>
                            <div class="col-sm-10">
                                <input type="text" name="cpf" id="ncpf" maxlength=14 class="form-control" />    
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
if (isset($_SESSION['flash']) && !empty($_SESSION['flash'])) {
    $msg = $_SESSION['flash'];
    ?>
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
        alert('<?= $msg['type']; ?>', '<?= $msg['title']; ?>', '<?= $msg['text']; ?>');
    </script>
    <?php
    unset($_SESSION['flash']); // melhor que atribuir ""
}
?>


<?php $render('footer');?>

