<?php
namespace src\controllers;

use \core\Database;
use \core\Model;
use \core\Controller;
use \src\handlers\LoginHandler;
use \src\models\User;
use \src\DAO\UserDAO;


class UsuarioController extends Controller {

    private $loggedUser;
    public function __construct(){
       
        $this->loggedUser = LoginHandler::checkLogin();

            if($this->loggedUser === false){

                $this->redirect('login');

            }

    }
  
    public function index() {

        $connection = Database::getInstance();
        $userDAO = new UserDAO($connection);

        $data= $userDAO->listAll();

        $this->render('usuario',[
            'usuario' => $data
        ]);
        
    }
   

    public function addUser(){
        
        $nome = filter_input(INPUT_POST, 'nome');
        $email = filter_input(INPUT_POST, 'email');        
        $nivel = filter_input(INPUT_POST, 'nivel');
        $status = filter_input(INPUT_POST, 'status');
        $connection = Database::getInstance();
        $userDAO = new UserDAO($connection);

        $data=$userDAO->verificarUsuario($nome,$email);

        if($data === true){
                     
            $this->redirect('usuario');
            
        }else{
            $userDAO->adicionarUsuario($nome,$email,$nivel,$status);
            $this->redirect('usuario');
        }

        
        
    }

    public function updateUser() {

        $id = filter_input(INPUT_POST, 'id');
        $nome = filter_input(INPUT_POST, 'nome');
        $email = filter_input(INPUT_POST, 'email');
        $nivel = filter_input(INPUT_POST, 'nivel');
      
    
        $connection = Database::getInstance();
        $userDAO = new UserDAO($connection);
    
        $data = $userDAO->atualizarUsuario($id, $nome, $email, $nivel);
    
        if ($data === true) {
            $this->redirect('usuario');
        } 
    }
    public function deleteUser($id){           
        
        $id = $id['id'];
       
        $connection = Database::getInstance();
        $userDAO = new UserDAO($connection);
        
        $userDAO->deleteUser($id);

        $this->redirect('usuario');
    }

    public function editarUser($id){
        $id = $id['id'];
        $connection = Database::getInstance();
        $userDAO = new UserDAO($connection);
        $data = $userDAO->listarUsuario($id);

        $this->render('editarUsuario',[
            'usuario' => $data
        ]);
    }
    public function statusUser($id){
        $id = $id['id'];
        $connection = Database::getInstance();
        $userDAO = new UserDAO($connection);
        $data = $userDAO->updateStatus($id);

        $this->redirect('usuario');

    }

   
}
