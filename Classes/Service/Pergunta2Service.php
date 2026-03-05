<?php

namespace Service;

use Repository\Pergunta2Repository;
use Util\ConstantesGenericasUtil;

class Pergunta2Service
{
    private $dados;
    private $Pergunta2Repository;

    public function __construct($dados = [])
    {
        $this->dados = $dados;
        $this->Pergunta2Repository = new Pergunta2Repository();
    }

    public function pegarPerguntasService()
    {


        // 1. Verifica se a chave 'quantidade' existe no array de dados da classe
        if (!isset($this->dados['quantidade'])) {
            http_response_code(400);
            echo json_encode(['erro' => 'Body inválido. Envie {"quantidade": N}.']);
            exit;
        }

        $quantidade = (int)$this->dados['quantidade'];

        // 2. Valida se a quantidade é maior que zero
        if ($quantidade <= 0) {
            http_response_code(400);
            echo json_encode(['erro' => 'quantidade deve ser maior que zero.']);
            exit;
        }

        // 3. Se passou pelas validações, executa o sorteio

        $result = $this->Pergunta2Repository->sortearPerguntas($quantidade);

        if ($result !== null) {
            return $result;
        }

        // Caso o repositório não encontre nada
        throw new \InvalidArgumentException(ConstantesGenericasUtil::SEM_PERGUNTAS);
    }
}