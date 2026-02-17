<?php

namespace Validator;

use Service\PartidasPerguntasService;
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
            switch ($this->request['metodo']) {
                case 'GET':
                    if (in_array($rota, ConstantesGenericasUtil::TIPO_GET, true)) {
                        $retorno = $this->get();
                    }
                    else {
                        throw new \InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_TIPO_ROTA);
                    }
                break;
                case 'POST':
                    if (in_array($rota, ConstantesGenericasUtil::TIPO_POST, true)) {
                        $retorno = $this->post();
                    }
                    else {
                        throw new \InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_TIPO_ROTA);
                    }
                break;
            }
            //Verifica se a Rota (Tabela) dessa requisição tem permissão para fazer esse método, para os outros métodos botar os outros ifs
        }
        return $retorno;
    }

    /**
     * @return string
     */
    private function post()
    {
        //Função para executar os métodos post
        $retorno = null;
        $rota = $this->request['rota'];
        $recurso = $this->request['recurso'];

        //Distribuição para cada Rota
        switch ($rota) {
            case 'SYSTEM_USER':
                $usuariosService = new SystemUserService($this->request);
                //Verifica qual ação irá ser feita e manda para a sua função
                if($recurso === 'listar'){
                    $retorno = $usuariosService->servicePegarUser();
                }
            break;

            case 'PARTIDASPERGUNTAS':
                $partidasPerguntasService = new PartidasPerguntasService($this->request);

                if($recurso === 'ranking'){
                    $retorno = $partidasPerguntasService->serviceRanking();
                }
            break;

            case is_null($retorno):
                throw new \InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_RECURSO_INEXISTENTE);
            break;
        }

        return $retorno;
    }

    private function get(){
        $retorno = null;
        $rota = $this->request['rota'];
        $recurso = $this->request['recurso'];
        switch ($rota) {
            case 'PARTIDASPERGUNTAS':
                $partidasPerguntasService = new PartidasPerguntasService($this->request);

                if($recurso === 'ranking'){
                    $retorno = $partidasPerguntasService->serviceRanking();
                }
            break;

            case is_null($retorno):
                throw new \InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_RECURSO_INEXISTENTE);
            break;
        }

        return $retorno;
    }
}