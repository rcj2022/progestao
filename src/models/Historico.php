<?php
namespace src\models;
use \core\Model;

class Historico extends Model {

    public $id;
    public $id_conta;
    public $tipo;
    public $valor;
    public $data;

    public function setId($id){
        return $this->id = $id;
    }

    public function getId(){
        return $this->id;
    }

    public function setIdConta($idConta){
        return $this->id_conta = $idConta;
    }

    public function getIdConta(){
        return $this->id_conta;
    }

    public function setTipo($tipo){
        return $this->tipo = $tipo;
    }

    public function getTipo(){
        return $this->tipo;
    }

    public function setValor($valor){
        return $this->valor = $valor;
    }

    public function getValor(){
        return $this->valor;
    }

    public function setData($data){
        return $this->data = $data;
    }

    public function getData(){
        return $this->data;
    }

}