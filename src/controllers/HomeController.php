<?php
namespace src\controllers;
use \core\Controller;
use \src\models\Grupo;
use \core\Database;
use \src\models\User;
use \src\DAO\UserDAO;
use \src\DAO\LoginDAO;
use \src\handlers\LoginHandler;


class HomeController extends Controller {

    private $loggedUser;
    public function __construct(){
       
        $this->loggedUser = LoginHandler::checkLogin();

            if($this->loggedUser === false){

                $this->redirect('login');

            }

    }

    public function index() {

        $this->render('home');        

   
    }
}
?>