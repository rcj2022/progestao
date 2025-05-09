<?php

namespace src\DAO;


use src\models\Pessoa;

class PessoaDAO {

    private $pdo;

    public function __construct($connection) {
        $this->pdo=$connection;
    }

    public function listAll() : array {

        $array = [];

        $sql = $this->pdo->query('SELECT pessoas.*, grupos.nivel FROM pessoas INNER JOIN grupos where pessoas.id_grupo = grupos.id');
        

        

        if ($sql->rowCount() > 0) {
                      
            $data = $sql->fetchAll();
            foreach ($data as $item) {
               
                $pessoa = new Pessoa();
            
                $pessoa->setId($item['id']);
                $pessoa->setNome($item['nome']); 
                $pessoa->setCpf($item['cpf']);
                $pessoa->setNomeGrupo($item['nivel']);
                
                $array[] = $pessoa;
            }
        }

        return $array;
    }

    public function checkLogin(){        
        
        if(!empty($_SESSION['nivel'])){
            $nivel = $_SESSION['nivel'];
         
            $sql = $this->pdo->prepare("SELECT * FROM User WHERE email = :token");
            $sql->bindValue(":token", $token);
           
            $sql->execute();  
           
            
            if ($sql->rowCount() > 0) {
                               
                $data = $sql->fetchAll();
                foreach ($data as $item) {
                    $user = new User();
                    $user->setId($item['id']);
                    $user->setNome($item['nome']);   
                    $user->setEmail($item['email']); 
                    $user->setToken($item['token']); 

                    return $user;
                
                }
            }

        }

        return false;

    }
    public function verifyLogin($email, $password){        
       

            $senha = md5($password);
            
           
            $sql = $this->pdo->prepare("SELECT * FROM users WHERE email = :email and senha = :senha");
            $sql->bindValue(":email", $email);
            $sql->bindValue(":senha", $senha);           
         
            $sql->execute();  

           
            if ($sql->rowCount() > 0) { 

                

                $data = $sql->fetchAll();

                foreach($data as $usuario){
                   
                    $user = new User();
                    $user->setId($usuario['id']);
                    $user->setNome($usuario['nome']);   
                    $user->setEmail($usuario['email']); 
                    $user->setSenha($usuario['senha']); 
                    $user->setNivel($usuario['id_grupo']); 

                    return $user;


                }
                
            }

                 
    }

    public function adicionarUsuario($nome,$email,$nivel){

        $senha = md5(123);

        $sql = $this->pdo->prepare("INSERT INTO users (nome, email, senha, id_grupo) VALUES(:nome, :email, :senha, :nivel)");
        $sql->bindValue(":nome", $nome);
        $sql->bindValue(":email", $email);
        $sql->bindValue(":senha", $senha);
        $sql->bindValue(":nivel", $nivel);
        $sql->execute();

    }

