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
<!-- Estilo para deixar a modal mais larga -->
<style>
    .modal-full-custom {
        max-width: 95% !important;
        width: 95%;
    }
</style>

<!-- Modal -->
<div class="modal-dialog modal-dialog-centered modal-full-custom">
    <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5 titulo_modal">
                <?php 
                    echo 'BENEFICIÁRIO(A): '.$pessoa[0]['nome'];
                ?>                        
            </h1>                                      
        </div>

        <form id="formUsuario" action="programa/add" method="POST" autocomplete="off">
            <div class="container mt-5">
                <table class="table table-bordered">
                <thead>
                <tr>
                        <th colspan="2" class="text-start">Selecione o programa abaixo:</th>
                    </tr>
                </thead>

                    <tbody>
                        <tr>
                            <td>
                                <div class="form-check mb-4">
                                    <input class="form-check-input" type="checkbox" name="programas[]" value="nao recebe" id="naorecebe" checked>
                                    <label class="form-check-label fw-bold" for="naorecebe">Não recebe</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" name="programas[]" value="Bolsa Família" id="bolsaFamilia">
                                    <label class="form-check-label fw-bold" for="bolsaFamilia">Bolsa Família</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" name="programas[]" value="Bolsa Escola" id="bolsaescola">
                                    <label class="form-check-label fw-bold" for="bolsaescola">Bolsa Escola</label>
                                </div>
                            </td>
                            <td>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" name="programas[]" value="Auxilio Emergencial" id="auxilioemergencial">
                                    <label class="form-check-label fw-bold" for="auxilioemergencial">Auxílio Emergencial</label>
                                </div>
                                <div class="form-check mb-4">
                                    <input class="form-check-input" type="checkbox" name="programas[]" value="Bolsa Jovem" id="bolsajovem">
                                    <label class="form-check-label fw-bold" for="bolsajovem">Bolsa Jovem</label>
                                </div>
                                <div class="form-check mb-4">
                                    <input class="form-check-input" type="checkbox" name="programas[]" value="outros" id="outros">
                                    <label class="form-check-label fw-bold" for="outros">Outros</label>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <!-- Botões -->
                <div class="mb-3 row d-flex justify-content-end me-1">
                    <a href="<?=$base;?>pessoa/editar/<?=$_SESSION['idPessoa'];?>" class="btn btn-outline-danger col-sm-2 me-2">
                        <i class="bi bi-arrow-left-circle me-2"></i>Voltar
                    </a>
                    <button type="submit" class="btn btn-outline-secondary col-sm-2">
                        <i class="bi bi-floppy me-2"></i>Adicionar
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>



</main>
<?php $render('footer');?>