<?php

use Util\ConstantesGenericasUtil;
use Util\jsonUtil;
use Util\RotasUtil;
use Validator\RequestValidator;

include 'bootstrap.php';
//Retorna as coisas

try {
    $validator = new RequestValidator(RotasUtil::getRotas());
    $retorno = $validator->processarRequest();

    $jsonUtil = new jsonUtil();
    $jsonUtil->processarArrayParaRetornar($retorno);

} catch (Exception $e) {
    echo json_encode([
        ConstantesGenericasUtil::TIPO => ConstantesGenericasUtil::TIPO_ERRO,
        ConstantesGenericasUtil::RESPOSTA => $e->getMessage()
    ]);
}
