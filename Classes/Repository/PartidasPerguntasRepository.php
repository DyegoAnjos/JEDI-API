<?php

namespace Repository;

use DB\MySQL;
use PDO;

class PartidasPerguntasRepository
{
    private $MySQL;

    public const TABELA = 'partidasPerguntas';

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
        try {
            // 1. Busca o Ranking de TODOS os jogadores (sem LIMIT 10 aqui)
            // Isso garante que a ordenação e os valores sejam consistentes para todos
            $sqlGeral = "SELECT jogador, MAX(pontuacao) AS pontuacao, 
                    (SUM(qtdAcertos)/(SUM(qtdAcertos)+SUM(qtdErros)))*100 AS percentualAcertos, 
                    MIN(tempoGasto) AS tempoGasto, COUNT(*) AS totalPartidas
                    FROM " . self::TABELA . " 
                    JOIN tema2 ON tema2.id = " . self::TABELA . ".tema
                    WHERE " . self::TABELA . ".idPartida = :idPartida AND avaliacaoJogo != 'Em processo'
                    GROUP BY jogador 
                    ORDER BY pontuacao DESC, percentualAcertos DESC, tempoGasto ASC";

            $stmt = $this->MySQL->getDb()->prepare($sqlGeral);
            $stmt->bindParam(':idPartida', $idPartida);
            $stmt->execute();
            $rankingCompleto = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            $top10 = [];
            $dadosJogadorLogado = null;

            // 2. Numerar TODOS e separar o que precisamos
            foreach ($rankingCompleto as $index => $linha) {
                $posicaoAtual = (int)($index + 1);

                // Monta o objeto com a posição correta
                $item = [
                    "jogador" => $linha['jogador'],
                    "pontuacao" => $linha['pontuacao'],
                    "percentualAcertos" => $linha['percentualAcertos'],
                    "tempoGasto" => $linha['tempoGasto'],
                    "totalPartidas" => $linha['totalPartidas'],
                    "posicao" => $posicaoAtual
                ];

                // Se estiver entre os 10 primeiros, vai para o Top 10
                if ($posicaoAtual <= 10) {
                    $top10[] = $item;
                }

                // Se for o jogador que buscamos, guardamos uma cópia para o final
                if ($jogador !== null && $linha['jogador'] == $jogador) {
                    $dadosJogadorLogado = $item;
                }
            }

            // 3. Adiciona o jogador logado ao final (mesmo que ele já esteja no Top 10)
            if ($dadosJogadorLogado !== null) {
                $top10[] = $dadosJogadorLogado;
            }

            return $top10;

        } catch (\PDOException $e) {
            throw new \InvalidArgumentException("Erro SQL: " . $e->getMessage());
        }
    }

    public function repositoriSalvarPartida($id, $jogadorEmail, $dataHoraInicio, $nome, $idade, $autoAvaliacao, $avatar, $tempoGasto)
    {
        if ($nome === null) {
            $nome = $jogadorEmail;
        }

        if ($idade === null) {
            $idade = 0;
        }

        try {

            if($id === -1){
                $sqlGeral = "INSERT INTO " . self::TABELA .
                    " (dtJogo, login, tema,jogador, idade, pontuacao, qtdAcertos, qtdErros, tempoGasto,
                    autoAvaliacao, avaliacaoJogo, nome)
                    SELECT :dataHoraInicio, :jogadorEmail, 17, :avatar, :idade, 1000,  
                    (SELECT COUNT(*) FROM logPerguntas lp JOIN partidasperguntas pp ON pp.idPartida = lp.idPartida WHERE lp.tema = 17 AND lp.respCerta = lp.respDada),
                    (SELECT COUNT(*) FROM logPerguntas lp JOIN partidasperguntas pp ON pp.idPartida = lp.idPartida WHERE lp.tema = 17 AND lp.respCerta != lp.respDada),
                    :tempoGasto, :autoAvaliacao, 'NOOB', :nome";
                $stmt = $this->MySQL->getDb()->prepare($sqlGeral);
                $stmt->bindParam(':dataHoraInicio', $dataHoraInicio);
                $stmt->bindParam(':jogadorEmail', $jogadorEmail);
                $stmt->bindParam(':avatar', $avatar);
                $stmt->bindParam(':idade', $idade);
                $stmt->bindParam(':tempoGasto', $tempoGasto);
                $stmt->bindParam(':autoAvaliacao', $autoAvaliacao);
                $stmt->bindParam(':nome', $nome);
                $stmt->execute();
                $resultado = $this->MySQL->getDb()->lastInsertId();
            }

            else{
                $sqlGeral = "UPDATE " . self::TABELA . " 
                    SET `dtJogo` = :dataHoraInicio, 
                        `login` = :jogadorEmail,
                        `jogador` = :avatar, 
                        `idade` = :idade, 
                        `pontuacao` = 150,
                        `qtdAcertos` = (SELECT COUNT(*) FROM logPerguntas lp WHERE lp.idPartida = :id AND lp.tema = 17 AND lp.respCerta = lp.respDada),
                        `qtdErros` = (SELECT COUNT(*) FROM logPerguntas lp WHERE lp.idPartida = :id AND lp.tema = 17 AND lp.respCerta != lp.respDada),
                        `tempoGasto` = :tempoGasto, 
                        `autoAvaliacao` = :autoAvaliacao,
                        `avaliacaoJogo` = 'Pro', 
                        `nome` = :nome 
                        WHERE `idPartida` = :id";

                $stmt = $this->MySQL->getDb()->prepare($sqlGeral);

                $stmt->bindParam(':dataHoraInicio', $dataHoraInicio);
                $stmt->bindParam(':id', $id);
                $stmt->bindParam(':jogadorEmail', $jogadorEmail);
                $stmt->bindParam(':avatar', $avatar);
                $stmt->bindParam(':idade', $idade);
                $stmt->bindParam(':tempoGasto', $tempoGasto);
                $stmt->bindParam(':autoAvaliacao', $autoAvaliacao);
                $stmt->bindParam(':nome', $nome);

                $stmt->execute();

                $resultado = $stmt->rowCount();
            }

            return $resultado;

        } catch (\PDOException $e) {
            throw new \InvalidArgumentException("Erro SQL: " . $e->getMessage());
        }
    }
}