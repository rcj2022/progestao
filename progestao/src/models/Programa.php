<?php
namespace src\models;
use \core\Model;

class Programa extends Model {

    public $id;
    public $nome;
  

    public function setId($id){
       $this->id = $id;

    }
    public function getId(){
        return $this->id;
    }

    public function setNome($e){
        $this->nome = $e;
    }
    public function getNome(){
        return $this->nome;

    }

}