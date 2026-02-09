<?php

use Util\ConstantesGenericasUtil;
use Util\jsonUtil;
use Util\RotasUtil;
include 'bootstrap.php';
//Retorna as coisas

try {
    $validator = new \Validator\RequestValidator(RotasUtil::getRotas());
    $retorno = $validator->processarRequest();

    $jsonUtil = new jsonUtil();
    $jsonUtil->processarArrayParaRetornar($retorno);

} catch (Exception $e) {
    echo json_encode([
        ConstantesGenericasUtil::TIPO => ConstantesGenericasUtil::TIPO_ERRO,
        ConstantesGenericasUtil::RESPOSTA => $e->getMessage()
    ]);
}
