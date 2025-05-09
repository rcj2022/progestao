<?php

namespace src\DAO;

use src\models\User;

class LoginDAO {

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

    public function checkLogin(){        
        
        if(!empty($_SESSION['token'])){
            $token = $_SESSION['token'];
         
            $sql = $this->pdo->prepare("SELECT * FROM User WHERE token = :token");
            $sql->bindValue(":token", $token);
           
            $sql->execute();  
           
            
            if ($sql->rowCount() > 0) {
                               
                $data = $sql->fetchAll();
                foreach ($data as $item) {
                    $user = new User();
                    $user->setId($item['id']);
                    $user->setNome($item['nome']);   
                    $user->setEmail($item['email']); 
                    $user->setToken($item['token']); 

                    return $user;
                
                }
            }

        }

        return false;

    }
    public function verifyLogin($name, $password){
        
           

            $senha = password_hash($password, PASSWORD_DEFAULT);
            
           
            $sql = $this->pdo->prepare("SELECT * FROM user WHERE nome = :nome");
            $sql->bindValue(":nome", $name);
           
         
            $sql->execute();  

           
            if ($sql->rowCount() > 0) { 

                $data = $sql->fetchAll();

                foreach($data as $usuario){
                   
                   $usuarioCadastrado = $usuario['nome'];
                   $usuarioSenha = $usuario['password'];

                }
                
                $token = md5(time().rand(0,9999).time());  

                $sql = $this->pdo->prepare("UPDATE user SET token = :token WHERE nome = :nome");

                $sql->bindValue(":token", $token);
                $sql->bindValue(":nome", $name);
        
                $sql->execute();
               
                return $token;
                
            }
          
        return false;

    }
}