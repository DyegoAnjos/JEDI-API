<?php

namespace Service;

use InvalidArgumentException;
use Repository\PartidasPerguntasRepository;
use Util\ConstantesGenericasUtil;

class PartidasPerguntasService
{
    /**
     * @var array|null
     */
    private $dados;
    private $PartidasPerguntasRepository;

    public function __construct($dados = [])
    {
        $this->dados = $dados;
        $this->PartidasPerguntasRepository = new PartidasPerguntasRepository();
    }
    public function listarTodasPartidas()
    {
            $resultado = $this->PartidasPerguntasRepository->listarTodasPartidasRepository();

            if($resultado !== null){
                return $resultado;
            }

            throw new \InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_LISTAR_TABELA_VAZIA);

    }
    public function listarPartida()
    {
        $id = $this->dados['id'] ?? null;

            $resultado = $this->PartidasPerguntasRepository->listarPartidasRepository($id);

            if($resultado !== null){
                return $resultado;
            }

            throw new \InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_LISTAR_TABELA_VAZIA);
    }

    public function serviceRanking()
    {
        $idPartida = $this->dados['idPartida'] ?? null;
        $jogador = $this->dados['jogador'] ?? null;
        if($idPartida !== null){
            $resultado = $this->PartidasPerguntasRepository->repositoriRanking($idPartida, $jogador);

            if(count($resultado) > 0){
                return $resultado;
            }

            elseif (count($resultado) === 0){
                throw new \InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_RANKING_SEM_REGISTRO);
            }
        }

        throw new \InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_RANKING_BODY);
    }

    public function serviceSalvarPartida()
    {
        $id = $this->dados['id'] ?? null;
        $jogadorEmail = $this->dados['jogadorEmail'] ?? null;
        $dataHoraInicio = $this->dados['dataHoraInicio'] ?? null;
        $nome = $this->dados['nome'] ?? null;
        $idade = $this->dados['idade'] ?? null;
        $autoAvaliacao = $this->dados['autoAvaliacao'] ?? null;
        $avatar = $this->dados['avatar'] ?? null;
        $tempoGasto = $this->dados['tempoGasto'] ?? null;



        if($id !== null && $jogadorEmail !== null && $dataHoraInicio !== null && $autoAvaliacao !== null && $avatar !== null && $tempoGasto !== null){
            $resultado = $this->PartidasPerguntasRepository->repositorySalvarPartida($id, $jogadorEmail, $dataHoraInicio, $nome, $idade, $autoAvaliacao, $avatar, $tempoGasto);

            if($resultado !== null && $resultado > 0){
                if ($id !== -1){
                    $this->dados['id'] = $resultado;
                    $logPerguntas = new LogPerguntasService($this->dados);
                    $resultadoLogPerguntas = $logPerguntas->inserirLogPerguntasService();
                    $this->PartidasPerguntasRepository->repositoryAtualizarAcertoseErros($resultado);
                }

                return ['id' => $resultado];
            }

            else{
                throw new \InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_SALVARPARTIDA_SEM_REGISTRO . " Id passado: " . $id);
            }
        }

        throw new \InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_SALVARPARTIDA_BODY);
    }
}