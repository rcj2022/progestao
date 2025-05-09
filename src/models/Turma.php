<?php
namespace src\models;
use \core\Model;

class Turma extends Model {

    public $id;
    public $escola;
    public $nomeDaTurma;   
    public $turno;
    public $anoLetivo;   

    public function setId($id){
       $this->id = $id;

    }
    public function getId(){
        return $this->id;
    }

    public function setEscola($e){
        $this->escola = $e;
    }
    public function getEscola(){
        return $this->escola;

    }

    public function setNomeDaTurma($nomeDaTurma){
        $this->nomeDaTurma = $nomeDaTurma;
    }
    public function getnomeDaTurma(){
        return $this->nomeDaTurma;
    }

    public function setTurno($turno){
        $this->turno = $turno;
    }

    public function getTurno(){
        return $this->turno;
    }

    public function setAnoLetivo($anoLetivo){
        $this->anoLetivo =  $anoLetivo;
    }

    public function getAnoLetivo(){
        return $this->anoLetivo;
    }
   

}
