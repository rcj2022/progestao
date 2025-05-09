<?php
namespace src\controllers;

use \core\Controller;
use \core\Database;
use \core\Model;

use \src\handlers\LoginHandler;
use \src\models\User;
use \src\DAO\UserDAO;

class ProgramasController extends Controller {
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

        $this->render('pessoa',[
            'pessoa' => $data
        ]);
        
    }
   
    public function programaGov(){
        $this->redirect('programa');
    }
}