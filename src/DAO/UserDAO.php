<?php

namespace src\DAO;

use src\models\User;

class UserDAO {

    private $pdo;

    public function __construct($connection) {
        $this->pdo=$connection;
    }

    public function listAll() : array {

        $array = [];

        $sql = $this->pdo->query('SELECT users.id, users.nome, users.email, users.ativo, grupos.nivel FROM users JOIN grupos where users.id_grupo = grupos.id');

        

        if ($sql->rowCount() > 0) {
                      
            $data = $sql->fetchAll();
            foreach ($data as $item) {
                $user = new User();
                $user->setId($item['id']);
                $user->setNome($item['nome']); 
                $user->setEmail($item['email']); 
                $user->setNivel($item['nivel']); 
                $user->setAtivo($item['ativo']); 
                $array[] = $user;
            }
        }

        return $array;
    }

    public function checkLogin(){        
        
        if(!empty($_SESSION['nivel'])){
            $nivel = $_SESSION['nivel'];
         
            $sql = $this->pdo->prepare("SELECT * FROM User WHERE email = :token");
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
    public function verifyLogin($email, $password){        
       

            $senha = md5($password);
            
           
            $sql = $this->pdo->prepare("SELECT * FROM users WHERE email = :email and senha = :senha");
            $sql->bindValue(":email", $email);
            $sql->bindValue(":senha", $senha);           
         
            $sql->execute();  

           
            if ($sql->rowCount() > 0) { 

                

                $data = $sql->fetchAll();

                foreach($data as $usuario){
                   
                    $user = new User();
                    $user->setId($usuario['id']);
                    $user->setNome($usuario['nome']);   
                    $user->setEmail($usuario['email']); 
                    $user->setSenha($usuario['senha']); 
                    $user->setNivel($usuario['id_grupo']); 

                    return $user;


                }
                
            }

                 
    }

    public function adicionarUsuario($nome,$email,$nivel,$ativo){

        $senha = md5(123);
    
    
        $sql = $this->pdo->prepare("
            INSERT INTO users (nome, email, senha, id_grupo, ativo)
            VALUES (:nome, :email, :senha, :nivel, :ativo)
        ");
        $sql->bindValue(":nome", $nome);
        $sql->bindValue(":email", $email);
        $sql->bindValue(":senha", $senha);
        $sql->bindValue(":nivel", $nivel);
        $sql->bindValue(":ativo", $ativo);
      
        $sql->execute();

    }

    public function atualizarUsuario($id, $nome, $email, $nivel) {
        $sql = $this->pdo->prepare("UPDATE users SET nome = :nome, email = :email, id_grupo = :nivel WHERE id = :id");
        $sql->bindValue(":id", $id);
        $sql->bindValue(":nome", $nome);
        $sql->bindValue(":email", $email);
        $sql->bindValue(":nivel", $nivel);
       
        $sql->execute();

        return true;
    }
    

    public function verificarUsuario($nome,$email)
    {
        $sql = $this->pdo->prepare("SELECT * FROM users WHERE nome = :nome AND email = :email");
        $sql->bindValue(":nome", $nome);
        $sql->bindValue(":email", $email);
        $sql->execute();
        if ($sql->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteUser($id){
        $sql = $this->pdo->prepare("DELETE FROM users WHERE id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();
    }

    public function listarUsuario($id){
        
        $sql = $this->pdo->prepare("SELECT * FROM users WHERE id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();
        if ($sql->rowCount() > 0) {
            $data = $sql->fetch();
            $user = new User();
            $user->setId($data['id']);
            $user->setNome($data['nome']);
            $user->setEmail($data['email']);
            $user->setNivel($data['id_grupo']);
            return $user;
        } else {
            return false;
        }
    }

    public function updateStatus($id){

        $sql = $this->pdo->prepare("SELECT * FROM users WHERE id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            $data = $sql->fetch();
            if($data['ativo'] == 1){
                $status = 0;
            }else{
                $status = 1;
            }
            $sql = $this->pdo->prepare("UPDATE users SET ativo = :status WHERE id = :id");
            $sql->bindValue(":status", $status);
            $sql->bindValue(":id", $id);
            $sql->execute();
        }
    }   
}