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

    public function repositoriRanking($idPartida, $jogador)
    {
        // Adicionei espaços antes de JOIN e WHERE para evitar erros de concatenação
        $consulta = '(SELECT jogador, MAX(pontuacao) AS pontuacao, 
        (SUM(qtdAcertos)/(SUM(qtdAcertos)+SUM(qtdErros)))*100 AS percentualAcertos, 
        MIN(tempoGasto) AS tempoGasto, COUNT(*) AS totalPartidas, 
        ROW_NUMBER() OVER (ORDER BY MAX(pontuacao) DESC, (SUM(qtdAcertos)/(SUM(qtdAcertos)+SUM(qtdErros)))*100 DESC, MIN(tempoGasto) ASC) AS posicao
        FROM ' . self::TABELA . ' 
        JOIN tema2 ON tema2.id = ' . self::TABELA . '.tema
        WHERE ' . self::TABELA . '.idPartida = :idPartida AND avaliacaoJogo != "Em processo"
        GROUP BY jogador 
        ORDER BY posicao ASC LIMIT 10)';

        if ($jogador !== null) {
            $consulta .= ' UNION ALL 
        SELECT * FROM ( 
            SELECT jogador, MAX(pontuacao) AS pontuacao, 
            (SUM(qtdAcertos)/(SUM(qtdAcertos)+SUM(qtdErros)))*100 AS percentualAcertos, 
            MIN(tempoGasto) AS tempoGasto, COUNT(*) AS totalPartidas, 
            ROW_NUMBER() OVER (ORDER BY MAX(pontuacao) DESC, (SUM(qtdAcertos)/(SUM(qtdAcertos)+SUM(qtdErros)))*100 DESC, MIN(tempoGasto) ASC) AS posicao
            FROM ' . self::TABELA . ' 
            JOIN tema2 ON tema2.id = ' . self::TABELA . '.tema
            WHERE avaliacaoJogo != "Em processo"
            GROUP BY jogador
        ) AS ranking_global
        WHERE jogador = :jogador';
        }

        try {
            $stmt = $this->MySQL->getDb()->prepare($consulta);
            $stmt->bindParam(':idPartida', $idPartida);

            if ($jogador !== null) {
                $stmt->bindParam(':jogador', $jogador);
            }

            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            // Se der erro aqui, provavelmente é o ROW_NUMBER() que o seu banco não aceita
            // Retornar um erro amigável em vez de travar a API
            throw new \InvalidArgumentException("Erro no banco de dados. Verifique a compatibilidade do MySQL.");
        }
    }
}