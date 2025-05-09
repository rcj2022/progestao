<?php

namespace src\DAO;

use src\models\Escola;

class EscolaDAO {

    private $pdo;

    public function __construct($connection) {
        $this->pdo=$connection;
    }

    public function listAll() : array {
        $array = [];
    
        try {
            $sql = $this->pdo->query('SELECT * FROM unidades');
    
            if ($sql && $sql->rowCount() > 0) {
                $data = $sql->fetchAll(\PDO::FETCH_ASSOC); // Usar FETCH_ASSOC para acessar os dados pelo nome da coluna
               
                foreach ($data as $item) {                                    
                    
                    $array[] = $item;
                    
                }
            }
        } catch (PDOException $e) {
            // Tratar a exceção de forma apropriada (log, mensagem de erro, etc.)
            error_log("Erro ao listar unidades: " . $e->getMessage());
            // Ou lançar a exceção novamente, dependendo da sua estratégia de tratamento de erros
            // throw $e;
        }
    
        return $array;
    }
 
  

    public function deleteUnidade($id){

       
        
        $sql = $this->pdo->prepare("DELETE FROM unidades WHERE id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();
    
        
    }

    public function adicionarUnidade(
        $nome, $zona, $inep, $cnpj, $email, $cel, $atocriacao, $decretocriacao, $decretoAutorizacao,
        $diretorUnidade, $cpfDiretor, $decretoDiretor, $secretarioUnidade, $cpfSecretario, $decretoSecretario,
        $especialistaUnidade, $cpfEspecialista, $cep, $endereco, $numero, $bairro, $pais, $uf, $ufNome, $cidade
    ) {
        $sql = $this->pdo->prepare("
            INSERT INTO unidades (
                nomeUnidade, zonaUnidade, codigoInep, cnpjUnidade, emailUnidade, telefoneUnidade,
                atoDeCriacao, decretoCriacao, decretoAutorizacao,
                diretorUnidade, cpfDiretor, decretoDiretor,
                secretarioUnidade, cpfSecretario, decretoSecretario,
                especialistaUnidade, cpfEspecialista,
                cep, endereco, numero, bairro,
                pais, uf, ufNome, cidade
            ) VALUES (
                :nomeUnidade, :zonaUnidade, :codigoInep, :cnpjUnidade, :emailUnidade, :telefoneUnidade,
                :atoDeCriacao, :decretoCriacao, :decretoAutorizacao,
                :diretorUnidade, :cpfDiretor, :decretoDiretor,
                :secretarioUnidade, :cpfSecretario, :decretoSecretario,
                :especialistaUnidade, :cpfEspecialista,
                :cep, :endereco, :numero, :bairro,
                :pais, :uf, :ufNome, :cidade
            )
        ");
    
        $sql->bindValue(":nomeUnidade", $nome);
        $sql->bindValue(":zonaUnidade", $zona);
        $sql->bindValue(":codigoInep", $inep);
        $sql->bindValue(":cnpjUnidade", $cnpj);
        $sql->bindValue(":emailUnidade", $email);
        $sql->bindValue(":telefoneUnidade", $cel);
        $sql->bindValue(":atoDeCriacao", $atocriacao);
        $sql->bindValue(":decretoCriacao", $decretocriacao);
        $sql->bindValue(":decretoAutorizacao", $decretoAutorizacao);
        $sql->bindValue(":diretorUnidade", $diretorUnidade);
        $sql->bindValue(":cpfDiretor", $cpfDiretor);
        $sql->bindValue(":decretoDiretor", $decretoDiretor);
        $sql->bindValue(":secretarioUnidade", $secretarioUnidade);
        $sql->bindValue(":cpfSecretario", $cpfSecretario);
        $sql->bindValue(":decretoSecretario", $decretoSecretario);
        $sql->bindValue(":especialistaUnidade", $especialistaUnidade);
        $sql->bindValue(":cpfEspecialista", $cpfEspecialista);
        $sql->bindValue(":cep", $cep);
        $sql->bindValue(":endereco", $endereco);
        $sql->bindValue(":numero", $numero);
        $sql->bindValue(":bairro", $bairro);
        $sql->bindValue(":pais", $pais);
        $sql->bindValue(":uf", $uf);
        $sql->bindValue(":ufNome", $ufNome);
        $sql->bindValue(":cidade", $cidade);
    
        $sql->execute();
    }

    public function editarInfoUnidade($id, $atocriacao ,$decretocriacao, $decretoAutorizacao, $diretorUnidade, $cpfDiretor, $decretoDiretor, $secretarioUnidade, $cpfSecretario, $decretoSecretario, $especialistaUnidade,  $cpfEspecialista, $cep,  $endereco,  $numero, $bairro, $pais,  $uf,  $ufNome, $cidade){
       
        $id = $_SESSION['idescola'];

        $sql = $this->pdo->prepare("UPDATE unidades SET

                                atoDeCriacao = :atoDeCriacao,
                                decretoCriacao = :decretoCriacao,
                                decretoAutorizacao = :decretoAutorizacao,
                                diretorUnidade = :diretorUnidade,
                                cpfDiretor = :cpfDiretor,
                                decretoDiretor = :decretoDiretor,
                                secretarioUnidade = :secretarioUnidade,
                                cpfSecretario = :cpfSecretario,
                                decretoSecretario = :decretoSecretario,
                                especialistaUnidade = :especialistaUnidade,
                                cpfEspecialista = :cpfEspecialista,
                                cep = :cep,
                                endereco = :endereco,
                                numero = :numero,
                                bairro = :bairro,
                                pais = :pais,
                                uf = :uf,
                                ufNome = :ufNome,
                                cidade = :cidade
                          
                                WHERE id = :id");  
                                $sql->bindValue(":id", $id);
                                $sql->bindValue(":atoDeCriacao", $atocriacao);
                                $sql->bindValue(":decretoCriacao", $decretocriacao);
                                  $sql->bindValue(":decretoAutorizacao", $decretoAutorizacao);
                                $sql->bindValue(":diretorUnidade", $diretorUnidade);
                                $sql->bindValue(":cpfDiretor", $cpfDiretor);
                                $sql->bindValue(":decretoDiretor", $decretoDiretor);
                                $sql->bindValue(":secretarioUnidade", $secretarioUnidade);
                                $sql->bindValue(":cpfSecretario", $cpfSecretario);
                                $sql->bindValue(":decretoSecretario", $decretoSecretario);
                                $sql->bindValue(":especialistaUnidade", $especialistaUnidade);
                                $sql->bindValue(":cpfEspecialista", $cpfEspecialista);
                                $sql->bindValue(":cep", $cep);
                                $sql->bindValue(":endereco", $endereco);
                                $sql->bindValue(":numero", $numero);
                                $sql->bindValue(":bairro", $bairro);
                                $sql->bindValue(":pais", $pais);
                                $sql->bindValue(":uf", $uf);
                                $sql->bindValue(":ufNome", $ufNome);
                                $sql->bindValue(":cidade", $cidade);
                                $sql->execute();




        
    }

    public function addUnidadeEdit($id, $nome, $zona, $inep, $cnpj, $email, $cel){

        

      
    
        $sql = $this->pdo->prepare("UPDATE unidades SET nomeUnidade = :nomeUnidade, zonaUnidade = :zonaUnidade, codigoInep = :codigoInep, cnpjUnidade = :cnpjUnidade, emailUnidade = :emailUnidade, telefoneUnidade = :telefoneUnidade WHERE id = :id");
        
        $sql->bindValue(":id", $id);
        $sql->bindValue(":nomeUnidade", $nome);
        $sql->bindValue(":zonaUnidade", $zona);
        $sql->bindValue(":codigoInep", $inep);
        $sql->bindValue(":cnpjUnidade", $cnpj);
        $sql->bindValue(":emailUnidade", $email);
        $sql->bindValue(":telefoneUnidade", $cel);
       
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

    public function deleteUser($id){
        $sql = $this->pdo->prepare("DELETE FROM users WHERE id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();
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
    public function addPessoa(
            $nome, $nomeSocial, $tipoPessoa, $dataNascimento, $sexo, $mae, $pai, $cpf, $celular, $email, $senha, $id_grupo,
            $foto,$estadoCivil, $localNascimento, $estadoNascimento, $nacionalidade, $cor, $numeroRg, $dataEmissaoRg, $orgaoEmissorRg, $localEmissorRg, $cnh,
            $cep, $endereco, $enderecoNumero, $enderecoComplemento, $enderecoBairro, $enderecoCidade, $enderecoEstado, $enderecoPais,
            $pcd, $dependentes){

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
                senha,
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
                enderecoPais,
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
                :senha,
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
                :enderecoPais, 
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
                $sql->bindValue(":senha", $senha);
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
                $sql->bindValue(":enderecoPais", $enderecoPais);
                $sql->bindValue(":pcd", $pcd);
                $sql->bindValue(":dependentes", $dependentes);
                $sql->execute();

            }

        

public function listarUnidade($id){
   
    $sql = $this->pdo->prepare("SELECT * FROM unidades WHERE id = :id");
    $sql->bindValue(":id", $id);
    $sql->execute();
    
    if ($sql->rowCount() > 0) {
        $data = $sql->fetch(\PDO::FETCH_ASSOC); // Retorna os dados como uma array associativa
        return $data;
    } else {
        return false;
    }
}



}