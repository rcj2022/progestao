<?php
namespace src\controllers;

use \core\Controller;
use \src\handlers\LoginHandler;

class AlunoController extends Controller {
    
    private $loggedUser;
    public function __construct(){
       
        $this->loggedUser = LoginHandler::checkLogin();

            if($this->loggedUser === false){

                $this->redirect('login');

            }

    }
  

    public function index() {

        $this->render('aluno');
        
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
   
}
