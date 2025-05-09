<?php
namespace src\models;
use \core\Model;

class Evento extends Model {

    public $id;
    public $nome;
    public $data_inicio;
    public $data_fim;
 

    public function setId($id){
        $this->id = $id;
    }
    public function getId(){
        return $this->id;
    }

    public function setNome($nome){
        $this->nome = $nome;
    }
    public function getNome(){
        return $this->nome;
    }

    public function setDataInicio($data){
        $this->data_inicio = $data;
    }
    public function getDataInicio(){
        return $this->data_inicio;
    }

    public function setDataFim($data){
        $this->data_fim = $data;
    }
    public function getDataFim(){
        return $this->data_fim;
    }

}
