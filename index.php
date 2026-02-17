<?php

use Util\ConstantesGenericasUtil;
use Util\jsonUtil;
use Util\RotasUtil;
use Validator\RequestValidator;

include 'bootstrap.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') exit;

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