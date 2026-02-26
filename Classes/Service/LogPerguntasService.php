<?php

namespace Service;

use Repository\LogPerguntasRepository;

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

        $id = $jogadaAInserir['id'] ?? null;
        $jogadorEmail = $jogadaAInserir['jogadorEmail'] ?? null;
        $dataHoraInicio = $jogadaAInserir['dataHoraInicio'] ?? null;
        $nome = $jogadaAInserir['nome'] ?? null;
        $idade = $jogadaAInserir['idade'] ?? null;
        $avatar = $jogadaAInserir['avatar'] ?? null;

        $jogadaId = $jogadaAInserir['jogadaId'] ?? null;
        $noticiaId = $jogadaAInserir['noticiaId'] ?? null;
        $avaliacaoCorreta = $jogadaAInserir['avaliacaoCorreta'] ?? null;
        $tempoResposta = $jogadaAInserir['tempoResposta'] ?? null;
        $posicaoAvatar = $jogadaAInserir['posicaoAvatar'] ?? null;

        if($id && $jogadorEmail && $dataHoraInicio && $nome && $idade && $autoAvaliacao && $avatar && $jogadaId && $noticiaId && $avaliacaoCorreta && $tempoResposta && $posicaoAvatar){
            $resultado = $this->logPerguntasRepository->inserirLogPerguntasRepository($id , $jogadorEmail , $dataHoraInicio , $nome , $idade , $avatar , $jogadaId , $noticiaId , $avaliacaoCorreta , $tempoResposta , $posicaoAvatar);
        }

        else{
            throw new \InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_GENERICO);
        }
    }
}