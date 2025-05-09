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
              <div class="col-sm-6"><h3 class="mb-0">Usuários</h3></div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                  <li class="breadcrumb-item"><a href="<?=$base;?>">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Usuários</li>
                </ol>
              </div>
            </div>
        <div class="container mt-4">
          <div class="row">
              <div class="col-md-12">
                  <h1 class="text-center">
                      <span class="float-end mb-2">
                          <a href="#" onclick="modalAddUsuario()" class="btn btn-success" title="Adicionar Novo Usuário">
                              <i class="bi bi-person-plus"></i> NOVO
                          </a>
                      </span>
                      <hr>
                  </h1>
                  <div class="table-responsive">
      <table class="table table-hover" id="tabela_usuario">
          <thead>
              <tr>                  
                  <th scope="col">Ativo</th>
                  <th scope="col">Nome</th>
                  <th scope="col">Email</th>                  
                  <th scope="col">Comandos</th>
              </tr>
          </thead>
          <tbody>
              <?php                  
              foreach ($usuario as $user) { ?>
                  <tr id="empleado_<?= $user->getId(); ?>">                      
                      <td>
                      <?php
                        $ativo = $user->getAtivo();
                            if ($ativo == 0) {?>
                                <a title="Destivar usuario" href="<?=$base;?>usuario/status/<?=$user->getId(); ?>" class="btn btn-warning">Não</a>
                        <?php } ?>
                        <?php
                            if($ativo==1){?>
                                <a title="Ativar usuário" href="<?=$base;?>usuario/status/<?= $user->getId(); ?>" class="btn btn-success">Sim</a>
                        <?php } ?>
                      </td>
                      <td><?= $user->getNome(); ?></td>
                      <td><?= $user->getEmail(); ?></td>                     
                      <td class="d-flex justify-content-end">
                        <div class="btn-group" role="group" aria-label="Botões de comando">
                            <button type="button" class="btn btn-outline-secondary "><a title="Editar dados" class="text-dark" href="<?=$base;?>usuario/editar/<?= $user->getId(); ?>" >
                              <i class="bi bi-pencil-square"></i>
                            </a>  </button>
                            <button type="button" class="btn btn-outline-secondary"><?php
                        $ativo = $user->getAtivo();
                            if ($ativo == 0) {?>
                                <a title="Ativar usuario" href="<?=$base;?>usuario/status/<?=$user->getId(); ?>" class="text-dark"><i class="bi bi-lock"></i></a>
                        <?php } ?>
                        <?php
                            if($ativo==1){?>
                                <a title="desativar usuário" href="<?=$base;?>usuario/status/<?= $user->getId(); ?>" class="text-dark"><i class="bi bi-unlock"></i></a>
                        <?php } ?></button>
                            <button type="button" class="btn btn-outline-secondary"> <a title="Altrar email"  href="" class="text-dark">
                              <i class="bi bi-envelope-at"></i>
                            </a></button>
                            <button type="button" class="btn btn-outline-secondary"> <a title="Alterar Senha" href="#" onclick="verDetallesEmpleado(<?php $user->getId();?>)" class="text-dark">
                              <i class="bi bi-arrow-counterclockwise"></i>
                            </a></button>
                            <button type="button" class="btn btn-danger"> <a title="Visualizar dados" href="#" onclick="verDetallesEmpleado(<?php $user->getId();?>)" class="text-light">
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


<?php $render('footer');?>

<div class="modal fade" id="addUsuario" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 titulo_modal">Adicionar Novo Usuário</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formUsuario" action="usuario/add" method="POST" enctype="multipart/form-data" autocomplete="off">

                  
                        <div class="mb-3">
                            <label class="form-label">Nome</label>
                            <input type="text" name="nome" class="form-control" placeholder="Campo obrigatório" required/>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="text" name="email" class="form-control" placeholder="Campo obrigatório" required/>
                        </div>
                     
                        <div class="mb-3">
            <label for="nivel" class="form-label">Nível</label>
            <select class="form-select" id="nivel" name="nivel" required>
              <option value="1">Administrador</option>
              <option value="2">Professor</option>
              <option value="3">Secretaria</option>
              <option value="4">Pedagogo</option>
              <option value="5">Aluno</option>
              <option value="6">Diretor</option>
            </select>
          </div>


          <div class="mb-3">
         <label class="form-label d-block">Ativo</label>

        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="status" id="sim" value="1" checked>
          <label class="form-check-label" for="sim">Sim</label>
        </div>

        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="status" id="nao" value="2">
          <label class="form-check-label" for="nao">Não</label>
        </div>
      </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn_add" onclick="registrarEmpleado(event)">
                                Salvar Usuário
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
</div>

