<?php

namespace Util;

// Garanta que a importação está correta
use Util\ConstantesGenericasUtil;

class JsonUtil
{

    /**
     * @return array
     * @throws \Exception
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

    /**
     * @param $retorno
     * @return void
     */
    public function processarArrayParaRetornar($retorno)
    {
        $dados = [];
        $dados = $retorno;

        $this->retornarJson($dados);
    }

    /**
     * @param $json
     * @return void
     */
    private function retornarJson($json)
    {
        header('Content-Type: application/json');
        header('Cache-Control: no-cache, no-store, must-revalidate');
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
        echo json_encode($json);
        exit;
    }
}