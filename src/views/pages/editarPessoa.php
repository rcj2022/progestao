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
                <a class="nome-edicao ms-4"href="#"><?=$pessoas[0]['nome'];?></a>
            </span>      
            <a class="btn btn-outline-secondary float-sm-end" href="<?=$base;?>pessoa"><i  class="bi bi-arrow-left-circle me-2"></i>Voltar</a>
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
                    <button class="nav-link fs-5" id="profile-tab" data-bs-toggle="tab" data-bs-target="#programa" type="button" role="tab" aria-controls="programa" aria-selected="false">Programas Sociais</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link fs-5" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">Documentos</button>
                </li>            
            </ul>  
                <!--Cadastro e atualização de pessoas -->  
            <div class="tab-content" id="myTabContent">
                   <!--Atualização do cadastro principal -->  
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <!-- Formaulario de edição de cadastro de pessoas -->
                    <div class="modal-body m-5">
                        <form id="formUsuario" action="<?=$base;?>pessoa/add_edit" method="POST"  autocomplete="off">
                       
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">Nome</label>
                                <div class="col-sm-10">                               
                                    <input type="text" name="nome" class="form-control" value="<?=$pessoas[0]['nome'];?>"/>
                                </div>                          
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">Nome Social</label>
                                <div class="col-sm-10">
                                    <input type="text" name="nomeSocial" class="form-control" value="<?=$pessoas[0]['nomeSocial'];?>" />    
                                </div>                                
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">Tipo de Pessoa</label>
                                <div class="col-sm-10">
                                    <select name="tipoPessoa" class="form-select" required>
                                        <option selected value="">Seleccione</option>
                                            <?php
                                            $pessoa = array(
                                                "Pessoa Física",
                                                "Pessoa Jurídica"
                                            );
                                            foreach ($pessoa as $pessoa) {
                                                if($pessoas[0]['tipoPessoa'] == $pessoa){
                                                    echo "<option value='$pessoa' selected>$pessoa</option>";
                                                }else{
                                                    echo "<option value='$pessoa'>$pessoa</option>";
                                                }
                                            }
                                            ?>
                                    </select>

                                </div>                                
                            </div>
                            
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">Data Nascimento</label>
                                <div class="col-sm-10">
                                    <input type="text" name="dataNascimento" class="form-control" value="<?=$pessoas[0]['dataNascimento'];?>"/>    
                                </div>                               
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">Sexo</label>
                                <div class="col-sm-10">
                                    <div class="form-check form-check-inline">  
                                            <?php

                                               $sexo =  $pessoas[0]['sexo'];                                     

                                              if($sexo == "Masculino"){
                                               
                                                echo  "<input class='form-check-input' type='radio' name='sexo' value='Masculino' checked>";
                                              
                                                }else{
                                                    echo  "<input class='form-check-input' type='radio' name='sexo' value='Masculino'>";
                                                }
                                                ?>
                                                <label class="form-check-label" for="inlineRadio1">Masculino</label>
                                       
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                            if($sexo == "Feminino"){
                                                    
                                                    echo "<input class='form-check-input' type='radio' name='sexo' value='Feminino' checked>";;
                                                    
                                                    }else{
                                                        echo  "<input class='form-check-input' type='radio' name='sexo' value='Feminino'>";
                                                    }
                                            ?>
                                      
                                        <label class="form-check-label" for="inlineRadio1">Feminino</label>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">Mãe</label>
                                <div class="col-sm-10">
                                    <input type="text" name="mae" class="form-control" value="<?=$pessoas[0]['mae'];?>"/>    
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">Pai</label>
                                <div class="col-sm-10">
                                    <input type="text" name="pai" class="form-control" value="<?=$pessoas[0]['pai'];?>"/>    
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">Grupo</label>
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

                                                if($pessoas[0]['id_grupo'] == $grupoValor){
                                                    echo "<option value='$grupoValor' selected>$grupo</option>";
                                                }else{
                                                    echo "<option value='$grupoValor'>$grupo</option>";
                                                } 
                                               
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">CPF/CNPJ</label>
                                <div class="col-sm-10">
                                    <input type="text" name="cpf" class="form-control" id="ncpf" maxlength=14 value="<?=$pessoas[0]['cpf'];?>" />    
                                </div>                            
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">E-mail</label>
                                <div class="col-sm-10">
                                    <input type="text" name="email" class="form-control" value="<?=$pessoas[0]['email'];?>"/>    
                                </div>                            
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">Celular</label>
                                <div class="col-sm-10">
                                    <input type="text" name="celular" class="form-control" maxlength=15 id="celular" value="<?=$pessoas[0]['celular'];?>"/>    
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
                    <!-- Fim de edição de dados pessoais -->
                </div>  
                   <!--Cadastro de informações complementares -->                 
                <div class="tab-pane fade" id="inforCopmplementar" role="inforCopmplementar" aria-labelledby="inforCopmplementar-tab"> 
                    <!-- Inicio de edição de dados complementares das pessoas -->               
                    <div class="modal-body m-5">
                        <form id="formUsuario" action="pessoa/editar" method="POST"  autocomplete="off" enctype="multipart/form-data">
                            <div class="mb-3 row">                                
                                <div class="col-sm-10">                               
                                    <img src="<?=$base."assets/img/".$pessoas[0]['foto'];?>" id="target" name="foto" class="form-control"   style="width: 14rem;" title="fotoPerfil" value="avatar.jpg"/>
                                </div>                          
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">Foto</label>
                                <div class="col-sm-10">                               
                                <input type="file" class="form-control" id="foto" name="foto" value="<?=$pessoas[0]['foto'];?>" onchange="carregarImg()">
                                </div>                          
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">Estado Civil</label>
                                <div class="col-sm-10">
                                    <select name="estadoCivil" class="form-select" required>
                                        <option selected value="">Seleccione</option>
                                        <?php
                                            $estadoCivil = array("Solteiro(a)", "Casado(a)", "Separado(a)", "Divorciado(a)", "Viúvo(a)", "União Estável", "Outros");
                                           foreach ($estadoCivil as $estCivil) {
                                                if($pessoas[0]['estadoCivil'] == $estCivil){
                                                    echo "<option value='$estCivil' selected>$estCivil</option>";
                                                }else{
                                                    echo "<option value='$estCivil'>$estCivil</option>";
                                                } 
                                               
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">Local de Nascimento</label>
                                <div class="col-sm-10">                               
                                    <input type="text" name="localNascimento" class="form-control" value="<?=$pessoas[0]['localNascimento'];?>" />
                                </div>                          
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">Estado de Nascimento</label>
                                <div class="col-sm-10">
                                    <select name="estadoNascimento" class="form-select" required>
                                        <option selected value="">Seleccione</option>
                                        <?php
                                            $estadoNascimento = array(
                                            "Acre", "Alagoas", "Amapá", "Amazonas",
                                            "Bahia", "Ceará", "Distrito Federal", "Espírito Santo",
                                            "Goiás", "Maranhão", "Mato Grosso", "Mato Grosso do Sul",
                                            "Minas Gerais", "Pará", "Paraíba", "Paraná", "Pernambuco",
                                            "Piauí", "Rio de Janeiro", "Rio Grande do Norte", "Rio Grande do Sul",
                                            "Rondônia", "Roraima", "Santa Catarina", "São Paulo", "Sergipe", "Tocantins"); 

                                           foreach ($estadoNascimento as $ufNascimento) {

                                                if($pessoas[0]['estadoNascimento'] == $ufNascimento){
                                                    echo "<option value='$ufNascimento' selected>$ufNascimento</option>";
                                                }else{
                                                    echo "<option value='$ufNascimento'>$ufNascimento</option>";
                                                } 
                                               
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">Nacionalidade</label>
                                <div class="col-sm-10">
                                    <select name="nacionalidade" class="form-select" required>
                                        <option selected value="">Seleccione</option>
                                           <?php
                                                $pessoa = array(
                                                                "Brasileiro(a)",
                                                                "Estrangeiro(a)"
                                                            );
                                                            foreach ($pessoa as $pessoa) {

                                                                if($pessoas[0]['nacionalidade'] == $pessoa){
                                                                    echo "<option value='$pessoa' selected>$pessoa</option>";
                                                                }else{                      
                                                                echo "<option value='$pessoa'>$pessoa</option>";
                                                                }
                                                            }
                                                           ?>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">Cor da Pele</label>
                                <div class="col-sm-10">
                                    <select name="cor" class="form-select" required>
                                        <option selected value="">Seleccione</option>
                                           <?php
                                                $cor = array( "Amarelo", "Branco", "Indígena", "Pardo", "Preto");
                                                foreach ($cor as $corPessoa) {
                                                    
                                                    if($pessoas[0]['cor'] == $corPessoa){
                                                        echo "<option value='$corPessoa' selected>$corPessoa</option>";
                                                    }else{                      
                                                        echo "<option value='$corPessoa'>$corPessoa</option>";
                                                    }

                                                   
                                                }
                                            ?>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">Nº do RG</label>
                                <div class="col-sm-10">
                                    <input type="text" name="numeroRg" class="form-control" value="<?=$pessoas[0]['numeroRg'];?>" />    
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">Data de Emissão do RG</label>
                                <div class="col-sm-10">
                                    <input type="text" name="dataEmissaoRg" class="form-control" value="<?=$pessoas[0]['dataEmissaoRg'];?>"/>    
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">Órgão Emissão do RG</label>
                                <div class="col-sm-10">
                                    <input type="text" name="orgaoEmissorRg" class="form-control" value="<?=$pessoas[0]['orgaoEmissorRg'];?>"/>    
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">Local de Emissão do RG</label>
                                <div class="col-sm-10">
                                    <input type="text" name="localEmissorRg" class="form-control" value="<?=$pessoas[0]['localEmissorRg'];?>" />    
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">CNH</label>
                                <div class="col-sm-10">
                                    <input type="text" name="cnh" class="form-control" value="<?=$pessoas[0]['cnh'];?>" />    
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">CEP</label>
                                <div class="col-sm-10">
                                    <input type="text" name="cep" class="form-control" value="<?=$pessoas[0]['cep'];?>"/>    
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">Endereço</label>
                                <div class="col-sm-10">
                                    <input type="text" name="endereco" class="form-control" value="<?=$pessoas[0]['endereco'];?>" />    
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">Número da Casa/Apartamento</label>
                                <div class="col-sm-10">
                                    <input type="text" name="enderecoNumero" class="form-control" value="<?=$pessoas[0]['enderecoNumero'];?>"/>    
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">Complemento</label>
                                <div class="col-sm-10">
                                    <input type="text" name="enderecoComplemento" class="form-control" value="<?=$pessoas[0]['enderecoComplemento'];?>" />    
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">Bairro</label>
                                <div class="col-sm-10">
                                    <input type="text" name="enderecoBairro" class="form-control" value="<?=$pessoas[0]['enderecoBairro'];?>" />    
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">Cidade</label>
                                <div class="col-sm-10">
                                    <input type="text" name="enderecoCidade" class="form-control" value="<?=$pessoas[0]['enderecoCidade'];?>" />    
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">Estado</label>
                                <div class="col-sm-10">
                                    <input type="text" name="enderecoEstado" class="form-control" value="<?=$pessoas[0]['enderecoEstado'];?>" />    
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">PCD</label>
                                <div class="col-sm-10">
                                    <select name="pcd" class="form-select" required>
                                        <option selected value="">Seleccione</option>
                                           <?php
                                                $pcdPessoa = array( "Sim", "Não",);
                                                foreach ($pcdPessoa as $pcd) {

                                                    if($pessoas[0]['pcd'] == $pcd){
                                                        echo "<option value='$pcd' selected>$pcd</option>";
                                                    }else{                      
                                                        echo "<option value='$pcd'>$pcd</option>";
                                                    }

                                                   
                                                }
                                            ?>
                                    </select>
                                </div>
                            </div> 
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">Dependentes</label>
                                <div class="col-sm-10">
                                    <select name="dependentes" class="form-select" required>
                                        <option selected value="">Seleccione</option>
                                           <?php
                                                $dependentePessoa = array( "Sim", "Não",);
                                                foreach ($dependentePessoa as $dependente) {

                                                    if($pessoas[0]['dependentes'] == $dependente){
                                                        echo "<option value='$dependente' selected>$dependente</option>";
                                                    }else{                      
                                                        echo "<option value='$dependente'>$dependente</option>";
                                                    }
                                                   
                                                }
                                            ?>
                                    </select>
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
                   <!--Cadastro de programas sociais -->  
                <div class="tab-pane fade" id="programa" role="programa" aria-labelledby="programa-tab"> 
                    <!-- Inicio de edição de dados complementares das pessoas -->  
                    <div class="container mt-4">
                        <div class="row">
                        <h1 class="text-center">
                                    <span class="float-end mb-2">
                                        <a href="<?=$base;?>programaSocial"  class="btn btn-success" title="Adicionar Novo Programa">
                                            <i class="bi bi-person-plus"></i> NOVO
                                        </a>
                                    </span>
                                    <hr>
                                </h1>
                            <table class="table table-striped">
                              <thead>
                                <tr>                            
                                  <th scope="col">Nome</th>
                                  <th scope="col">Comandos</th>                                  
                                </tr>
                              </thead>
                              <tbody>
                              <?php                  
                                        foreach ($programa as $programa) { ?>
                                            <tr>
                                                <?php                                       
                                                  if(!isset($programa['programa'])){?>
                                                    
                                                   <?php
                                                  }else{
                                                    ?>
                                                      <td><?=$programa['programa'];?></td>
                                                      <td>
                                                       
                                                        <a href="#" onclick="excluirPrograma(<?=$programa['id'];?>)" class="btn btn-outline-danger" title="Excluir">
                                                            <i class="bi bi-trash me-2"></i>Excluir
                                                        </a>
                                                      </td>
                                                
                                            </tr>
                                            
                                        <?php }}?>                              
                              </tbody>
                            </table>
                          
                               
                           
                       </div>
                    </div>             
                    
                    <!-- Fim do Formulário -->
                </div>
                   <!--Cadastro de documentos -->  
                <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                    <div class="container mt-4">
                        <div class="row">
                            <div class="col-md-12">
                                <h1 class="text-center">
                                    <span class="float-end mb-2">
                                        <a href="<?=$base;?>arquivos"  class="btn btn-success" title="Adicionar Novo Usuário">
                                            <i class="bi bi-person-plus"></i> NOVO
                                        </a>
                                    </span>
                                    <hr>
                                </h1>
                            <div class="table">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>  
                                            <th scope="col">Tipo de Documento</th>
                                            <th scope="col">Arquivo</th>
                                            <th scope="col">Comandos</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php                  
                                        foreach ($pessoas as $pessoa) { ?>
                                            <tr>
                                                <?php                                       
                                                  if(!isset($pessoa['title'])){?>
                                                    
                                                   <?php
                                                  }else{
                                                    ?>
                                                      <td><?=$pessoa['title'];?></td>
                                                      <td><?=$pessoa['documento'];?></td>
                                                      <td>
                                                        <a href="<?=$base;?>assets/arquivo/<?=$pessoa['documento'];?>" target="blank" class="btn btn-outline-success" title="Visualizar">
                                                         
                                                        
                                                        <i class="bi bi-eye me-2"></i>Visualizar
                                                        </a>
                                                        <a href="<?=$base;?>download/<?=$pessoa['documento'];?>" class="btn btn-outline-primary" title="Baixar">
                                                            <i class="bi bi-download me-2"></i>Baixar
                                                        </a>
                                                        <a href="#" onclick="excluirArquivo(<?=$pessoa['id_documento'];?>)" class="btn btn-outline-danger" title="Excluir">
                                                            <i class="bi bi-trash me-2"></i>Excluir
                                                        </a>
                                                      </td>
                                                
                                            </tr>
                                            
                                        <?php }}?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
               <!--Fim doa cadastro e Atualização de pessoas -->  
        </div>
    </div>
</main>
 <?php $render('footer'); ?>