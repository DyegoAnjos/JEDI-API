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

    public function serviceRanking()
    {
        $idPartida = $this->dados['idPartida'] ?? null;
        $jogador = $this->dados['jogador'] ?? null;
        if($idPartida){
            $resultado = $this->PartidasPerguntasRepository->repositoriRanking($idPartida, $jogador);

            if(count($resultado) > 0){
                return $resultado;
            }

            elseif (count($resultado) === 0){
                throw new \InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_RANKING_SEM_REGISTRO);
            }
        }

        throw new \InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_ID_TEMA_OBRIGATORIO);
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

        if($id && $jogadorEmail && $dataHoraInicio && $autoAvaliacao && $avatar && $tempoGasto){
            $resultado = $this->PartidasPerguntasRepository->repositoriSalvarPartida($id, $jogadorEmail, $dataHoraInicio, $nome, $idade, $autoAvaliacao, $avatar, $tempoGasto);
        }
    }
}