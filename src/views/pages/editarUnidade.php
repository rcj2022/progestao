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
        <div class="col-sm-6"><h3 class="mb-0">Unidade / Editar</h3></div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="<?=$base;?>">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">pessoas</li>
            </ol>
        </div>
    </div>
    <div class="container divnome">
    <span>
                <a class="nome-edicao ms-4"href="#"><?=$unidade['nomeUnidade'];?></a>
                
            </span> 
        <a class="btn btn-outline-secondary float-sm-end" href="<?=$base;?>escola"><i class="bi bi-arrow-left-circle me-2"></i>Voltar</a>
    </div>
    <div class="container mt-2">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active fs-5" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true"><i class="bi bi-person-circle me-2"></i>Cadastro</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link fs-5" id="profile-tab" data-bs-toggle="tab" data-bs-target="#inforCopmplementar" type="button" role="tab" aria-controls="inforCopmplementar" aria-selected="false">Informações Complementares</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link fs-5" id="profile-tab" data-bs-toggle="tab" data-bs-target="#inforlogradouro" type="button" role="tab" aria-controls="inforlogradouro" aria-selected="false">Informações de endereço</button>
            </li>
        </ul>  
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                <!-- Formaulario de edição de cadastro de pessoas -->
                <div class="modal-body m-5">
                    <form id="formUsuario" action="<?=$base;?>unidade/add_edit" method="POST" autocomplete="off">
                      
                  
                
                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label">Nome</label>
                            <div class="col-sm-10">                               
                            <input type="text" class="form-control text-uppercase" id="nome" name='nome' value="<?=$unidade['nomeUnidade'];?>">
                            </div>                          
                        </div>
                       
                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label">Zona</label>
                            <div class="col-sm-10">
                                <select name="zona" class="form-control">tipo
                                    <option value="0">Selecione</option>
                                    <option value="Urbana" <?= ($unidade['zonaUnidade'] == 'Urbana') ? 'selected' : ''; ?>>Urbana</option>
                                    <option value="Rural" <?= ($unidade['zonaUnidade'] == 'Rural') ? 'selected' : ''; ?>>Rural</option>
                                </select>
                           
                            </div> 
                         </div>

                      
                         
                       
                     
                        
                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label">INEP</label>
                            <div class="col-sm-10">
                            <input type="text" class="form-control" id="Inep" maxlength= 8 name='Inep' value="<?= $unidade['codigoInep']; ?>">
                            </div> 
                        </div> 
                       
                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label">CNPJ</label>
                            <div class="col-sm-10">
                            <input type="text" class="form-control" id="cnpj" maxlength= 14 name='cnpj' value="<?= $unidade['cnpjUnidade']; ?>">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label">Email</label>
                            <div class="col-sm-10">
                            <input type="text" class="form-control" id="email" name='email' value="<?= $unidade['emailUnidade']; ?>">
                            </div>
                            </div>
             
                     
                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label">Celular</label>
                            <div class="col-sm-10">
                            <input type="text" class="form-control" id="telefone" name='telefone' value="<?= $unidade['telefoneUnidade']; ?>">
                            </div>
                                                   
                        </div>   
                        <hr>   
                        <div class="mb-3 row  d-flex justify-content-end me-1">
                            <a href="<?=$base;?>/escola"  class="btn btn-outline-danger col-sm-2 me-2" > <i class="bi bi-arrow-left-circle me-2"></i>Cancelar</a>
                            <button type="submit" class="btn btn-outline-secondary col-sm-2" >
                                <i class="bi bi-floppy me-2"></i> Salvar
                            </button>
                        </div>
                    </form>
                </div>
            </div>  

            <!--Cadastro de informações complementares -->                 
            <div class="tab-pane fade" id="inforCopmplementar" role="inforCopmplementar" aria-labelledby="inforCopmplementar-tab"> 
                <div class="modal-body m-5">
                    <form id="formUsuario" action="unidade/editar" method="POST" autocomplete="off" enctype="multipart/form-data">
                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label">Ato de criação</label>
                            <div class="col-sm-10">                               
                            <input type="text" class="form-control" id="atoDeCriacao" name='atoDeCriacao' value="<?= $unidade['atoDeCriacao']; ?>">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label">Decreto de criação</label>
                            <div class="col-sm-10">
                            <input type="text" class="form-control" id="decretoCriacao" name='decretoCriacao' value="<?= $unidade['decretoCriacao']; ?>">
                            </div>   
                    
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label">Decreto de Autorização</label>
                            <div class="col-sm-10">
                            <input type="text" class="form-control" id="decretoAutorizacao" name='decretoAutorizacao' value="<?= $unidade['decretoAutorizacao']; ?>">  
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label">Diretor(a)</label>
                            <div class="col-sm-10">
                            <input type="text" class="form-control" id="diretorUnidade" name='diretorUnidade' value="<?= $unidade['diretorUnidade']; ?>">  
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label">CPF do diretor(a)</label>
                            <div class="col-sm-10">
                            <input type="text" class="form-control" id="cpfDiretor" name='cpfDiretor' value="<?= $unidade['cpfDiretor']; ?>">  
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label">Decreto do diretor(a)</label>
                            <div class="col-sm-10">
                            <input type="text" class="form-control" id="decretoDiretor" name="decretoDiretor" 
       value="<?= $unidade['decretoDiretor'] ?? ''; ?>">

                         
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label">Secretario(a)</label>
                            <div class="col-sm-10">
                            <input type="text" class="form-control" id="secretarioUnidade" name='secretarioUnidade' value="<?= $unidade['secretarioUnidade']; ?>">    
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label">CPF do Secretario(a)</label>
                            <div class="col-sm-10">
                            <input type="text" class="form-control" id="cpfSecretario" name='cpfSecretario' value="<?= $unidade['cpfSecretario']; ?>">    
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label">Decreto do Secretario(a)</label>
                            <div class="col-sm-10">
                            <input type="text" class="form-control" id="decretoSecretario" name='decretoSecretario' value="<?= $unidade['decretoSecretario']; ?>"> 
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label">Especialista</label>
                            <div class="col-sm-10">
                            <input type="text" class="form-control" id="especialistaUnidade" name='especialistaUnidade' value="<?= $unidade['especialistaUnidade']; ?>">   
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label">CPF do Especialista</label>
                            <div class="col-sm-10">
                            <input type="text" class="form-control" id="cpfEspecialista" name='cpfEspecialista' value="<?= $unidade['cpfEspecialista']; ?>">    
                            </div>
                        </div>
                        <hr>   
                        <div class="mb-3 row  d-flex justify-content-end me-1">
                            <a href="<?=$base;?>/escola"  class="btn btn-outline-danger col-sm-2 me-2" > <i class="bi bi-arrow-left-circle me-2"></i>Cancelar</a>
                            <button type="submit" class="btn btn-outline-secondary col-sm-2" >
                                <i class="bi bi-floppy me-2"></i> Salvar
                            </button>
                        </div>
                    </form>
                </div>
            </div> 
            <!-- Fim da aba informações complementares -->

            <!-- Aba de informações de endereço --> 
            <div class="tab-pane fade" id="inforlogradouro" role="inforlogradouro" aria-labelledby="inforlogradouro-tab"> 
                <div class="modal-body m-5">
                <form id="formUsuario" action="<?=$base;?>unidade/atualizar" method="POST" autocomplete="off">
                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label">CEP</label>
                            <div class="col-sm-10">                               
                            <input type="text" class="form-control" id="cep" name='cep' value="<?= $unidade['cep']; ?>"> 
                            </div>                          
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label">Endereço</label>
                            <div class="col-sm-10">                               
                            <input type="text" class="form-control" id="endereco" name='endereco' value="<?= $unidade['endereco']; ?>"> 
                            </div>                          
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label">Número</label>
                            <div class="col-sm-10">                               
                            <input type="text" class="form-control" id="numero" name='numero' value="<?= $unidade['numero']; ?>"> 
                            </div>                          
                        </div>

                       
                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label">Bairro</label>
                            <div class="col-sm-10">                               
                            <input type="text" class="form-control" id="bairro" name='bairro' value="<?= $unidade['bairro']; ?>"> 
                            </div>                          
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label">País</label>
                            <div class="col-sm-10">                               
                            <input type="text" class="form-control" id="pais" name='pais' value="<?= $unidade['pais']; ?>"> 
                            </div>                          
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label">UF</label>
                            <div class="col-sm-10">                               
                            <input type="text" class="form-control" id="uf" name='uf' value="<?= $unidade['uf']; ?>">
                            </div>                          
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label">Estado</label>
                            <div class="col-sm-10">                               
                            <input type="text" class="form-control" id="ufNome" name='ufNome' value="<?= $unidade['ufNome']; ?>">
                            </div>                          
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label">Cidade</label>
                            <div class="col-sm-10">                               
                            <input type="text" class="form-control" id="cidade" name='cidade' value="<?= $unidade['cidade']; ?>">
                            </div>                          
                        </div>
                       
                        
                        <hr>   
                        <div class="mb-3 row  d-flex justify-content-end me-1">
                            <a href="<?=$base;?>/escola"  class="btn btn-outline-danger col-sm-2 me-2" > <i class="bi bi-arrow-left-circle me-2"></i>Cancelar</a>
                            <button type="submit" class="btn btn-outline-secondary col-sm-2" >
                                <i class="bi bi-floppy me-2"></i> Salvar
                            </button>
                        </div>
                    </form>
                </div>
            </div> 
        </div> 
    </div>
</main>
 <?php $render('footer'); ?>

<!-- Scripts para máscaras -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
<script>
    $(document).ready(function() {
       
        $('#cnpj').mask('00.000.000/0000-00', {reverse: true});
        $('#telefone').mask('(00) 00000-0000');
        $('#cep').mask('00000-000');
        $('#cpfDiretor').mask('000.000.000-00', {reverse: true});
        $('#cpfSecretario').mask('000.000.000-00', {reverse: true});
        $('#cpfEspecialista').mask('000.000.000-00', {reverse: true});
        $('#Inep').mask('00000000', {reverse: true});
       
    });
</script>