<?php
namespace src\controllers;

use \core\Controller;


class CursoController extends Controller {
  

    public function index() {

        $this->render('curso');
        
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
