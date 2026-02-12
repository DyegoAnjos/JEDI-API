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

    public function rankingPorTema($tema, $jogador)
    {
        // Parte 1: Top 10
        $consulta = '(SELECT jogador, MAX(pontuacao) AS pontuacao, 
        (SUM(qtdAcertos)/(SUM(qtdAcertos)+SUM(qtdErros)))*100 AS percentualAcertos, 
        MIN(tempoGasto) AS tempoGasto, COUNT(*) AS totalPartidas, 
        ROW_NUMBER() OVER (ORDER BY MAX(pontuacao) DESC, (SUM(qtdAcertos)/(SUM(qtdAcertos)+SUM(qtdErros)))*100 DESC, MIN(tempoGasto) ASC) AS posicao
        FROM ' . self::TABELA . ' JOIN tema2 ON tema2.id = ' . self::TABELA . '.tema
        WHERE tema2.id = :tema AND avaliacaoJogo != "Em processo"
        GROUP BY jogador 
        ORDER BY posicao ASC LIMIT 10) ';

        if ($jogador !== null) {
            // Parte 2: Linha do Usuário (Sem aspas no :jogador)
            $consulta .= ' UNION ALL 
        SELECT * FROM ( 
        
            SELECT jogador, MAX(pontuacao) AS pontuacao, 
            (SUM(qtdAcertos)/(SUM(qtdAcertos)+SUM(qtdErros)))*100 AS percentualAcertos, 
            MIN(tempoGasto) AS tempoGasto, COUNT(*) AS totalPartidas, 
            ROW_NUMBER() OVER (ORDER BY MAX(pontuacao) DESC, (SUM(qtdAcertos)/(SUM(qtdAcertos)+SUM(qtdErros)))*100 DESC, MIN(tempoGasto) ASC) AS posicao
            FROM ' . self::TABELA . ' 
            JOIN tema2 ON tema2.id = ' . self::TABELA . '.tema
            WHERE tema2.id = :tema AND avaliacaoJogo != "Em processo"
            GROUP BY jogador
        ) AS ranking_global
        WHERE jogador = :jogador'; // Removidas as aspas aqui
        }

        $stmt = $this->MySQL->getDb()->prepare($consulta);

        // O bind deve ser feito APÓS o prepare
        $stmt->bindParam(':tema', $tema);
        if ($jogador !== null) {
            $stmt->bindParam(':jogador', $jogador);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}