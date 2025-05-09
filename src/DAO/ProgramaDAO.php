<?php

namespace src\DAO;


use src\models\Programa;

class ProgramaDAO {

    private $pdo;

    public function __construct($connection) {
        $this->pdo=$connection;
    }

    public function listAll() : array {

        $array = [];

        $sql = $this->pdo->query('SELECT * FROM programas');

        

        

        if ($sql->rowCount() > 0) {
                      
            $data = $sql->fetchAll();
            foreach ($data as $item) {
               
                $pessoa = new Programa();
            
                $pessoa->setId($item['id']);
                $pessoa->setNome($item['nome']); 
               
                
                $array[] = $pessoa;
            }
        }

        return $array;
    }
}