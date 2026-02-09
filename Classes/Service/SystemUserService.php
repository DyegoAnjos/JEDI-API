<?php

namespace Service;

use Repository\SystemUserRepository;
use Util\ConstantesGenericasUtil;

class SystemUserService
{
    private array $dados;
    private object $SystemUserRepository;

    public function __construct($dados = [])
    {
        $this->dados = $dados;
        $this->SystemUserRepository = new SystemUserRepository();
    }

    function validar()
    {
        $login = $this->dados['login'] ?? null;
        $senha = $this->dados['senha'] ?? null;

        if($login && $senha){

            $resultado = $this->SystemUserRepository->validarAcesso($login, $senha);

            if($resultado === 'Y'){
                return ['mensagem' => 'Acesso permitido'];
            }

            throw new \InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_USER_NAO_AUTORIZADO);
        }

        throw new \InvalidArgumentException();
    }
}