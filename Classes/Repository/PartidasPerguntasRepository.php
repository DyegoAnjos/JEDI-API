<?php

namespace Repository;

use DB\MySQL;
use PDO;

class PartidasPerguntasRepository
{
    private $MySQL;

    public const TABELA = 'partidasperguntas';

    public function __construct(){
        $this->MySQL = new MySQL();
    }

    /**
     * @return MySQL
     */
    public function getMySQL(): MySQL
    {
        return $this->MySQL;
    }

    public function rankingPorTema($tema)
    {
        $consulta =
            'SELECT jogador, pontuacao, (qtdAcertos/(qtdAcertos+qtdErros))*100 AS percentualAcertos, tempoGasto, COUNT(*) AS totalPartidas,
            ROW_NUMBER() OVER (ORDER BY pontuacao DESC, (qtdAcertos/(qtdAcertos+qtdErros))*100 DESC, tempoGasto ASC) AS posicao' .
            ' FROM ' . self::TABELA . ' JOIN tema2 ON tema2.id = ' . self::TABELA . '.tema ' .
            ' WHERE tema2.id = :tema AND avaliacaoJogo != "Em processo" ' .
            ' GROUP BY jogador ORDER BY posicao LIMIT 10';


        $stmt = $this->MySQL->getDb()->prepare($consulta);
        $stmt->bindParam(':tema', $tema);
        $stmt->execute();

        $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }
}