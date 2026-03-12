<?php

namespace Validator;

use Service\Pergunta2Service;
use Util\JsonUtil;
use Service\SystemUserService;
use Service\PartidasPerguntasService;
use Util\ConstantesGenericasUtil;
use Util\RotasUtil;

class RequestValidator
{
    //Classe responsável por executar os request
    private $request;
    private $dadosRequest;

    /**
     * @param $request
     */
    public function __construct($request)
    {
        $this->request = $request;
        // Captura os dados (JSON ou POST) de forma automática e universal
        $this->dadosRequest = \Util\RotasUtil::getRequest();
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
                case 'POST':
                    if (in_array($rota, ConstantesGenericasUtil::TIPO_POST, true)) {
                        $retorno = $this->post();
                    }
                    else {
                        throw new \InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_TIPO_ROTA . " Rota: " . $rota);
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
        $retorno = null;
        $rota = $this->request['rota'];
        $recurso = $this->request['recurso'];

        switch ($rota) {
            case 'SYSTEM_USER':
                $usuariosService = new SystemUserService($this->dadosRequest);

                if($recurso === 'autenticar'){
                    $retorno = $usuariosService->servicePegarUser();
                }
            break;

            case 'PARTIDASPERGUNTAS':
                $partidasPerguntasService = new PartidasPerguntasService($this->dadosRequest);
                if($recurso === 'ranking'){
                    $retorno = $partidasPerguntasService->serviceRanking();
                }

                elseif ($recurso === 'salvarPartida'){
                    $retorno = $partidasPerguntasService->serviceSalvarPartida();
                }
            break;

            case 'PERGUNTA2':
                $pergunta2Service = new Pergunta2Service($this->dadosRequest);
                if($recurso === 'sortearPerguntas'){
                    $retorno = $pergunta2Service->pegarPerguntasService();
                }
            break;
        }

        if (is_null($retorno)) {
            throw new \InvalidArgumentException( ConstantesGenericasUtil::MSG_ERRO_RECURSO_INEXISTENTE . " Recurso: " . $recurso);
        }

        return $retorno;
    }
}