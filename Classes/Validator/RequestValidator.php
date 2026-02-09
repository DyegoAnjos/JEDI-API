<?php

namespace Validator;

use Service\SystemUserService;
use Util\ConstantesGenericasUtil;
use Util\JsonUtil;

class RequestValidator
{
    //Classe responsável por executar os request
    private $request;

    /**
     * @param $request
     */
    public function __construct($request)
    {
        $this->request = $request;
    }

    /**
     * @return mixed
     */
    public function processarRequest()
    {
        //Função que própriamente processar o Request enviado

        $retorno = null;
        $rota = $this->request['rota'];

        //Verifica se o método do request é um dos métodos permitidos
        if (in_array($this->request['metodo'], ConstantesGenericasUtil::TIPO_REQUEST, true)) {
            //Verifica se a Rota (Tabela) dessa requisição tem permissão para fazer esse método, para os outros métodos botar os outros ifs
            if (in_array($rota, ConstantesGenericasUtil::TIPO_GET, true)) {
                $retorno = $this->get();
            } else {
                throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_TIPO_ROTA);
            }
        }
        return $retorno;
    }

    /**
     * @return string
     */
    private function get()
    {
        //Função para executar os métodos GET
        $retorno = null;
        $rota = $this->request['rota'];
        $recurso = $this->request['recurso'];

        //Distribuição para cada Rota
        switch ($rota) {
            case 'SYSTEM_USER':
                $usuariosService = new SystemUserService($this->request);
                //Verifica qual ação irá ser feita e manda para a sua função
                if($recurso === 'validar'){
                    $retorno = $usuariosService->validar();
                }
            break;

            case is_null($retorno):
                throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_RECURSO_INEXISTENTE);
            break;
        }

        return $retorno;
    }
}