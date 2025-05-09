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
        <div class="grupo-dados-main">
            <div class="grupo-dados">
             <p class="nome-dados pessoa"><span class="fw-bold"><?=$pessoa[0]['nome'];?></span></p>
             <p class="nome-dados"><span class="fw-bold">CPF: </span><?=$pessoa[0]['cpf'];?></p>
             <p class="nome-dados"><span class="fw-bold">Nascimento: </span><?=$pessoa[0]['dataNascimento'];?></p>
             <p class="nome-dados"><span class="fw-bold">Sexo: </span><?=$pessoa[0]['sexo'];?></p>
             <p class="nome-dados"><span class="fw-bold">Endereço: </span><?=$pessoa[0]['endereco']." -"?>  <?=$pessoa[0]['enderecoNumero']." -"?> <?=$pessoa[0]['enderecoBairro']?></p>
             <p class="nome-dados"><span class="fw-bold">Celular: </span><?=$pessoa[0]['celular'];?></p>
             <p class="nome-dados"><span class="fw-bold">E-mail: </span><?=$pessoa[0]['email'];?></p>
            </div>          
             <img src="<?=$base?>/assets/img/<?=$pessoa[0]['foto'];?>" alt="" widt="100" height="100">
        </div>
        <hr>
        <p class="nome-dados pessoa"><span class="fw-bold">Pais ou Responsáveis</span></p> 
        <hr>
        <div class="grupo-dados">            
            <div class="grupo-dados">
             <p class="nome-dados"><span class="fw-bold">Mãe: </span><?=$pessoa[0]['mae'];?></p>
             <p class="nome-dados"><span class="fw-bold">Pai: </span><?=$pessoa[0]['pai'];?></p>
             
            </div>  
        </div>
        <hr>
        <p class="nome-dados pessoa"><span class="fw-bold">Outras informações</span></p> 
        <hr>
        <div class="grupo-dados">            
            <div class="grupo-dados">
             <p class="nome-dados"><span class="fw-bold">Estado Civil: </span><?=$pessoa[0]['estadoCivil'];?></p>
             <p class="nome-dados"><span class="fw-bold">Local de Nascimento: </span><?=$pessoa[0]['localNascimento'];?></p>
             <p class="nome-dados"><span class="fw-bold">Estado de Nascimento: </span><?=$pessoa[0]['estadoNascimento'];?></p>
             <p class="nome-dados"><span class="fw-bold">Cor da Pele: </span><?=$pessoa[0]['cor'];?></p>
             <p class="nome-dados"><span class="fw-bold">Portador de Deficiência: </span><?=$pessoa[0]['pcd'];?></p>
             <p class="nome-dados"><span class="fw-bold">Possui dependentes: </span><?=$pessoa[0]['dependentes'];?></p>
             
            </div>  
        </div>
        </div>
       </div>
</main>

<?php $render('footer');?>

