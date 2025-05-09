<?php
namespace src\controllers;

use \core\Database;
use \core\Model;
use \core\Controller;
use \src\handlers\LoginHandler;
use \src\models\User;
use \src\DAO\PessoaDAO;


class PessoaController extends Controller {

    private $loggedUser;
    public function __construct(){
       
        $this->loggedUser = LoginHandler::checkLogin();

            if($this->loggedUser === false){

                $this->redirect('login');

            }

    }
  
    public function index() {

        $connection = Database::getInstance();
        $userDAO = new PessoaDAO($connection);

        $data= $userDAO->listAll();


        $_SESSION['idPessoa'] = "";
        $this->render('pessoa',[
            'pessoa' => $data
        ]);
        
    }

   

    public function addPessoa(){
        
        $nome = filter_input(INPUT_POST, 'nome');
        $nomeSocial = filter_input(INPUT_POST, 'nomeSocial');
        $tipoPessoa = filter_input(INPUT_POST, 'tipoPessoa');        
        $dataNascimento = filter_input(INPUT_POST, 'dataNascimento');
        $sexo = filter_input(INPUT_POST, 'sexo');
        $mae = filter_input(INPUT_POST, 'mae');
        $pai = filter_input(INPUT_POST, 'pai');
        $cpf = filter_input(INPUT_POST, 'cpf');
        $celular = filter_input(INPUT_POST, 'celular');
        $email = filter_input(INPUT_POST, 'email');       
        $id_grupo = filter_input(INPUT_POST, 'id_grupo');
        $id_grupo = intval($id_grupo);
        $foto = "avatar.jpg";
        $estadoCivil = "";
        $localNascimento = "";
        $estadoNascimento = "";
        $nacionalidade = "";
        $cor = "";
        $numeroRg = "";
        $dataEmissaoRg = filter_input(INPUT_POST, 'dataEmissaoRg');
        
        if($dataEmissaoRg==""){
            $dataEmissaoRg = "00-00-0000";
        }
        
        $orgaoEmissorRg = "";
        $localEmissorRg = "";
        $cnh = "";
        $cep = "";
        $endereco = "";
        $enderecoNumero = "";
        $enderecoComplemento = "";
        $enderecoBairro = "";
        $enderecoCidade = "";
        $enderecoEstado = "";       
        $pcd = "";
        $dependentes = "";


        $connection = Database::getInstance();
        $pessoaDAO = new PessoaDAO($connection);

        $data=$pessoaDAO->addPessoa(
        $nome, $nomeSocial, $tipoPessoa, $dataNascimento, $sexo, $mae, $pai, $cpf, $celular, $email, $id_grupo, $foto,
        $estadoCivil, $localNascimento, $estadoNascimento, $nacionalidade, $cor, $numeroRg, $dataEmissaoRg, $orgaoEmissorRg,$localEmissorRg, $cnh,
        $cep, $endereco, $enderecoNumero, $enderecoComplemento, $enderecoBairro, $enderecoCidade, $enderecoEstado,
        $pcd, $dependentes
        );

        if($data === false){

            $msg = [
                'type' => 'error',
                'title' => 'Erro ao cadastrar',
                'text' => 'Usuário já cadastrado',
            ];
            
            $_SESSION['flash'] = $msg; 

            $this->redirect('pessoa');

        }else{
            $msg = [
                'type' => 'success',
                'title' => 'Sucesso',
                'text' => 'Usuário cadastrado com sucesso',
            ];
            $_SESSION['flash'] = $msg; 

            $this->redirect('pessoa');
        }
        
    }
    public function addPessoaEdit(){
        
        $nome = filter_input(INPUT_POST, 'nome');
        $nomeSocial = filter_input(INPUT_POST, 'nomeSocial');
        $tipoPessoa = filter_input(INPUT_POST, 'tipoPessoa');        
        $dataNascimento = filter_input(INPUT_POST, 'dataNascimento');
        $sexo = filter_input(INPUT_POST, 'sexo');
        $mae = filter_input(INPUT_POST, 'mae');
        $pai = filter_input(INPUT_POST, 'pai');
        $cpf = filter_input(INPUT_POST, 'cpf');
        $celular = filter_input(INPUT_POST, 'celular');
        $email = filter_input(INPUT_POST, 'email');       
        $id_grupo = filter_input(INPUT_POST, 'id_grupo');
        $id_grupo = intval($id_grupo);
        


        $connection = Database::getInstance();
        $pessoaDAO = new PessoaDAO($connection);

        $data=$pessoaDAO->addPessoaEdit(
        $nome, $nomeSocial, $tipoPessoa, $dataNascimento, $sexo, $mae, $pai, $cpf, $celular, $email, $id_grupo
        );
     

        if($data === false){

            $msg = [
                'type' => 'error',
                'title' => 'Erro ao cadastrar',
                'text' => 'Usuário já cadastrado',
            ];
            
            $_SESSION['flash'] = $msg; 

            $this->redirect('pessoa');

        }else{
            $msg = [
                'type' => 'success',
                'title' => 'Sucesso',
                'text' => 'Usuário cadastrado com sucesso',
            ];
            $_SESSION['flash'] = $msg; 

            $this->redirect('pessoa');
        }
        
    }
  

