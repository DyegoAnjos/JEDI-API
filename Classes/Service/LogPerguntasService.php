<?php

namespace Service;

use Repository\LogPerguntasRepository;
use Util\ConstantesGenericasUtil;

class LogPerguntasService
{
    private $dados;
    private $logPerguntasRepository;

    public function __construct($dados = []){
        $this->dados = $dados;
        $this->logPerguntasRepository = new LogPerguntasRepository();
    }

    public function inserirLogPerguntasService(){

        $jogadaAInserir = $this->dados['jogadas'] ?? null;
        $jogadaAInserir = end($jogadaAInserir);

        $id = $this->dados['id'] ?? null;
        $jogadorEmail = $this->dados['jogadorEmail'] ?? null;
        $dataHoraInicio = $this->dados['dataHoraInicio'] ?? null;
        $nome = $this->dados['nome'] ?? null;
        $idade = $this->dados['idade'] ?? null;
        $avatar = $this->dados['avatar'] ?? null;

        $jogadaId = $jogadaAInserir['jogadaId'] ?? null;
        $noticiaId = $jogadaAInserir['noticiaId'] ?? null;
        $avaliacaoCorreta = $jogadaAInserir['avaliacaoCorreta'] ?? null;
        $tempoResposta = $jogadaAInserir['tempoResposta'] ?? null;
        $posicaoAvatar = $jogadaAInserir['posicaoAvatar'] ?? null;

        echo $id . '<br>';
        echo $jogadorEmail . '<br>';
        echo $dataHoraInicio . '<br>';
        echo $nome . '<br>';
        echo $idade . '<br>';
        echo $avatar . '<br>';
        echo $jogadaId . '<br>';
        echo $noticiaId . '<br>';
        echo $avaliacaoCorreta . '<br>';
        echo $tempoResposta . '<br>';
        echo $posicaoAvatar . '<br>';

        if($id !== null && $jogadorEmail !== null && $dataHoraInicio !== null && $nome !== null && $idade !== null && $avatar !== null && $jogadaId !== null && $noticiaId !== null && $avaliacaoCorreta !== null && $tempoResposta !== null && $posicaoAvatar !== null){
            $resultado = $this->logPerguntasRepository->inserirLogPerguntasRepository($id , $jogadorEmail , $dataHoraInicio , $nome , $idade , $avatar , $jogadaId , $noticiaId , $avaliacaoCorreta , $tempoResposta , $posicaoAvatar);

            return $resultado;
        }

        else{
            throw new \InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_GENERICO);
        }
    }
}