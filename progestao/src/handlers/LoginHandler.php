<?php

namespace src\handlers;

use \src\models\User;
use \src\models\Grupo;



class LoginHandler {

    private $pdo;

    public function __construct($connection) {
        $this->pdo=$connection;
       
    }

    public function listAll() : array {

        $array = [];

        $sql = $this->pdo->query('SELECT * FROM users');

        if ($sql->rowCount() > 0) {
                      
            $data = $sql->fetchAll();
            foreach ($data as $item) {
                $user = new User();
                $user->setId($item['id']);
                $user->setNome($item['nome']); 
                $array[] = $user;
            }
        }

        return $array;
    }
    public function emailExists($email){        

        $sql = $this->pdo->prepare("SELECT * FROM User WHERE email = :email");
        $sql->bindValue(":email", $email);
        $sql->execute();

        if ($sql->rowCount() > 0) {
                      
            $data = $sql->fetchAll();
            foreach ($data as $item) {
                $u = new User();
                $u->id = $item['id'];
                $u->nome = $item['nome']; 
                $u->email = $item['email'];
                $u->password = $item['password'];
                $u->token = $item['token']; 
                          

               return $u;
               
            }
        }

        return false;
    }

    public function addUser($u){
        
        
        $senha = password_hash($u->getPasswuord(), PASSWORD_DEFAULT);
        $token = md5(time().rand(0, 9999).time());

        
        $sql = $this->pdo->prepare("INSERT INTO user (nome, email, password, token) VALUES(:nome, :email, :password, :token)");

        $sql->bindValue(":nome", $u->getNome());
        $sql->bindValue(":email", $u->getEmail());
        $sql->bindValue(":password", $senha);
        $sql->bindValue(":token", $token);

                
        $sql->execute();

    }

    public static function checkLogin(){        
        
        if(!empty($_SESSION['id'])){
            
            $userLogado = $_SESSION['id'];
            $userAtivo = $_SESSION['ativo'];

            $sql = User::select()->where('id', $userLogado)->where('ativo', $userAtivo)->one();  
           
                       
            if ($sql) {
                                             
                    $user = new User();
                    $user->setId($sql['id']);
                    $user->setNome($sql['nome']);   
                    $user->setEmail($sql['email']); 
                    $user->setSenha($sql['senha']); 
                    $user->setNivel($sql['id_grupo']); 

                    return $user;
                
                }
            }

        return false;

    }
    public static function verificarLogin($email, $senha){        
        
             
            $sql = User::select()->where('email', $email)->where('senha', $senha)->one();            
           
                       
            if ($sql) {
                                             
                    $user = new User();
                    $user->setId($sql['id']);
                    $user->setNome($sql['nome']);   
                    $user->setEmail($sql['email']); 
                    $user->setSenha($sql['senha']); 
                    $user->setNivel($sql['id_grupo']); 
                    $user->setAtivo($sql['ativo']); 

                    $data = Grupo::select()->where('id', $user->getNivel())->one();
                    
                    $user->setNivel($data['nivel']);

                    return $user;
                
                }            
            

        return false;
    }

}    
    
