<?php

namespace Service;

use http\Exception\InvalidArgumentException;
use Repository\PartidasPerguntasRepository;
use Util\ConstantesGenericasUtil;

class PartidasPerguntasService
{
    private  array $dados;
    private $PartidasPerguntasRepository;

    public function __construct($dados = [])
    {
        $this->dados = $dados;
        $this->PartidasPerguntasRepository = new PartidasPerguntasRepository();
    }

    public function ranking()
    {
        $tema = $this->dados['id'] ?? null;

        if($tema){
            $resultado = $this->PartidasPerguntasRepository->rankingPorTema($tema);

            if(count($resultado) > 0){
                return $resultado;
            }

            elseif (count($resultado) === 0){
                throw new \InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_RANKING_SEM_REGISTRO);
            }
        }

        throw new \InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_ID_TEMA_OBRIGATORIO);
    }
}