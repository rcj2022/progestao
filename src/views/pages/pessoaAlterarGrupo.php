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
                            
                            $grupo = $pessoa[0]['id_grupo'];
                    
                            switch ($grupo) {
                                case 1:
                                    echo $pessoa[0]['nome'] ." (Administrador)";
                                    break;
                                case 2:
                                    echo $pessoa[0]['nome'] ." (professor)";
                                    break;
                                case 3:
                                    echo $pessoa[0]['nome'] ." (Secretaria)";
                                    break;
                                case 4:
                                    echo $pessoa[0]['nome'] ." (Pedagogo)";
                                    break;
                                case 5:
                                    echo $pessoa[0]['nome'] ." (Aluno)";
                                    break;
                                case 6:
                                    echo $pessoa[0]['nome'] ." (Diretor)";
                                    break;
                                case 7:
                                    echo $pessoa[0]['nome'] ." (Funcionario)";
                                    break;
                                default:
                                    echo $pessoa[0]['nome'] ." (Nenhum grupo selecionado)";
                                    break;
                            }
                        ?>
                    </h1>  
                                    
                </div>
                <div class="modal-body m-5">
                    <form id="formAlterarGrupo" action="<?=$base;?>pessoa/alterar_grupo" method="POST"  autocomplete="off">
                        
                    <input type="hidden" name="id_pessoa" value="<?=$pessoa[0]['id'];?>"></input>
                    
                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label fw-bold">Grupo</label>
                            <div class="col-sm-10">
                                 <select name="id_grupo_alterado" class="form-select" required>
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
                                        if($grupoValor == $pessoa[0]['id_grupo']){
                                            echo "<option value='$grupoValor' selected>$grupo</option>";
                                        }else{
                                        
                                        echo "<option value='$grupoValor'>$grupo</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>  
                        <hr>   
                        <div class="mb-3 row  d-flex justify-content-end me-1">
                            
                            <a href="<?=$base;?>pessoa" class="btn btn-outline-danger col-sm-2 me-2"><i class="bi bi-arrow-left-circle me-2"></i>Cancelar</a>
                            <button type="submit" class="btn btn-outline-secondary col-sm-2" >
                            <i class="bi bi-floppy me-2"></i>
                                Alterar
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