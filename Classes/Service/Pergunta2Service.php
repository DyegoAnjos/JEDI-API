<?php

namespace Service;

use Repository\Pergunta2Repository;
use Util\ConstantesGenericasUtil;

class Pergunta2Service
{
    /**
     * @var array|null
     */
    private $dados;

    private $Pergunta2Repository;

    public function __construct($dados = [])
    {
        $this->dados = $dados;
        $this->Pergunta2Repository = new Pergunta2Repository();
    }

    function pegarPerguntasService()
    {
        $quantidade = $this->dados['quantidade'] ?? null;

        if ($quantidade){
            $result = $this->Pergunta2Repository->sortearPerguntas($quantidade);

            if($result !== null){
                return $result;
            }

            else{
                throw new \InvalidArgumentException(ConstantesGenericasUtil::SEM_PERGUNTAS);
            }
        }

        throw new \InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_PERGUNTAS_SEM_QUANTIDADE);
    }
}