    public function deletePessoa($id){           
        
        $id = $id['id'];
       
        $connection = Database::getInstance();
        $pessoaDAO = new PessoaDAO($connection);
        
        $pessoaDAO->deletePessoa($id);

        $this->redirect('pessoa');
    }
    public function editarInfoPessoa(){
        
   header('Content-Type: text/plain'); // Ou 'application/json'

  // Recebe os dados JSON enviados pelo JavaScript
  $jsonDados = file_get_contents('php://input');
  $dados = json_decode($jsonDados, true); // O 'true' converte para array associativo

      print_r($dados);

        $pastaDestino = "assets/img/";
       
        // Verifica se houve algum erro no envio do arquivo
        if ($_FILES['foto']['error'] === UPLOAD_ERR_OK) {
            $nome_temporario = $_FILES['foto']['tmp_name'];
            $nome_original = $_FILES['foto']['name'];
            $tamanho = $_FILES['foto']['size'];
            $tipo = $_FILES['foto']['type'];
        
            // Validações (opcionais, mas recomendadas)
            $tamanho_maximo = 2 * 1024 * 1024; // 2MB
            $tipos_permitidos = ['image/jpeg', 'image/png', 'image/gif'];
        
            if ($tamanho > $tamanho_maximo) {
                echo "Erro: O arquivo é muito grande. Tamanho máximo permitido: " . ($tamanho_maximo / (1024 * 1024)) . "MB.";
                exit;
            }
        
            if (!in_array($tipo, $tipos_permitidos)) {
                echo "Erro: Tipo de arquivo não permitido. Tipos permitidos: JPG, PNG, GIF.";
                exit;
            }
        
            // Gera um nome único para o arquivo para evitar conflitos
            $fotoName = uniqid('Pessoa_') . '_' . pathinfo($nome_original, PATHINFO_FILENAME) . '.' . pathinfo($nome_original, PATHINFO_EXTENSION);
            $caminho_destino = $pastaDestino . $fotoName;
        
            // Move o arquivo temporário para a pasta de destino
            move_uploaded_file($nome_temporario, $caminho_destino);
               
        }else{
            $connection = Database::getInstance();
            $pessoaDAO = new PessoaDAO($connection);
    
            $data=$pessoaDAO->verifcaFotoPessoa();

            if($data){
                $fotoName = $data;
            }else{
                $fotoName = "avatar.jpg";

            }
           
        }


        $foto = $fotoName ;
        $estadoCivil = filter_input(INPUT_POST, 'estadoCivil');
        $localNascimento = filter_input(INPUT_POST, 'localNascimento');
        $estadoNascimento = filter_input(INPUT_POST, 'estadoNascimento');   
        $nacionalidade = filter_input(INPUT_POST, 'nacionalidade'); 
        $cor = filter_input(INPUT_POST, 'cor');
        $numeroRg = filter_input(INPUT_POST, 'numeroRg');
        $dataEmissaoRg = filter_input(INPUT_POST, 'dataEmissaoRg');
        $orgaoEmissorRg = filter_input(INPUT_POST, 'orgaoEmissorRg');
        $localEmissorRg = filter_input(INPUT_POST, 'localEmissorRg');
        $cnh = filter_input(INPUT_POST, 'cnh');
        $cep = filter_input(INPUT_POST, 'cep');
        $endereco = filter_input(INPUT_POST, 'endereco');
        $enderecoNumero = filter_input(INPUT_POST, 'enderecoNumero');   
        $enderecoComplemento =filter_input(INPUT_POST, 'enderecoComplemento');
        $enderecoBairro = filter_input(INPUT_POST, 'enderecoBairro');
        $enderecoCidade = filter_input(INPUT_POST, 'enderecoCidade');
        $enderecoEstado = filter_input(INPUT_POST, 'enderecoEstado');       
        $pcd = filter_input(INPUT_POST, 'pcd');
        $dependentes = filter_input(INPUT_POST, 'dependentes');


        $connection = Database::getInstance();
        $pessoaDAO = new PessoaDAO($connection);

        $data=$pessoaDAO->editarInfoPessoa($foto, $estadoCivil, $localNascimento, $estadoNascimento, $nacionalidade, $cor, $numeroRg, $dataEmissaoRg, $orgaoEmissorRg,$localEmissorRg, $cnh,
        $cep, $endereco, $enderecoNumero, $enderecoComplemento, $enderecoBairro, $enderecoCidade, $enderecoEstado, $pcd, $dependentes
        );

        $this->redirect('pessoa');
    }

