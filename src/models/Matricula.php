<?php
namespace src\models;
use \core\Model;

class Matricula extends Model {

    public $id;
    public $idAluno;
    public $nome;
    public $sexo;   
    public $idTurma;
    public $escola;   
    public $turma;
    public $ano;


    public function setId($id){
       $this->id = $id;

    }
    public function getId(){
        return $this->id;
    }

    public function setIdAluno($idAluno){
        $this->idAluno = $idAluno;
    }
    public function getIdAluno(){
        return $this->idAluno;

    }
    public function setIdTurma($idTurma){
        $this->idTurma = $idTurma;
    }
    public function getIdTurma(){
        return $this->idTurma;
    }

    public function setNome($nome){
        $this->nome = $nome;
    }
    public function getnome(){
        return $this->nome;
    }

    public function setSexo($sexo){
        $this->sexo = $sexo;
    }
    public function getSexo(){
        return $this->sexo;
    }
    public function setEscola($escola){
        $this->escola = $escola;
    }
    public function getEscola(){
        return $this->escola;
    }
    public function setTurma($turma){
        $this->turma = $turma;
    }
    public function getTurma(){
        return $this->turma;
    }
    public function setAno($ano){
        $this->ano =  $ano;
    }

    public function getAno(){
        return $this->ano;
    }
   

}
