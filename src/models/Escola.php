<?php
namespace src\models;
use \core\Model;

class Escola extends Model{

    public $id;
    public $logo;
    public $marcaDagua;   
    public $nomeUnidade;
    public $zonaUnidade;   
    public $grupoUnidade;   
    public $codigoInep;   
    public $cnpjUnidade;   
    public $atoDeCriacao;   
    public $decretoCriacao;   
    public $decretoAutorizacao;   
    public $telefoneUnidade;   
    public $emailUnidade;   
    public $diretorUnidade;   
    public $cpfDiretor;   
    public $decretoDiretor;   
    public $secretarioUnidade;   
    public $cpfSecretario;   
    public $decretoSecretario;   
    public $especialistaUnidade;   
    public $cpfEspecialista;   
    public $cep;   
    public $endereco;   
    public $numero;   
    public $bairro;   
    public $pais;   
    public $uf;   
    public $ufNome;   
    public $cidade;   

    public function setId($id){
       $this->id = $id;

    }
    public function getId(){
        return $this->id;
    }


    public function setLogo($l){
        $this->logo = $l;
    }
    public function getLogo(){
        return $this->logo;
    }


    public function setMarcaDagua($m){
        $this->marcaDagua = $m;
    }
    public function getMarcaDagua(){
        return $this->marcaDagua;
    }


    public function setNomeUnidade($n){
        $this->nomeUnidade;
    }
    
    public function getNomeUnidade(){
        return $this->nomeUnidade;
    }


    public function setZonaUnidade($z){
        $this->zonaUnidade;
    }
    public function getZonaUnidade(){
        return $this->zonaUnidade;
    }

    public function setGrupoUnidade($g){
        $this->grupoUnidade;
    }
    public function getGrupoUnidade(){
        return $this->grupoUnidade;
    }


    public function setCodigoInep($c){
        $this->codigoInep;
    }
    public function getCodigoInep(){
        return $this->codigoInep;
    }  


    public function setCnpjUnidade($c){
        $this->cnpjUnidade;
    }
    public function getCnpjUnidade(){
        return $this->cnpjUnidade;
    }


    public function setAtoDeCriacao($a){
        $this->atoDeCriacao;
    }
    public function getAtoDeCriacao(){
        return $this->atoDeCriacao;
    }


    public function setDecretoCriacao($d){
        $this->decretoCriacao;
    }

    public function getDecretoCriacao(){
        return $this->decretoCriacao;
    }

    public function setDecretoAutorizacao($d){
        $this->decretoAutorizacao;
    }

    public function getDecretoAutorizacao(){
        return $this->decretoAutorizacao;
    }

    public function setTelefoneUnidade($t){
        $this->telefoneUnidade;
    }

    public function getTelefoneUnidade(){
        return $this->telefoneUnidade;
    }

    public function setEmailUnidade($e){
        $this->emailUnidade;   
    }

    public function getEmailUnidade(){
        return $this->emailUnidade;
    }

    public function setDiretorUnidade($d){
        $this->diretorUnidade;
    }

    public function getDiretorUnidade(){
        return $this->diretorUnidade;
    }

    public function setCpfDiretor($c){
        $this->cpfDiretor;
    }

    public function getCpfDiretor(){
        return $this->cpfDiretor;
    }

    public function setDecretoDiretor($d){
        $this->decretoDiretor;
    }

    public function getDecretoDiretor(){
        return $this->decretoDiretor;
    }

    public function setSecretarioUnidade($s){
        $this->secretarioUnidade;
    }

    public function getSecretarioUnidade(){
        return $this->secretarioUnidade;
    }

    public function setCpfSecretario($c){
        $this->cpfSecretario;
    }

    public function getCpfSecretario(){
        return $this->cpfSecretario;
    }

    public function setDecretoSecretario($d){
        $this->decretoSecretario;
    }

    public function getDecretoSecretario(){
        return $this->decretoSecretario;
    }

    public function setEspecialistaUnidade($e){
        $this->especialistaUnidade;
    }

    public function getEspecialistaUnidade(){
        return $this->especialistaUnidade;
    }

    public function setCpfEspecialista($c){
        $this->cpfEspecialista;
    }

    public function getCpfEspecialista(){
        return $this->cpfEspecialista;
    }

    public function setCep($c){
        $this->cep;
    }

    public function getCep(){
        return $this->cep;
    }

    public function setEndereco($e){
        $this->endereco;
    }

    public function getEndereco(){
        return $this->endereco;
    }

    public function setNumero($n){
        $this->numero;
    }

    public function getNumero(){
        return $this->numero;
    }

    public function setBairro($b){
        $this->bairro;
    }

    public function getBairro(){
        return $this->bairro;
    }

    public function setPais($p){
        $this->pais;
    }

    public function getPais(){
        return $this->pais;
    }

    public function setUf($u){
        $this->uf;
    }

    public function getUf(){
        return $this->uf;
    }

    public function setUfNome($u){
        $this->ufNome;
    }

    public function getUfNome(){
        return $this->ufNome;
    }

    public function setCidade($c){
        $this->cidade;
    }

    public function getCidade(){
        return $this->cidade;
    }

   }
