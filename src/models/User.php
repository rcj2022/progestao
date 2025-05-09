<?php
namespace src\models;
use \core\Model;

class User extends Model {

    public $id;
    public $nome;
    public $email;   
    public $senha;
    public $nivel; 
    public $ativo; 
  
  

    public function setId($id){
       $this->id = $id;

    }
    public function getId(){
        return $this->id;
    }

    public function setNome($n){
        $this->nome = $n;
    }
    public function getNome(){
        return $this->nome;

    }

   

    public function setEmail($email){
        $this->email = $email;
    }
    public function getEmail(){
        return $this->email;
    }

    public function setSenha($s){
        $this->senha = $s;
    }

    public function getSenha(){
        return $this->senha;
    }
    public function setNivel($n){
        $this->nivel = $n;
    }
    public function getNivel(){
        return $this->nivel;
    }
    public function setAtivo($n){
        $this->ativo = $n;
    }
    public function getAtivo(){
        return $this->ativo;
    }
   

}