    public function editarUser($id){
        $id = $id['id'];
        $connection = Database::getInstance();
        $userDAO = new UserDAO($connection);
        $data = $userDAO->listarUsuario($id);

        $this->render('editarUsuario',[
            'usuario' => $data
        ]);
    }
    public function statusUser($id){
        $id = $id['id'];
        $connection = Database::getInstance();
        $userDAO = new UserDAO($connection);
        $data = $userDAO->updateStatus($id);

        $this->redirect('usuario');

    }
    public function editarPessoa($id){
        $id = $id['id'];
        $_SESSION['idPessoa'] = $id;
        $connection = Database::getInstance();
        $pessoaDAO = new PessoaDAO($connection);
        $data = $pessoaDAO->listarUmaPessoa($id);
        $prdata = $pessoaDAO->listarUmPrograma();
       

        $this->render('editarPessoa',[
            'pessoas' => $data,
            'programa' => $prdata
        ]);
      

    }
   
    public function alterarGrupo($id){

        $id = $id['id'];
       
        $connection = Database::getInstance();
        $pessoaDAO = new PessoaDAO($connection);
        $data = $pessoaDAO->listarUmaPessoa($id);
       
        $this->render('pessoaAlterarGrupo',[
            'pessoa' => $data
        ]);
    }
    public function alterarGrupoPessoa(){

        $id = filter_input(INPUT_POST, 'id_pessoa');
        $id_grupo = filter_input(INPUT_POST, 'id_grupo_alterado');
       
        $connection = Database::getInstance();
        $pessoaDAO = new PessoaDAO($connection);
        $data = $pessoaDAO->alterarGrupo($id, $id_grupo);
       
        $this->redirect('pessoa');
    }

    public function arquivo(){

        $id = $_SESSION['idPessoa'];
        $connection = Database::getInstance();
        $pessoaDAO = new PessoaDAO($connection);
        $data = $pessoaDAO->listarUmaPessoa($id);

        $this->render('arquivos',[
            'pessoa' => $data
        ]);
    }
    public function programaSocial(){

        $id = $_SESSION['idPessoa'];
        $connection = Database::getInstance();
        $pessoaDAO = new PessoaDAO($connection);
        $data = $pessoaDAO->listarUmaPessoa($id);

        $this->render('programaSocial',[
            'pessoa' => $data
        ]);
    }

