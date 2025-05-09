<?php
namespace src\controllers;

use \core\Controller;
use \src\models\User;
use \src\models\Grupo;
use \src\handlers\LoginHandler;


class LoginController extends Controller {
  

    public function index() {

        $this->render('login');
        
    }
    
    public function turma($id) {

              
        $idTurma=($id['i']);

        
       
        if($idTurma==1){
            $turma = '5º Ano-A';
            $this->render('turma', ['nomeTurma' => $turma]);
            exit();
            
        }
        $turma = '5º Ano-B';
        $this->render('turma', ['nomeTurma' => $turma]);
       
    }


    
    public function verificarLogin(){
        
        $email = filter_input(INPUT_POST,'email');
        $senha = filter_input(INPUT_POST, 'senha'); 
        $senha = md5($senha);

       
        if($email && $senha){

            $data = loginHandler::verificarLogin($email, $senha);        

            if($data){
                     $_SESSION['nivel'] = $data->getNivel();
                     $_SESSION['user'] = $data->getNome();  
                     $_SESSION['id'] = $data->getId();
                     $_SESSION['ativo'] = $data->getAtivo();
                     
                     $this->redirect('/');

             }else{
                 $this->redirect('login');
        }  

    }

     
        
    }
    public function logout(){
        session_destroy();
        $this->redirect('/login');
    }
   
}
