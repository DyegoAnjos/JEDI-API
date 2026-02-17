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
        /*Método para a validação do User
        Passa o Email e a senha pela URL, e verifica se o login e a senha passados,
        Caso o active seja Y ele é permitido.
        */

        //Pega o login e a senha do request se não define como null
        $login = $this->dados['login'] ?? null;
        $password = $this->dados['password'] ?? null;

        if($login && $password){
            $resultado = $this->SystemUserRepository->repositoryPegarUser($login, $password);

            if ($resultado !== null) {
                return $resultado; // Isso será reconhecido como sucesso pelo novo if do jsonUtil
            }
            elseif ($resultado['active'] === 'N') {
                throw new \InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_USER_NAO_AUTORIZADO);
            }

            else{
                throw new \InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_USER_NAO_REGISTRADO);
            }

        }

        throw new \InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_USER_VAZIO);
    }
}