    public function addArquivo(){
       
        //Pasta para adicionar os arquivos
        $pastaDestino = "assets/arquivo/";        
       
        // Verifica se houve algum erro no envio do arquivo
        if ($_FILES['documento']['error'] === UPLOAD_ERR_OK) {
            $nome_temporario = $_FILES['documento']['tmp_name'];
            $nome_original = $_FILES['documento']['name'];
            $tamanho = $_FILES['documento']['size'];
            $tipo = $_FILES['documento']['type'];
	
        
            // Validações (opcionais, mas recomendadas)
            $tamanho_maximo = 2 * 1024 * 1024; // 2MB
           // $tipos_permitidos = ['image/jpeg', 'image/png', 'image/gif', 'pdf', 'rar', 'zip', 'doc', 'docx', 'txt', 'xlsx', 'xlsm', 'xls', 'xml'];
        
            if ($tamanho > $tamanho_maximo) {
                echo "Erro: O arquivo é muito grande. Tamanho máximo permitido: " . ($tamanho_maximo / (1024 * 1024)) . "MB.";
                exit;
            }
       
            // Gera um nome único para o arquivo para evitar conflitos
            $arquivoName = uniqid('Pessoa_') . '_' . pathinfo($nome_original, PATHINFO_FILENAME) . '.' . pathinfo($nome_original, PATHINFO_EXTENSION);
            $caminho_destino = $pastaDestino . $arquivoName;
        
            // Move o arquivo temporário para a pasta de destino
            move_uploaded_file($nome_temporario, $caminho_destino);
               
        }

        $idPessoa = $_SESSION['idPessoa'];
        $title = filter_input(INPUT_POST, 'title');
        $documento = $arquivoName;
       


        $connection = Database::getInstance();
        $pessoaDAO = new PessoaDAO($connection);
        $data = $pessoaDAO->addArquivo($idPessoa, $title, $documento);

        $this->redirect('arquivos');


    }
    public function addPrograma(){

        $idPessoa = $_SESSION['idPessoa'];
        $programa = filter_input(INPUT_POST, 'opcoes', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
      
        $connection = Database::getInstance();
        $pessoaDAO = new PessoaDAO($connection);
        $data = $pessoaDAO->addPrograma($idPessoa, $programa);

        $this->redirect('programasocial');


    }

    public function visualisarPessoa($id){
        $id = $id['id'];
        $connection = Database::getInstance();
        $pessoaDAO = new PessoaDAO($connection);
        $data = $pessoaDAO->listarUmaPessoa($id);
        
       
       

        $this->render('visualizarPessoa',
        [
            'pessoa' => $data,
           
        ]);
    }
    
    public function arquivoExcluir($id){

       
        $connection = Database::getInstance();
        $pessoaDAO = new PessoaDAO($connection);
        $data = $pessoaDAO->excluirAruivo($id);

        $pastaDestino = "assets/arquivo/".$data;

       
        if(file_exists($pastaDestino)){
            
            unlink($pastaDestino);         

        }

        $this->redirect('arquivos');

    }
    public function programaExcluir($id){

       
        $connection = Database::getInstance();
        $pessoaDAO = new PessoaDAO($connection);
        $data = $pessoaDAO->excluirPrograma($id);

     

        $this->redirect('programasocial');

    }

    public function arquivoVisualizar($id){
       
        $connection = Database::getInstance();
        $pessoaDAO = new PessoaDAO($connection);
        $data = $pessoaDAO->visualizarUmArquivo($id);

        $this->render('visualizarArquivo');


    }

    public function downloadArquivo($id){
        $id = $id['id'];
        $connection = Database::getInstance();
        $pessoaDAO = new PessoaDAO($connection);
        $data = $pessoaDAO->visualizarUmArquivo($id);

        if($data){           
          
            $caminho_arquivo = $data;

            if (!file_exists($caminho_arquivo)) {
                http_response_code(404);
                echo 'Arquivo não encontrado no servidor.';
                exit;
            }

            $tipo_mime = mime_content_type($caminho_arquivo);

            if ($tipo_mime === false) {
                $tipo_mime = 'application/octet-stream';
            }

            header('Content-Type: ' . $tipo_mime);
            header('Content-Disposition: attachment; filename="' . basename($caminho_arquivo) . '"');
            header('Content-Length: ' . filesize($caminho_arquivo));
            header('Cache-Control: public');
            header('Pragma: public');

            readfile($caminho_arquivo);
            exit;

                }
        }
            
}
