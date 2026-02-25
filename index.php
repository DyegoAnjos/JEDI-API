<?php
// ponto de entrada principal da API

// exibiremos erros em ambiente de desenvolvimento, mas o bootstrap já define
// E_ERROR; ajuste conforme necessário para produção
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'bootstrap.php'; // registra autoload e constantes

try {
    // monta o array com método/rota/recurso/id
    $request = \Util\RotasUtil::getRotas();

    // valida e processa a requisição
    $validator = new \Validator\RequestValidator($request);
    $resultado = $validator->processarRequest();

    header('Content-Type: application/json');
    echo json_encode($resultado);
} catch (\Throwable $e) {
    // qualquer exceção retorna código 400 com mensagem JSON
    http_response_code(400);
    header('Content-Type: application/json');
    echo json_encode(['erro' => $e->getMessage()]);
}
