<?php

namespace src\DAO;


use src\models\Evento;

class EventoDAO {

    private $pdo;

    public function __construct($connection) {
        $this->pdo=$connection;
    }

    public function listAll() : array {
        $array = [];
    
        try {
            $sql = $this->pdo->query('SELECT * FROM eventos');
    
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

    public function AddEvento($nome, $dataInicial, $dataFinal) {
        $sql = $this->pdo->prepare("INSERT INTO eventos (nome, dataInicial, dataFinal) VALUES (:nome, :dataInicial, :dataFinal)");
        $sql->bindValue(":nome", $nome);
        $sql->bindValue(":dataInicial", $dataInicial);
        $sql->bindValue(":dataFinal", $dataFinal);
        $sql->execute();
    }

    public function excluirEvento($id){

        $id = $id['id'];
        
        $sql = $this->pdo->prepare("DELETE FROM eventos WHERE id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();
    
        
    }
    
}