    public function verificarUsuario($nome,$email)
    {
        $sql = $this->pdo->prepare("SELECT * FROM users WHERE nome = :nome AND email = :email");
        $sql->bindValue(":nome", $nome);
        $sql->bindValue(":email", $email);
        $sql->execute();
        if ($sql->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function deletePessoa($id){
        $sql = $this->pdo->prepare("DELETE FROM pessoas WHERE id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();
    }

    public function listarUsuario($id){
        
        $sql = $this->pdo->prepare("SELECT * FROM users WHERE id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();
        if ($sql->rowCount() > 0) {
            $data = $sql->fetch();
            $user = new User();
            $user->setId($data['id']);
            $user->setNome($data['nome']);
            $user->setEmail($data['email']);
            $user->setNivel($data['id_grupo']);
            return $user;
        } else {
            return false;
        }
    }

    public function updateStatus($id){

        $sql = $this->pdo->prepare("SELECT * FROM users WHERE id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            $data = $sql->fetch();
            if($data['ativo'] == 1){
                $status = 0;
            }else{
                $status = 1;
            }
            $sql = $this->pdo->prepare("UPDATE users SET ativo = :status WHERE id = :id");
            $sql->bindValue(":status", $status);
            $sql->bindValue(":id", $id);
            $sql->execute();
        }
    }   

    public function listarPessoa(){
        $sql = $this->pdo->query('SELECT pessoas.*, grupos.nivel FROM pessoas INNER JOIN grupos where pessoas.id_grupo = grupos.id');
        

        
           if ($sql->rowCount() > 0) {
                $dados = "";
                while ($data = $sql->fetch(\PDO::FETCH_ASSOC)) {
                    extract($data);
                    
                    $dados .= "<tr id='empleado_$id'>                      
                    <td>$nome</td>
                    <td>$cpf</td>                     
                    <td>$nivel</td>                     
                    <td class='d-flex justify-content-end'>
                      <div class='btn-group' role='group' aria-label='Botões de comando'>
                          <button type='button' class='btn btn-outline-secondary '><a title='Editar dados' class='text-dark' href='#' onclick='editarEmpleado($id)'>
                            <i class='bi bi-pencil-square'></i>
                          </a>  </button>
                          <button type='button' class='btn btn-outline-secondary'>
                              <a title='visualizar dados' href='#' class='text-dark'><i class='bi bi-eye'></i></a>
                          </button>
                          <button type='button' class='btn btn-outline-secondary'> <a title='Altrar grupo' href='#' onclick='verDetallesEmpleado($id)' class='text-dark'>
                            <i class='bi bi-people'></i>
                          </a></button>                           
                          <button type='button' class='btn btn-danger'> <a title='Visualizar dados' href='#' onclick='verDetallesEmpleado($id)' class='text-light'>
                            <i class='bi bi-trash'></i>
                          </a></button>
                      </div>                          
                    </td>
                </tr>";
                }
                echo $dados;
            }
    }
    public function listarUmaPessoa($id){

        $array = [];

        $sql = $this->pdo->prepare('SELECT p.*, a.* FROM pessoas p LEFT JOIN arquivos a ON p.id = a.idPessoa WHERE p.id =:id');
        $sql->bindValue(":id", $id);
        $sql->execute();

        if ($sql && $sql->rowCount() > 0) {
            $data = $sql->fetchAll(\PDO::FETCH_ASSOC); // Usar FETCH_ASSOC para acessar os dados pelo nome da coluna
           
            foreach ($data as $item) {                                    
                
                $array[] = $item;
                
            }
        }

      
        if($array == null){

            $sql = $this->pdo->prepare('SELECT * FROM pessoas WHERE id =:id');
            $sql->bindValue(":id", $id);
            $sql->execute();
    
            if ($sql && $sql->rowCount() > 0) {
                $data = $sql->fetchAll(\PDO::FETCH_ASSOC); // Usar FETCH_ASSOC para acessar os dados pelo nome da coluna
               
                foreach ($data as $item) {                                    
                    
                    $array[] = $item;
                    
                }
            }
        }

        return $array;
    }
     
    public function listarUmPrograma(){
        $id=$_SESSION['idPessoa'];
        $array = [];
     

        $sql = $this->pdo->prepare('SELECT p.*, pr.* FROM pessoas p LEFT JOIN programas pr ON p.id = pr.idPessoa WHERE p.id =:id');
        $sql->bindValue(":id", $id);
        $sql->execute();

        if ($sql && $sql->rowCount() > 0) {
            $data = $sql->fetchAll(\PDO::FETCH_ASSOC); // Usar FETCH_ASSOC para acessar os dados pelo nome da coluna
           
            foreach ($data as $item) {                                    
                
                $array[] = $item;
                
            }
        }

      
        if($array == null){

            $sql = $this->pdo->prepare('SELECT * FROM pessoas WHERE id =:id');
            $sql->bindValue(":id", $id);
            $sql->execute();
    
            if ($sql && $sql->rowCount() > 0) {
                $data = $sql->fetchAll(\PDO::FETCH_ASSOC); // Usar FETCH_ASSOC para acessar os dados pelo nome da coluna
               
                foreach ($data as $item) {                                    
                    
                    $array[] = $item;
                    
                }
            }
        }

        return $array;
    }
     
    public function addPessoa($nome, $nomeSocial, $tipoPessoa, $dataNascimento, $sexo, $mae, $pai, $cpf, $celular, $email, $id_grupo,
    $foto,$estadoCivil, $localNascimento, $estadoNascimento, $nacionalidade, $cor, $numeroRg, $dataEmissaoRg, $orgaoEmissorRg, $localEmissorRg, $cnh,
    $cep, $endereco, $enderecoNumero, $enderecoComplemento, $enderecoBairro, $enderecoCidade, $enderecoEstado,
    $pcd, $dependentes){
        
       

        if($_SESSION['idPessoa'] != ""){
            $id = $_SESSION['idPessoa'];
            $sql = $this->pdo->prepare("UPDATE pessoas
            SET
                nome = :nome,
                nomeSocial = :nomeSocial,
                tipoPessoa = :tipoPessoa,
                dataNascimento = :dataNascimento,
                sexo = :sexo,
                mae = :mae,
                pai = :pai,
                cpf = :cpf,
                celular = :celular,
                email = :email,                                   
                id_grupo = :id_grupo,
                foto = :foto,
                estadoCivil = :estadoCivil,
                localNascimento = :localNascimento,
                estadoNascimento = :estadoNascimento,
                nacionalidade = :nacionalidade,
                cor = :cor,
                numeroRg = :numeroRg,
                dataEmissaoRg = :dataEmissaoRg,
                orgaoEmissorRg = :orgaoEmissorRg,
                localEmissorRg = :localEmissorRg,
                cnh = :cnh,
                cep = :cep,
                endereco = :endereco,
                enderecoNumero = :enderecoNumero,
                enderecoComplemento = :enderecoComplemento,
                enderecoBairro = :enderecoBairro,
                enderecoCidade = :enderecoCidade,
                enderecoEstado = :enderecoEstado,                                    
                pcd = :pcd,
                dependentes = :dependentes
            WHERE
                id = :id");

                $sql->bindValue(":id", $_SESSION['idPessoa']);
                $sql->bindValue(":nome", $nome);
                $sql->bindValue(":nomeSocial", $nomeSocial);
                $sql->bindValue(":tipoPessoa", $tipoPessoa);
                $sql->bindValue(":dataNascimento", $dataNascimento);
                $sql->bindValue(":sexo", $sexo);
                $sql->bindValue(":mae", $mae);
                $sql->bindValue(":pai", $pai);
                $sql->bindValue(":cpf", $cpf);
                $sql->bindValue(":celular", $celular);
                $sql->bindValue(":email", $email);               
                $sql->bindValue(":id_grupo", $id_grupo);
                $sql->bindValue(":foto", $foto);
                $sql->bindValue(":estadoCivil", $estadoCivil);
                $sql->bindValue(":localNascimento", $localNascimento);
                $sql->bindValue(":estadoNascimento", $estadoNascimento);
                $sql->bindValue(":nacionalidade", $nacionalidade);
                $sql->bindValue(":cor", $cor);
                $sql->bindValue(":numeroRg", $numeroRg);
                $sql->bindValue(":dataEmissaoRg", $dataEmissaoRg);
                $sql->bindValue(":orgaoEmissorRg", $orgaoEmissorRg);
                $sql->bindValue(":localEmissorRg", $localEmissorRg);
                $sql->bindValue(":cnh", $cnh);
                $sql->bindValue(":cep", $cep);
                $sql->bindValue(":endereco", $endereco);
                $sql->bindValue(":enderecoNumero", $enderecoNumero);
                $sql->bindValue(":enderecoComplemento", $enderecoComplemento);
                $sql->bindValue(":enderecoBairro", $enderecoBairro);
                $sql->bindValue(":enderecoCidade", $enderecoCidade);
                $sql->bindValue(":enderecoEstado", $enderecoEstado);               
                $sql->bindValue(":pcd", $pcd);
                $sql->bindValue(":dependentes", $dependentes);
                $sql->execute();



        }else{        
            $sql = $this->pdo->prepare('SELECT nome, mae FROM pessoas WHERE nome = :nome AND mae = :mae');
            $sql->bindValue(":nome", $nome);
            $sql->bindValue(":mae", $mae);
            $sql->execute();

            if ($sql->rowCount() > 0) {

                if($_SESSION['idPessoa'] === ""){

                    return false;
                    exit();

                }

             

            }else{
                  
                $sql = $this->pdo->prepare("INSERT INTO pessoas (
                nome,
                nomeSocial,
                tipoPessoa,
                dataNascimento,
                sexo,
                mae,
                pai,
                cpf,
                celular,
                email,
                id_grupo,
                foto,
                estadoCivil,
                localNascimento,
                estadoNascimento,
                nacionalidade,
                cor,
                numeroRg,
                dataEmissaoRg,
                orgaoEmissorRg,
                localEmissorRg,
                cnh,
                cep,
                endereco,
                enderecoNumero,
                enderecoComplemento,
                enderecoBairro,
                enderecoCidade,
                enderecoEstado,
                pcd,
                dependentes)
                VALUES (
                :nome,
                :nomeSocial,
                :tipoPessoa,
                :dataNascimento,
                :sexo,
                :mae,
                :pai,
                :cpf,
                :celular,
                :email,               
                :id_grupo,
                :foto,
                :estadoCivil,
                :localNascimento,
                :estadoNascimento,
                :nacionalidade,
                :cor,
                :numeroRg,
                :dataEmissaoRg,
                :orgaoEmissorRg,
                :localEmissorRg,
                :cnh,
                :cep,
                :endereco,
                :enderecoNumero,
                :enderecoComplemento,
                :enderecoBairro,
                :enderecoCidade,
                :enderecoEstado,
                :pcd,
                :dependentes)");

                $sql->bindValue(":nome", $nome);
                $sql->bindValue(":nomeSocial", $nomeSocial);
                $sql->bindValue(":tipoPessoa", $tipoPessoa);
                $sql->bindValue(":dataNascimento", $dataNascimento);
                $sql->bindValue(":sexo", $sexo);
                $sql->bindValue(":mae", $mae);
                $sql->bindValue(":pai", $pai);
                $sql->bindValue(":cpf", $cpf);
                $sql->bindValue(":celular", $celular);
                $sql->bindValue(":email", $email);             
                $sql->bindValue(":id_grupo", $id_grupo);
                $sql->bindValue(":foto", $foto);
                $sql->bindValue(":estadoCivil", $estadoCivil);
                $sql->bindValue(":localNascimento", $localNascimento);
                $sql->bindValue(":estadoNascimento", $estadoNascimento);
                $sql->bindValue(":nacionalidade", $nacionalidade);
                $sql->bindValue(":cor", $cor);
                $sql->bindValue(":numeroRg", $numeroRg);
                $sql->bindValue(":dataEmissaoRg", $dataEmissaoRg);
                $sql->bindValue(":orgaoEmissorRg", $orgaoEmissorRg);
                $sql->bindValue(":localEmissorRg", $localEmissorRg);
                $sql->bindValue(":cnh", $cnh);
                $sql->bindValue(":cep", $cep);
                $sql->bindValue(":endereco", $endereco);
                $sql->bindValue(":enderecoNumero", $enderecoNumero);
                $sql->bindValue(":enderecoComplemento", $enderecoComplemento);
                $sql->bindValue(":enderecoBairro", $enderecoBairro);
                $sql->bindValue(":enderecoCidade", $enderecoCidade);
                $sql->bindValue(":enderecoEstado", $enderecoEstado);
                $sql->bindValue(":pcd", $pcd);
                $sql->bindValue(":dependentes", $dependentes);
                $sql->execute();

            }
        }
    }
    public function addPessoaEdit($nome, $nomeSocial, $tipoPessoa, $dataNascimento, $sexo, $mae, $pai, $cpf, $celular, $email, $id_grupo){
    
  

        if($_SESSION['idPessoa'] != ""){
            $id = $_SESSION['idPessoa'];

            $sql = $this->pdo->prepare("UPDATE pessoas SET
                nome = :nome,
                nomeSocial = :nomeSocial,
                tipoPessoa = :tipoPessoa,
                dataNascimento = :dataNascimento,
                sexo = :sexo,
                mae = :mae,
                pai = :pai,
                cpf = :cpf,
                celular = :celular,
                email = :email,                                   
                id_grupo = :id_grupo                
                WHERE id = :id");
                $sql->bindValue(":id", $id);
                $sql->bindValue(":nome", $nome);
                $sql->bindValue(":nomeSocial", $nomeSocial);
                $sql->bindValue(":tipoPessoa", $tipoPessoa);
                $sql->bindValue(":dataNascimento", $dataNascimento);
                $sql->bindValue(":sexo", $sexo);
                $sql->bindValue(":mae", $mae);
                $sql->bindValue(":pai", $pai);
                $sql->bindValue(":cpf", $cpf);
                $sql->bindValue(":celular", $celular);
                $sql->bindValue(":email", $email);               
                $sql->bindValue(":id_grupo", $id_grupo);
                $sql->execute();
       
        }
    }

        public function alterarGrupo($id, $id_grupo){

            $sql = $this->pdo->prepare("UPDATE pessoas SET id_grupo = :id_grupo WHERE id = :id");
            $sql->bindValue(":id_grupo", $id_grupo);
            $sql->bindValue(":id", $id);
           
            $sql->execute();
        }



    public function updateInfoComp($id,
    $foto,
    $estadoCivil,
    $localNascimento,
    $estadoNascimento,
    $nacionalidade,
    $cor,
    $numeroRg,
    $dataEmissaoRg,
    $orgaoEmissorRg,
    $localEmissorRg,
    $cnh, $cep,
    $endereco,
    $enderecoNumero,
    $enderecoComplemento,
    $enderecoBairro,
    $enderecoCidade,
    $enderecoEstado,   
    $pcd,
    $dependentes){  
     $sql = $this->pdo->prepare("UPDATE pessoas SET
                                foto = :foto,
                                estadoCivil = :estadoCivil,
                                localNascimento = :localNascimento,
                                estadoNascimento = :estadoNascimento,
                                nacionalidade = :nacionalidade,
                                cor = :cor,
                                numeroRg = :numeroRg,
                                dataEmissaoRg = :dataEmissaoRg,
                                orgaoEmissorRg = :orgaoEmissorRg,
                                localEmissorRg = :localEmissorRg,
                                cnh = :cnh,
                                cep = :cep,
                                endereco = :endereco,
                                enderecoNumero = :enderecoNumero,
                                enderecoComplemento = :enderecoComplemento,
                                enderecoBairro = :enderecoBairro,
                                enderecoCidade = :enderecoCidade,
                                enderecoEstado = :enderecoEstado,
                                pcd = :pcd,
                                dependentes = :dependentes
                                WHERE id = :id");  
                                $sql->bindValue(":id", $id);
                                $sql->bindValue(":foto", $foto);
                                $sql->bindValue(":estadoCivil", $estadoCivil);
                                $sql->bindValue(":localNascimento", $localNascimento);
                                $sql->bindValue(":estadoNascimento", $estadoNascimento);
                                $sql->bindValue(":nacionalidade", $nacionalidade);
                                $sql->bindValue(":cor", $cor);
                                $sql->bindValue(":numeroRg", $numeroRg);
                                $sql->bindValue(":dataEmissaoRg", $dataEmissaoRg);
                                $sql->bindValue(":orgaoEmissorRg", $orgaoEmissorRg);
                                $sql->bindValue(":localEmissorRg", $localEmissorRg);
                                $sql->bindValue(":cnh", $cnh);
                                $sql->bindValue(":cep", $cep);
                                $sql->bindValue(":endereco", $endereco);
                                $sql->bindValue(":enderecoNumero", $enderecoNumero);
                                $sql->bindValue(":enderecoComplemento", $enderecoComplemento);
                                $sql->bindValue(":enderecoBairro", $enderecoBairro);
                                $sql->bindValue(":enderecoCidade", $enderecoCidade);
                                $sql->bindValue(":enderecoEstado", $enderecoEstado);
                                $sql->bindValue(":pcd", $pcd);
                                $sql->bindValue(":dependentes", $dependentes);
                                $sql->execute();

        

    }

public function editarInfoPessoa($foto, $estadoCivil, $localNascimento, $estadoNascimento, $nacionalidade, $cor, $numeroRg, $dataEmissaoRg, $orgaoEmissorRg,$localEmissorRg, $cnh,
        $cep, $endereco, $enderecoNumero, $enderecoComplemento, $enderecoBairro, $enderecoCidade, $enderecoEstado, $pcd, $dependentes){

        $id = $_SESSION['idPessoa'];
        $sql = $this->pdo->prepare("UPDATE pessoas SET
                                       
                                        foto = :foto,
                                        estadoCivil = :estadoCivil,
                                        localNascimento = :localNascimento,
                                        estadoNascimento = :estadoNascimento,
                                        nacionalidade = :nacionalidade,
                                        cor = :cor,
                                        numeroRg = :numeroRg,
                                        dataEmissaoRg = :dataEmissaoRg,
                                        orgaoEmissorRg = :orgaoEmissorRg,
                                        localEmissorRg = :localEmissorRg,
                                        cnh = :cnh,
                                        cep = :cep,
                                        endereco = :endereco,
                                        enderecoNumero = :enderecoNumero,
                                        enderecoComplemento = :enderecoComplemento,
                                        enderecoBairro = :enderecoBairro,
                                        enderecoCidade = :enderecoCidade,
                                        enderecoEstado = :enderecoEstado,
                                        pcd = :pcd,
                                        dependentes = :dependentes
                                        WHERE id = :id");
                    $sql->bindValue(":id", $id);
                    $sql->bindValue(":foto", $foto);
                    $sql->bindValue(":estadoCivil", $estadoCivil);
                    $sql->bindValue(":localNascimento", $localNascimento);
                    $sql->bindValue(":estadoNascimento", $estadoNascimento);
                    $sql->bindValue(":nacionalidade", $nacionalidade);
                    $sql->bindValue(":cor", $cor);
                    $sql->bindValue(":numeroRg", $numeroRg);
                    $sql->bindValue(":dataEmissaoRg", $dataEmissaoRg);
                    $sql->bindValue(":orgaoEmissorRg", $orgaoEmissorRg);
                    $sql->bindValue(":localEmissorRg", $localEmissorRg);
                    $sql->bindValue(":cnh", $cnh);
                    $sql->bindValue(":cep", $cep);
                    $sql->bindValue(":endereco", $endereco);
                    $sql->bindValue(":enderecoNumero", $enderecoNumero);
                    $sql->bindValue(":enderecoComplemento", $enderecoComplemento);
                    $sql->bindValue(":enderecoBairro", $enderecoBairro);
                    $sql->bindValue(":enderecoCidade", $enderecoCidade);
                    $sql->bindValue(":enderecoEstado", $enderecoEstado);
                    $sql->bindValue(":pcd", $pcd); 
                    $sql->bindValue(":dependentes", $dependentes);
                    $sql->execute();

        }
public function addArquivo($idPessoa, $title, $documento){
    $sql = $this->pdo->prepare("INSERT INTO arquivos SET idPessoa = :idPessoa, title = :title, documento = :documento");
    $sql->bindValue(":idPessoa", $idPessoa);
    $sql->bindValue(":title", $title);
    $sql->bindValue(":documento", $documento);
    $sql->execute();

}

public function verifcaFotoPessoa(){
    $id = $_SESSION['idPessoa'];
    $sql = $this->pdo->prepare("SELECT foto FROM pessoas WHERE id = :id");
    $sql->bindValue(":id", $id);
    $sql->execute();
    if($sql->rowCount() > 0){
        $sql = $sql->fetch();
        return $sql['foto'];
    }else{
        return false;
    }
}

public function excluirAruivo($id){

    $id = $id['id'];
    $sql = $this->pdo->prepare("SELECT documento FROM arquivos WHERE id_documento = :id"); 
    $sql->bindValue(":id", $id);
    $sql->execute();
    
    if($sql->rowCount() > 0){
        $sql = $sql->fetch();

        $nome_arquivo = $sql['documento'];
       
    }
    
    $sql = $this->pdo->prepare("DELETE FROM arquivos WHERE id_documento = :id");
    $sql->bindValue(":id", $id);
    $sql->execute();

    return $nome_arquivo;
}
public function excluirPrograma($id){

    $id = $id['id'];
    
    $sql = $this->pdo->prepare("DELETE FROM programas WHERE id = :id");
    $sql->bindValue(":id", $id);
    $sql->execute();

    
}

public function visualizarUmArquivo($id){
    $id = $id['id'];
    $sql = $this->pdo->prepare("SELECT documento FROM arquivos WHERE id_documento = :id");
    $sql->bindValue(":id", $id);
    $sql->execute();
    if($sql->rowCount() > 0){
        $sql = $sql->fetchAll();
                   
              $nome_arquivo = '/assests/arquivos/'.$sql[0]['documento'];
             

                if (file_exists($nome_arquivo)) {
                    $tipo_mime = mime_content_type( $nome_arquivo);
                    header('Content-Type: ' . $tipo_mime);
                    header('Content-Disposition: inline; filename="'. $nome_arquivo.'"');
                    header('Content-Length: ' . filesize($ $nome_arquivo));
                    header('Cache-Control: public');
                    header('Pragma: public');
                    readfile($ $nome_arquivo);
                    return $nome_arquivo;
                } else {
                    http_response_code(404);
                    echo 'Arquivo não encontrado no servidor.';
                }
    }
 
}
public function addPrograma($idPessoa, $programa) {
    $sql = $this->pdo->prepare("INSERT INTO programas (idPessoa, programa) VALUES (:idPessoa, :programa)");

    foreach ($programa as $programa) {
        $sql->bindValue(":idPessoa", $idPessoa);
        $sql->bindValue(":programa", $programa);
        $sql->execute();
    }
}


        
}