<?php
namespace src\models;
use \core\Model;

class Pessoa extends Model{

    public $id;
    public $nome;
    public $nomeSocial;
    public $tipoPessoa;     //padrão:'Pessoaa Física'
    public $dataNascimento;
    public $sexo;
    public $mae;
    public $pai;
    public $cpf;
    public $celular;
    public $email;   
    public $id_grupo;
    public $nomeGrupo;
    public $foto;
    public $estadoCivil;
    public $localNascimento;
    public $estadoNascimento;
    public $nacionalidade;
    public $cor;
    public $numeroRg;
    public $dataEmissaoRg; 
    public $orgaoEmissorRg;
    public $localEmissorRg;
    public $cnh;
    public $cep;
    public $endereco;
    public $enderecoNumero;
    public $enderecoComplemento;
    public $enderecoBairro;
    public $enderecoCidade;
    public $enderecoEstado;
    public $enderecoPais;        //Padrão: 'Brasil'    
    public $pcd;                 //Padrão: 'Não'    
    public $dependentes;         //Padrão: 'Não'    
    

    

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
public function setNomeSocial($n){
    $this->nomeSocial = $n;
}
public function getNomeSocial(){
    return $this->nomeSocial;   
}
public function setTipoPessoa($n){
    $this->tipoPessoa = $n;
}
public function getTipoPessoa(){
    return $this->tipoPessoa;
}
public function setDataNascimento($n){
    $this->dataNascimento = $n;
}
public function getDataNascimento(){
    return $this->dataNascimento;
}
public function setSexo($n){
    $this->sexo = $n;       
}
public function getSexo(){
    return $this->sexo;
}
public function setMae($n){
    $this->mae = $n;    
}
public function getMae(){
    return $this->mae; 
}
public function setPai($n){
    $this->pai = $n;
}
public function getPai(){
    return $this->pai;
}
public function setCpf($n){
    $this->cpf = $n;
}
public function getCpf(){
    return $this->cpf;
}
public function setCelular($n){
    $this->celular = $n;
}
public function getCelular(){
    return $this->celular;
}
public function setEmail($n){
    $this->email = $n;
}
public function getEmail(){
    return $this->email;    
}
public function setIdGrupo($n){
    $this->id_grupo = $n;
}
public function getIdGrupo(){
    return $this->id_grupo;
}
public function setFoto($n){
    $this->foto = $n;
}
public function getFoto(){
    return $this->foto;
}
public function setEstadoCivil($n){
    $this->estadoCivil = $n;
}
public function getEstadoCivil(){
    return $this->estadoCivil;
}
public function setLocalNascimento($n){
    $this->localNascimento = $n;
}
public function getLocalNascimento(){
    return $this->localNascimento;
}
public function setEstadoNascimento($n){
    $this->estadoNascimento = $n;
}
public function getEstadoNascimento(){
    return $this->estadoNascimento;
}
public function setNacionalidade($n){
    $this->nacionalidade = $n;
}
public function getNacionalidade(){
    return $this->nacionalidade;
}
public function setCor($n){
    $this->cor = $n;
}
public function getCor(){
    return $this->cor;
}
public function setNumeroRg($n){
    $this->numeroRg = $n;
}
public function getNumeroRg(){
    return $this->numeroRg; 
}
public function setDataEmissaoRg($n){
    $this->dataEmissaoRg = $n;
}
public function getDataEmissaoRg(){
    return $this->dataEmissaoRg;
}
public function setOrgaoEmissorRg($n){
    $this->orgaoEmissorRg = $n;
}
public function getOrgaoEmissorRg(){
    return $this->orgaoEmissorRg;
}
public function setLocalEmissorRg($n){
    $this->localEmissorRg = $n;
}
public function getLocalEmissorRg(){
    return $this->localEmissorRg;
}
public function setCnh($n){
    $this->cnh = $n;
}
public function getCnh(){
    return $this->cnh;
}
public function setCep($n){
    $this->cep = $n;
}
public function getCep(){
    return $this->cep;
}
public function setEndereco($n){
    $this->endereco = $n;
}
public function getEndereco(){
    return $this->endereco;
}
public function setEnderecoNumero($n){
    $this->enderecoNumero = $n;
}
public function getEnderecoNumero(){
    return $this->enderecoNumero;
}
public function setEnderecoComplemento($n){
    $this->enderecoComplemento = $n;
}
public function getEnderecoComplemento(){
    return $this->enderecoComplemento;
}
public function setEnderecoBairro($n){
    $this->enderecoBairro = $n;
}
public function getEnderecoBairro(){
    return $this->enderecoBairro;
}
public function setEnderecoCidade($n){
    $this->enderecoCidade = $n;
}
public function getEnderecoCidade(){
    return $this->enderecoCidade;
}
public function setEnderecoEstado($n){
    $this->enderecoEstado = $n;
}
public function getEnderecoEstado(){
    return $this->enderecoEstado;
}
public function setEnderecoPais($n){
    $this->enderecoPais = $n;
}
public function getEnderecoPais(){
    return $this->enderecoPais;
}
public function setPcd($n){
    $this->pcd = $n;
}
public function getPcd(){
    return $this->pcd;
}
public function setDependentes($n){
    $this->dependentes = $n;
}
public function getDependentes(){
    return $this->dependentes;
}
public function setNomeGrupo($n){
    $this->nomeGrupo = $n;
}
public function getNomeGrupo(){
    return $this->nomeGrupo;
}


}