<?php

use Util\ConstantesGenericasUtil;
use Util\jsonUtil;
use Util\RotasUtil;
use Validator\RequestValidator;

include 'bootstrap.php';

try {
    $jsonUtil = new jsonUtil();

    $dadosJson = $jsonUtil->tratarCorpoRequestJson();

    $dadosRota = RotasUtil::getRotas();

    $requestData = array_merge($dadosRota, $dadosJson);



    $validator = new RequestValidator($requestData);
    $retorno = $validator->processarRequest();

    $jsonUtil->processarArrayParaRetornar($retorno);

} catch (Exception $e) {
    echo json_encode([
        ConstantesGenericasUtil::TIPO => ConstantesGenericasUtil::TIPO_ERRO,
        ConstantesGenericasUtil::RESPOSTA => $e->getMessage()
    ]);
}