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
    public function listarTodasPartidasRepository()
    {
        try{
            $consulta = 'SELECT * FROM '. self::TABELA;
            $stmt = $this->MySQL->getDb()->prepare($consulta);
            $stmt->execute();

            $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (PDOException $e) {
            throw new \InvalidArgumentException("Erro SQL: " . $e->getMessage());
        }
    }
    public function listarPartidasRepository($id){
        try{
            if($id !== ""){
                $id = " WHERE " . $id;
            }

            $consulta = 'SELECT * FROM '. self::TABELA . $id;
            $stmt = $this->MySQL->getDb()->prepare($consulta);
            $stmt->execute();

            $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (PDOException $e) {
            throw new \InvalidArgumentException("Erro SQL: " . $e->getMessage());
        }
    }

    public function repositoriRanking($idPartida, $jogador)
    {
        try {
            // 1. Busca o Ranking de TODOS os jogadores (sem LIMIT 10 aqui)
            // Isso garante que a ordenação e os valores sejam consistentes para todos
            $sqlGeral = "SELECT idPartida, jogador, ". self::TABELA .". nome, MAX(pontuacao) AS pontuacao, 
                    (SUM(qtdAcertos)/(SUM(qtdAcertos)+SUM(qtdErros)))*100 AS percentualAcertos, 
                    MIN(tempoGasto) AS tempoGasto, COUNT(*) AS totalPartidas
                    FROM " . self::TABELA . " 
                    GROUP BY login
                    UNION ALL
                    SELECT idPartida, jogador, ". self::TABELA .". nome, pontuacao, 
                    (SUM(qtdAcertos)/(SUM(qtdAcertos)+SUM(qtdErros)))*100 AS percentualAcertos, 
                    tempoGasto, COUNT(*) AS totalPartidas FROM " . self::TABELA . " WHERE idPartida = :idPartida
                    ORDER BY pontuacao DESC, percentualAcertos DESC, tempoGasto ASC;";

            $stmt = $this->MySQL->getDb()->prepare($sqlGeral);
            $stmt->bindValue(':idPartida', $idPartida, PDO::PARAM_INT);
            $stmt->execute();
            $rankingCompleto = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            $top10 = [];
            // 2. Numerar TODOS e separar o que precisamos
            foreach ($rankingCompleto as $index => $linha) {
                $posicaoAtual = (int)($index + 1);


                    // Monta o objeto com a posição correta
                $item = [
                    "idPartida" => (int) $linha['idPartida'],
                    "nome" => $linha['nome'],
                    "jogador" => $linha['jogador'],
                    "pontuacao" => $linha['pontuacao'],
                    "percentualAcertos" => $linha['percentualAcertos'],
                    "tempoGasto" => $linha['tempoGasto'],
                    "totalPartidas" => $linha['totalPartidas'],
                    "posicao" => $posicaoAtual
                ];

                if($item['idPartida'] == $idPartida){
                    $jogadorAtual = $item;
                    $sqlGeral = "SELECT autoAvaliacao, avaliacaoJogo FROM " . self::TABELA . " WHERE idPartida = :idPartida";
                    $stmt = $this->MySQL->getDb()->prepare($sqlGeral);
                    $stmt->bindValue(':idPartida', $idPartida, PDO::PARAM_INT);
                    $stmt->execute();
                    $avaliacao = $stmt->fetch(\PDO::FETCH_ASSOC);
                    $jogadorAtual['autoAvaliacao'] = $avaliacao['autoAvaliacao'];
                    $jogadorAtual['avaliacaoJogo'] = $avaliacao['avaliacaoJogo'];
                }

                // Se estiver entre os 10 primeiros, vai para o Top 10
                if ($posicaoAtual <= 10) {
                    $top10[] = $item;
                }
            }

            $top10[] = $jogadorAtual;

            return $top10;

        } catch (\PDOException $e) {
            throw new \InvalidArgumentException("Erro SQL: " . $e->getMessage());
        }
    }

    public function repositorySalvarPartida($id, $jogadorEmail, $dataHoraInicio, $nome, $idade, $autoAvaliacao, $avatar, $tempoGasto)
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
                    " (dtJogo, login, tema,jogador, idade, pontuacao, tempoGasto,
                    autoAvaliacao, avaliacaoJogo, nome)
                    SELECT :dataHoraInicio, :jogadorEmail, 17, :avatar, :idade, 1000,  
                    :tempoGasto, :autoAvaliacao, 'Noob', :nome";
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

            if ($id !== -1){
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
                if($stmt->rowCount() <= 0){
                    $resultado = -1;
                }
                else{
                    return $id;
                }

            }
            return $resultado;

        } catch (\PDOException $e) {
            throw new \InvalidArgumentException("Erro SQL: " . $e->getMessage());
        }
    }

    public function repositoryAtualizarAcertoseErros($id)
    {

        $sqlGeral = "(SELECT (p.qtdAcertos / t.total) * 100 FROM partidasPerguntas p JOIN (SELECT COUNT(*) as total FROM logPerguntas WHERE idPartida = :id) t WHERE p.idPartida = :id)";
        $stmt = $this->MySQL->getDb()->prepare($sqlGeral);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $percentAcertos = $stmt->fetchColumn();

        if ($percentAcertos >= 80.0)
            $aval = "Proplayer";
        else if (($percentAcertos >= 60.0) && ($percentAcertos < 80.0))
            $aval = "Avançado";
        else if (($percentAcertos >= 40.0) && ($percentAcertos < 60.0))
            $aval = "Casual";
        else if (($percentAcertos >= 20.0) && ($percentAcertos < 40.0))
            $aval = "Iniciante";
        else if ($percentAcertos < 20.0)
            $aval = "Noob";

        $sqlGeral = "UPDATE " . self::TABELA . " 
                SET 
                    `qtdAcertos` = (SELECT COUNT(*) FROM logPerguntas WHERE idPartida = :id AND tema = 17 AND respCerta = respDada),
                    
                    `qtdErros` = (SELECT COUNT(*) FROM logPerguntas WHERE idPartida = :id AND tema = 17 AND respCerta != respDada),
                    
                    `pontuacao` = (
                        SELECT pontos FROM (
                            SELECT (100000 * (p2.qtdAcertos / t.total) + (100 * t.total)) AS pontos 
                            FROM " . self::TABELA . " p2 
                            JOIN (SELECT COUNT(*) as total FROM logPerguntas WHERE idPartida = :id) t 
                            WHERE p2.idPartida = :id
                        ) AS temp
                    ),
                    
                    `avaliacaoJogo` = :avaliacao
                WHERE idPartida = :id";
                $stmt = $this->MySQL->getDb()->prepare($sqlGeral);
                $stmt->bindParam(':id', $id);
                $stmt->bindParam(':avaliacao', $aval);
                $stmt->execute();

    }
}