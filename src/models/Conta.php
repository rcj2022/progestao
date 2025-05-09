<?php
namespace src\models;
use \core\Model;

class Conta extends Model {

    private $id;
    private $nome;
    private $banca;   
    private $conta;
    private $saldo; 

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

    public function setBanca($banca){
        $this->banca = $banca;
    }
    public function getBanca(){
        return $this->banca;
    }

    public function setConta($conta){
        $this->conta = $conta;
    }

    public function getConta(){
        return $this->conta;
    }

    public function setSaldo($saldo){
        $this->saldo =  $saldo;
    }

    public function getSaldo(){
        return $this->saldo;
    }

}



