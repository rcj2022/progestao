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
        <div class="col-sm-6"><h3 class="mb-0">Pessoas / Editar</h3></div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="<?=$base;?>">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">pessoas</li>
                </ol>
            </div>
        </div>
        <div class="container divnome">
            <span>
                <a class="nome-edicao ms-4"href="#"><?=$unidades[0]['nomeUnidade'];?></a>
            </span>      
            <a class="btn btn-outline-secondary float-sm-end" href="<?=$base;?>escola"><i  class="bi bi-arrow-left-circle me-2"></i>Voltar</a>
        </div>
        <div class="container mt-2">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active fs-5" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true"><i class="bi bi-person-circle me-2"></i>Cadastro</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link fs-5" id="profile-tab" data-bs-toggle="tab" data-bs-target="#inforCopmplementar" type="button" role="tab" aria-controls="inforCopmplementar" aria-selected="false">Informações Complementares</button>
                </li>
               
                         
            </ul>  
                <!--Cadastro e atualização de pessoas -->  
            <div class="tab-content" id="myTabContent">
                   <!--Atualização do cadastro principal -->  
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <!-- Formaulario de edição de cadastro de pessoas -->
                    <div class="modal-body m-5">
                        <form id="formUsuario" action="<?=$base;?>unidade/add_edit" method="POST"  autocomplete="off">
                       
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">Nome</label>
                                <div class="col-sm-10">                               
                                    <input type="text" name="nomeUnidade" class="form-control" value="<?=$unidades[0]['nomeUnidade'];?>"/>
                                </div>                          
                            </div>
                           
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">Zona</label>
                                <div class="col-sm-10">
                                    <select name="zonaUnidade" class="form-select" required>
                                        <option selected value="">Seleccione</option>
                                            <?php
                                            $unidade = array(
                                                "Urbana",
                                                "Rural"
                                            );
                                            foreach ($eunidade as $unidade) {
                                                if($unidades[0]['zonaUnidade'] == $unidade){
                                                    echo "<option value='$unidade' selected>$unidade</option>";
                                                }else{
                                                    echo "<option value='$unidade'>$unidade</option>";
                                                }
                                            }
                                            ?>
                                    </select>

                                </div>                                
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">INEP</label>
                                <div class="col-sm-10">
                                    <input type="text" name="codigoInep" class="form-control" value="<?=$unidades[0]['codigoInep'];?>"/>    
                                </div>                               
                            </div>
                           
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">CNPJ</label>
                                <div class="col-sm-10">
                                    <input type="text" name="cnpjUnidade" class="form-control" value="<?=$unidades[0]['cnpjUnidade'];?>"/>    
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">Email</label>
                                <div class="col-sm-10">
                                    <input type="email" name="emailUnidade" class="form-control" value="<?=$unidades[0]['emailUnidade'];?>"/>    
                                </div>
                            </div>
                         
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">Celular</label>
                                <div class="col-sm-10">
                                    <input type="text" name="telefoneUnidade" class="form-control" maxlength=15 id="telefoneUnidade" value="<?=$unidades[0]['telefoneUnidade'];?>"/>    
                                </div>                            
                            </div>   
                            <hr>   
                            <div class="mb-3 row  d-flex justify-content-end me-1">
                            <a href="<?=$base;?>/escola"  class="btn btn-outline-danger col-sm-2 me-2" > <i class="bi bi-arrow-left-circle me-2"></i>Cancelar</a>
                                <button type="submit" class="btn btn-outline-secondary col-sm-2" >
                                    <i class="bi bi-floppy me-2"></i>
                                        Salvar
                                </button>
                            </div>
                  
                        </form>
                    </div>
                    <!-- Fim de edição de dados pessoais -->
                </div>  

                   <!--Cadastro de informações complementares -->                 
                <div class="tab-pane fade" id="inforCopmplementar" role="inforCopmplementar" aria-labelledby="inforCopmplementar-tab"> 
                    <!-- Inicio de edição de dados complementares das pessoas -->               
                    <div class="modal-body m-5">
                        <form id="formUsuario" action="unidade/editar" method="POST"  autocomplete="off" enctype="multipart/form-data">
                           
                         
                         
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">Ato de criação</label>
                                <div class="col-sm-10">                               
                                    <input type="text" name="atoDeCriacao" class="form-control" value="<?=$unidades[0]['atoDeCriacao'];?>" />
                                </div>                          
                            </div>
                         
                       
                         
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">Decreto de criação</label>
                                <div class="col-sm-10">
                                    <input type="text" name="decretoCriacao" class="form-control" value="<?=$unidades[0]['decretoCriacao'];?>" />    
                                </div>
                            </div>
                         
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">Decreto de criação</label>
                                <div class="col-sm-10">
                                    <input type="text" name="decretoAutorizacao" class="form-control" value="<?=$unidades[0]['decretoAutorizacao'];?>"/>    
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">Diretor(a)</label>
                                <div class="col-sm-10">
                                    <input type="text" name="diretorUnidade" class="form-control" value="<?=$unidades[0]['diretorUnidade'];?>" />    
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">CPF do diretor(a)</label>
                                <div class="col-sm-10">
                                    <input type="text" name="cpfDiretor" class="form-control" value="<?=$unidades[0]['cpfDiretor'];?>" />    
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">Decreto do diretor(a)</label>
                                <div class="col-sm-10">
                                    <input type="text" name="decretoDiretor" class="form-control" value="<?=$unidades[0]['decretoDiretor'];?>"/>    
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">Secretario(a)</label>
                                <div class="col-sm-10">
                                    <input type="text" name="secretarioUnidade" class="form-control" value="<?=$unidades[0]['secretarioUnidade'];?>" />    
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">CPF do Secretario(a)</label>
                                <div class="col-sm-10">
                                    <input type="text" name="cpfSecretario" class="form-control" value="<?=$unidades[0]['cpfSecretario'];?>"/>    
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">Decreto do Secretario(a)</label>
                                <div class="col-sm-10">
                                    <input type="text" name="decretoSecretario" class="form-control" value="<?=$unidades[0]['decretoSecretario'];?>" />    
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">Especialista</label>
                                <div class="col-sm-10">
                                    <input type="text" name="especialistaUnidade" class="form-control" value="<?=$unidades[0]['especialistaUnidade'];?>" />    
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">CPF do Especialista</label>
                                <div class="col-sm-10">
                                    <input type="text" name="cpfEspecialista" class="form-control" value="<?=$unidades[0]['cpfEspecialista'];?>" />    
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">CEP</label>
                                <div class="col-sm-10">
                                    <input type="text" name="cep" class="form-control" value="<?=$unidades[0]['cep'];?>" />    
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">Endereço</label>
                                <div class="col-sm-10">
                                    <input type="text" name="endereco" class="form-control" value="<?=$unidades[0]['endereco'];?>" />    
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">Número</label>
                                <div class="col-sm-10">
                                    <input type="text" name="numero" class="form-control" value="<?=$unidades[0]['numero'];?>" />    
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">Bairro</label>
                                <div class="col-sm-10">
                                    <input type="text" name="bairro" class="form-control" value="<?=$unidades[0]['bairro'];?>" />    
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">País</label>
                                <div class="col-sm-10">
                                    <input type="text" name="pais" class="form-control" value="<?=$unidades[0]['pais'];?>" />    
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">UF</label>
                                <div class="col-sm-10">
                                    <input type="text" name="uf" class="form-control" value="<?=$unidades[0]['uf'];?>" />    
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">Estado</label>
                                <div class="col-sm-10">
                                    <input type="text" name="ufNome" class="form-control" value="<?=$unidades[0]['ufNome'];?>" />    
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">Cidade</label>
                                <div class="col-sm-10">
                                    <input type="text" name="cidade" class="form-control" value="<?=$unidades[0]['cidade'];?>" />    
                                </div>
                            </div>
                            
                            <hr>   
                            <div class="mb-3 row  d-flex justify-content-end me-1">
                                 <a href="<?=$base;?>/pessoa"  class="btn btn-outline-danger col-sm-2 me-2" > <i class="bi bi-arrow-left-circle me-2"></i>Cancelar</a>
                                <button type="submit" class="btn btn-outline-secondary col-sm-2" >
                                <i class="bi bi-floppy me-2"></i>
                                    Salvar
                                </button>
                            </div>
                        </form>
                    </div>
                    <!-- Fim do Formulário -->
                </div>
             
             
            </div>
               <!--Fim doa cadastro e Atualização de pessoas -->  
        </div>
    </div>
</main>
 <?php $render('footer'); ?>