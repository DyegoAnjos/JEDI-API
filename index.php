<?php

use Util\ConstantesGenericasUtil;
use Util\jsonUtil;
use Util\RotasUtil;
use Validator\RequestValidator;

include 'bootstrap.php';
//Retorna as coisas

try {
    $jsonUtil = new jsonUtil();
    $dadosJson = $jsonUtil->tratarCorpoRequestJson(); // Lê o JSON enviado

    // Pega as rotas e mescla com os dados do JSON
    $requestData = array_merge(RotasUtil::getRotas(), $dadosJson);

    $validator = new RequestValidator($requestData);
    $retorno = $validator->processarRequest();

    $jsonUtil->processarArrayParaRetornar($retorno);

} catch (Exception $e) {
    echo json_encode([
        ConstantesGenericasUtil::TIPO => ConstantesGenericasUtil::TIPO_ERRO,
        ConstantesGenericasUtil::RESPOSTA => $e->getMessage()
    ]);
}
