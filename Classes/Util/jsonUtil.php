<?php

namespace Util;

// Garanta que a importação está correta
use Util\ConstantesGenericasUtil;

class jsonUtil
{
    /**
     * Corrigido para "Json" e transformado em método público comum para
     * manter consistência com o uso no seu index.php
     */
    public function tratarCorpoRequestJson()
    {
        try {
            $postJson = json_decode(file_get_contents('php://input'), true);
        } catch (\Exception $e) {
            throw new \Exception("Erro ao tratar o corpo da requisição: " . $e->getMessage());
        }

        if (is_array($postJson) && count($postJson) > 0) {
            return $postJson;
        }

        return [];
    }

    public function processarArrayParaRetornar($retorno)
    {
        $dados = [];
        $dados[ConstantesGenericasUtil::TIPO] = ConstantesGenericasUtil::TIPO_ERRO;
        $dados[ConstantesGenericasUtil::RESPOSTA] = $retorno;

        // Se o retorno não for nulo, vazio ou falso, é sucesso
        if ($retorno !== null && $retorno !== false && $retorno !== '') {
            $dados[ConstantesGenericasUtil::TIPO] = ConstantesGenericasUtil::TIPO_SUCESSO;
        }

        $this->retornarJson($dados);
    }

    private function retornarJson($json)
    {
        header('Content-Type: application/json');
        header('Cache-Control: no-cache, no-store, must-revalidate');
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
        echo json_encode($json);
        exit;
    }
}