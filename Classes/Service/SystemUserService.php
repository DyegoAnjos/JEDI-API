<?php

namespace Service;

use InvalidArgumentException;
use Repository\SystemUserRepository;
use Util\ConstantesGenericasUtil;

class SystemUserService
{
    private array $dados;
    private $SystemUserRepository;

    public function __construct($dados = [])
    {
        $this->dados = $dados;
        $this->SystemUserRepository = new SystemUserRepository();
    }

    /**
     * @return string
     */
    function servicePegarUser()
    {
        echo "Cheguei na função";
        $login = $this->dados['login'] ?? null;
        $password = $this->dados['password'] ?? null;

        if ($login && $password) {
            $resultado = $this->SystemUserRepository->repositoryPegarUser($login, $password);

            if ($resultado === null) {
                throw new \InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_USER_NAO_REGISTRADO);
            }

            if (isset($resultado['active']) && $resultado['active'] === 'N') {
                throw new \InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_USER_NAO_AUTORIZADO);
            }

            return $resultado;
        }

        throw new \InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_USER_VAZIO);
    }
}