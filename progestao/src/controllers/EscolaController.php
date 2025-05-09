<?php
namespace src\controllers;

use \core\Database;
use \core\Model;
use \core\Controller;
use \src\DAO\EscolaDAO;

class EscolaController extends Controller {
  

    public function index() {

        
        $connection = Database::getInstance();
        $unidadeDAO = new EscolaDAO($connection);

        $data= $unidadeDAO->listAll();
       

        $this->render('unidadeEscolar',[
            'unidades' => $data
        ]);

       
        
    }

    public function EditarUindade() {

        
        $connection = Database::getInstance();
        $unidadeDAO = new EscolaDAO($connection);

        $data= $unidadeDAO->listAll();
       

        $this->render('escola',[
            'unidades' => $data
        ]);

       
        
    }

    public function editarUnit($id){
        
        $id = $id['id'];
        $_SESSION['idescola'] = $id;
        $connection = Database::getInstance();
        $userDAO = new EscolaDAO($connection);
        $data = $userDAO->listarUnidade($id);

        $this->render('editarUnidade',[
            'unidade' => $data
        ]);
    }

   


    public function ExcluirUnidade($id){           
        
        $id = $id['id'];
       
        $connection = Database::getInstance();
        $pessoaDAO = new EscolaDAO($connection);
        
        $pessoaDAO->deleteUnidade($id);

        $this->redirect('escola');
    }
    
    public function addUnidade(){
        
        $nome = filter_input(INPUT_POST, 'nome');
        $zona = filter_input(INPUT_POST, 'zona');        
        $inep = filter_input(INPUT_POST, 'inep');
        $cnpj = filter_input(INPUT_POST, 'cnpj');
        $email = filter_input(INPUT_POST, 'email');
        $cel = filter_input(INPUT_POST, 'celular');
        $atocriacao = "";
        $decretocriacao = "";
        $decretoAutorizacao = "";
        $diretorUnidade = "";
        $cpfDiretor = "";
        $decretoDiretor = "";
        $secretarioUnidade = "";
        $cpfSecretario = "";
        $decretoSecretario = "";
        $especialistaUnidade = "";
        $cpfEspecialista = "";
        $cep = "";
        $endereco = "";
        $numero = "";
        $bairro = "";
        $pais = "";
        $uf = "";
        $ufNome = "";
        $cidade = "";



        $connection = Database::getInstance();
        $userDAO = new EscolaDAO($connection);

      
        $userDAO->adicionarUnidade($nome, $zona, $inep, $cnpj, $email, $cel, $atocriacao,$decretocriacao, $decretoAutorizacao, $diretorUnidade, $cpfDiretor, $decretoDiretor, $secretarioUnidade, $cpfSecretario, $decretoSecretario, $especialistaUnidade,  $cpfEspecialista, $cep,  $endereco,  $numero, $bairro, $pais,  $uf,  $ufNome, $cidade);
        $this->redirect('unidadeEscolar');
        

        
        
    }
    public function editarInfoEscola(){
        
       
     
        $id = $_SESSION['idescola'];
            
             $atocriacao = filter_input(INPUT_POST, 'atoDeCriacao');
             $decretocriacao = filter_input(INPUT_POST, 'decretoCriacao');
             $decretoAutorizacao = filter_input(INPUT_POST, 'decretoAutorizacao');   
             $diretorUnidade = filter_input(INPUT_POST, 'diretorUnidade'); 
             $cpfDiretor = filter_input(INPUT_POST, 'cpfDiretor');
             $decretoDiretor = filter_input(INPUT_POST, 'decretoDiretor');
             $secretarioUnidade = filter_input(INPUT_POST, 'secretarioUnidade');
             $cpfSecretario = filter_input(INPUT_POST, 'cpfSecretario');
             $decretoSecretario = filter_input(INPUT_POST, 'decretoSecretario');
             $especialistaUnidade = filter_input(INPUT_POST, 'especialistaUnidade');
             $cpfEspecialista = filter_input(INPUT_POST, 'cpfEspecialista');
              $cep = filter_input(INPUT_POST, 'cep'); 
             $endereco = filter_input(INPUT_POST, 'endereco');
             $numero =filter_input(INPUT_POST, 'numero');
             $bairro = filter_input(INPUT_POST, 'bairro');
             $pais = filter_input(INPUT_POST, 'pais');
             $uf = filter_input(INPUT_POST, 'uf');       
             $ufNome = filter_input(INPUT_POST, 'ufNome');
             $cidade = filter_input(INPUT_POST, 'cidade');
     
     
             $connection = Database::getInstance();
             $pessoaDAO = new EscolaDAO($connection);
     
             $data=$pessoaDAO->editarInfoUnidade( $id, $atocriacao, $decretocriacao, $decretoAutorizacao, $diretorUnidade, $cpfDiretor, $decretoDiretor, $secretarioUnidade, $cpfSecretario, $decretoSecretario, $especialistaUnidade,  $cpfEspecialista, $cep,  $endereco,  $numero, $bairro, $pais,  $uf,  $ufNome, $cidade
             );
     
             $this->redirect('escola');
         }

    public function EditarUnidade(){
      
        $id = $_SESSION['idescola'];
       
        $nome = filter_input(INPUT_POST, 'nome');
        $zona = filter_input(INPUT_POST, 'zona');        
        $inep = filter_input(INPUT_POST, 'Inep');
        $cnpj = filter_input(INPUT_POST, 'cnpj');
        $email = filter_input(INPUT_POST, 'email');
        $cel = filter_input(INPUT_POST, 'telefone');
         
   
        
       

        $connection = Database::getInstance();
        $pessoaDAO = new EscolaDAO($connection);
       
        $data=$pessoaDAO->addUnidadeEdit($id,$nome, $zona, $inep, $cnpj, $email, $cel);

      
  

        if($data === false){


            $msg = [
                'type' => 'error',
                'title' => 'Erro ao atualizar',
                'text' => 'Unidade já atualizada',
            ];
            
            $_SESSION['flash'] = $msg; 

            $this->redirect('escola');

        }else{
            $msg = [
                'type' => 'success',
                'title' => 'Sucesso',
                'text' => 'Unidade atualizado com sucesso',
            ];
            $_SESSION['flash'] = $msg; 

            $this->redirect('escola');
        }
        
    }
   
}
