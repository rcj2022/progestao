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


<div class="card">
  <div class="card-body">
    <form action='<?=$base;?>usuario/update' method="POST">
      <input type="hidden" id="id" name="id" value="<?=$usuario->getId();?>">

      <div class="mb-3">
        <label for="nome" class="form-label fw-bold">Nome</label>
        <input type="text" class="form-control" id="nome" name='nome' value="<?=$usuario->getNome();?>">
      </div>

      <div class="mb-3">
        <label for="email" class="form-label fw-bold">E-mail</label>
        <input type="email" class="form-control" id="email" name='email' value="<?=$usuario->getEmail();?>">
      </div>

      <div class="mb-3">
        <label for="nivel" class="form-label fw-bold">Nível</label>
        <select class="form-select w-25" id="nivel" name='nivel'>
          <option value="1" <?= $usuario->getNivel() == '1' ? 'selected' : '' ?>>Administrador</option>
          <option value="2" <?= $usuario->getNivel() == '2' ? 'selected' : '' ?>>Professor</option>
          <option value="3" <?= $usuario->getNivel() == '3' ? 'selected' : '' ?>>Secretaria</option>
          <option value="4" <?= $usuario->getNivel() == '4' ? 'selected' : '' ?>>Pedagogo</option>
          <option value="5" <?= $usuario->getNivel() == '5' ? 'selected' : '' ?>>Aluno</option>
          <option value="6" <?= $usuario->getNivel() == '6' ? 'selected' : '' ?>>Diretor</option>
        </select>
      </div>
      <hr>

      <div class="modal-footer">
      <a href="<?=$base;?>/usuario"  class="btn btn-outline-danger col-sm-2 me-2" > <i class="bi bi-arrow-left-circle me-2"></i>Cancelar</a>
      <button type="submit" class="btn btn-outline-secondary col-sm-2" >
                                <i class="bi bi-floppy me-2"></i>
                                    Salvar
                                </button>
      </div>
    </form>
  </div>
</div>

  
<?php $render('footer');?>
