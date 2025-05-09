<?php
namespace src\models;
use \core\Model;

class Aluno extends Model {

    public $id;
    public $nome;
    public $sexo;   
    public $dataNascimento;
    public $idade;   

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

    public function setSexo($s){
        $this->sexo = $s;
    }
    public function getSexo(){
        return $this->sexo;
    }

    public function setDataNascimento($d){
        $this->dataNascimento = $d;
    }

    public function getDataNascimento(){
        return $this->dataNascimento;
    }

    public function setIdade($i){
        $this->idade =  $i;
    }

    public function getIdade(){
        return $this->idade;
    }
   

}
