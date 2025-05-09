<?php
namespace src\controllers;

use \core\Controller;
use \core\Model;
use \src\models\User;
use \core\Database;
use src\DAO\EventoDAO;
use \src\handlers\LoginHandler;
class EventosController extends Controller {
  
    private $loggedUser;
    public function __construct(){
       
        $this->loggedUser = LoginHandler::checkLogin();

            if($this->loggedUser === false){

                $this->redirect('login');

            }

    }


    public function index() {

        $connection = Database::getInstance();
        $EventoDAO = new EventoDAO($connection);

        $data= $EventoDAO->listAll();

        $this->render('evento',[
            'evento' => $data
        ]);
        
    }

public function adicionarEventos(){

    $nome = filter_input(INPUT_POST, 'nome');
    $dataInicial = filter_input(INPUT_POST, 'data_inicio');
    $dataFinal = filter_input(INPUT_POST, 'data_fim');        
    
    
    $connection = Database::getInstance();
    $pessoaDAO = new EventoDAO($connection);

    $data=$pessoaDAO->AddEvento($nome, $dataInicial, $dataFinal);

    if($data === false){

        $msg = [
            'type' => 'error',
            'title' => 'Erro ao cadastrar',
            'text' => 'Evento já cadastrado',
        ];
        
        $_SESSION['flash'] = $msg; 

        $this->redirect('evento');

    }else{
        $msg = [
            'type' => 'success',
            'title' => 'Sucesso',
            'text' => 'Evento cadastrado com sucesso',
        ];
        $_SESSION['flash'] = $msg; 

        $this->redirect('evento');
    }
}

public function DeleteEventos($id){

    $connection = Database::getInstance();
    $pessoaDAO = new EventoDAO($connection);
    $data = $pessoaDAO->excluirEvento($id);

 

    $this->redirect('evento');
}
   
}