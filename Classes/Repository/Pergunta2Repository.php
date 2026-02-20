<?php

namespace Repository;

use DB\MySQL;
use PDO;

class Pergunta2Repository
{

    private $MySQL;

    public const TABELA = 'pergunta2';

    public function __construct(){
        $this->MySQL = new MySQL();
    }

    public function getMySQL(): MySQL
    {
        return $this->MySQL;
    }

    public function sortearPerguntas($quantidade)
    {
        $consuta = 'SELECT * FROM ' . self::TABELA .' ORDER BY RAND() LIMIT :quantidade';

        $stmt = $this->MySQL->getDb()->prepare($consuta);
        $stmt->bindValue(':quantidade', $quantidade, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

}