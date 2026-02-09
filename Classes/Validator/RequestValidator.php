<?php

namespace Validator;

use Service\SystemUserService;
use Util\ConstantesGenericasUtil;
use Util\JsonUtil;

class RequestValidator
{
    private $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    /**
     * @return mixed
     */
    public function processarRequest()
    {
        $retorno = null;
        if (in_array($this->request['metodo'], ConstantesGenericasUtil::TIPO_GET, true)) {
            $retorno = $this->get();
        }
        return $retorno;
    }
    private function get()
    {
        $retorno = null;
        $rota = $this->request['rota'];
        $recurso = $this->request['recurso'];

        if ($rota === 'System_user') {
            $usuariosService = new SystemUserService($this->request);
            if($recurso === 'validar'){
                $retorno = $usuariosService->validar();
            }
        }

        if (is_null($retorno)) {
            throw new \InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_RECURSO_INEXISTENTE);
        }

        return $retorno;
    }
}